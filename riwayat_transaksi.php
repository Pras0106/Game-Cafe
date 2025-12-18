<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

// Cek login
if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login.php");
    exit;
}

// Koneksi database
$conn = new mysqli("localhost", "root", "", "gamecafe_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_pelanggan = $_SESSION['id_pelanggan'];

// Proses cancel booking
if (isset($_POST['cancel_booking'])) {
    $id_booking = (int)$_POST['id_booking'];
    
    // Cek apakah booking milik user ini dan belum dimulai
    $stmt = $conn->prepare("SELECT waktu_mulai FROM booking WHERE id_booking = ?");
    $stmt->bind_param("i", $id_booking);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        $waktu_mulai = new DateTime($booking['waktu_mulai']);
        $now = new DateTime();
        
        // Bisa cancel jika waktu mulai masih lebih dari 1 jam
        if ($waktu_mulai > $now->add(new DateInterval('PT1H'))) {
            $stmt = $conn->prepare("DELETE FROM booking WHERE id_booking = ?");
            $stmt->bind_param("i", $id_booking);
            $stmt->execute();
            $success_msg = "Booking berhasil dibatalkan!";
        } else {
            $error_msg = "Booking tidak bisa dibatalkan kurang dari 1 jam sebelum waktu mulai.";
        }
    }
    $stmt->close();
}

// Ambil riwayat booking (semua booking, termasuk yang sudah lewat)
$sql = "
    SELECT 
        b.*,
        p.tipe as tipe_ps,
        k.tipe_pc
    FROM booking b
    LEFT JOIN playstation p ON b.id_playstation = p.id_playstation
    LEFT JOIN komputer k ON b.id_komputer = k.id_komputer
    ORDER BY b.waktu_mulai DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Game Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <?php include 'navbar.php'; ?>

    <div class="w-full bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 py-6 flex justify-center">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-lime-400 via-emerald-500 to-lime-500
               bg-clip-text text-transparent drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]">
            Riwayat Transaksi
        </h1>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12">

        <?php if (isset($success_msg)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?= htmlspecialchars($success_msg) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_msg)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?= htmlspecialchars($error_msg) ?>
            </div>
        <?php endif; ?>

        <?php if ($result && $result->num_rows > 0): ?>
            
            <div class="space-y-6">
                <?php 
                $now = new DateTime();
                while ($booking = $result->fetch_assoc()): 
                    $waktu_mulai = new DateTime($booking['waktu_mulai']);
                    $waktu_selesai = new DateTime($booking['waktu_selesai']);
                    
                    // Tentukan status
                    $status = "";
                    $status_class = "";
                    $is_active = false;
                    $can_cancel = false;
                    
                    if ($now < $waktu_mulai) {
                        $status = "Akan Datang";
                        $status_class = "bg-blue-100 text-blue-800";
                        $is_active = false;
                        
                        // Cek apakah bisa cancel (lebih dari 1 jam sebelum mulai)
                        $one_hour_before = clone $waktu_mulai;
                        $one_hour_before->sub(new DateInterval('PT1H'));
                        if ($now < $one_hour_before) {
                            $can_cancel = true;
                        }
                    } elseif ($now >= $waktu_mulai && $now <= $waktu_selesai) {
                        $status = "Sedang Berlangsung";
                        $status_class = "bg-green-100 text-green-800";
                        $is_active = true;
                    } else {
                        $status = "Selesai";
                        $status_class = "bg-gray-100 text-gray-800";
                        $is_active = false;
                    }
                    
                    $nama_item = $booking['tipe_sewa'] === 'PlayStation' 
                        ? $booking['tipe_ps'] 
                        : $booking['tipe_pc'];
                    
                    $lokasi = $booking['tipe_sewa'] === 'PlayStation' 
                        ? "PlayStation #{$booking['id_playstation']}" 
                        : "PC #{$booking['id_komputer']}";
                ?>
                
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="p-6">
                        
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">
                                    Booking #<?= htmlspecialchars($booking['id_booking']) ?>
                                </h3>
                                <p class="text-gray-600"><?= htmlspecialchars($nama_item) ?></p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($lokasi) ?></p>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold <?= $status_class ?>">
                                <?= $status ?>
                            </span>
                        </div>

                        <!-- Detail Waktu -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Waktu Mulai</p>
                                <p class="font-semibold">
                                    <?= $waktu_mulai->format('d M Y, H:i') ?> WIB
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Durasi</p>
                                <p class="font-semibold">
                                    <?= htmlspecialchars($booking['durasi']) ?> jam
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Waktu Selesai</p>
                                <p class="font-semibold">
                                    <?= $waktu_selesai->format('d M Y, H:i') ?> WIB
                                </p>
                            </div>
                        </div>

                        <!-- Biaya -->
                        <div class="flex justify-between items-center pt-4 border-t">
                            <div>
                                <p class="text-sm text-gray-600">Total Biaya</p>
                                <p class="text-2xl font-bold text-emerald-600">
                                    Rp <?= number_format($booking['biaya'], 0, ',', '.') ?>
                                </p>
                            </div>
                            
                            <?php if ($can_cancel): ?>
                                <form method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                    <input type="hidden" name="id_booking" value="<?= $booking['id_booking'] ?>">
                                    <button type="submit" name="cancel_booking"
                                            class="bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600 transition-all">
                                        Batalkan Booking
                                    </button>
                                </form>
                            <?php elseif ($is_active): ?>
                                <div class="flex items-center gap-2 text-green-600">
                                    <span class="animate-pulse">●</span>
                                    <span class="font-semibold">Aktif Sekarang</span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <?php endwhile; ?>
            </div>

        <?php else: ?>
            
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="text-6xl mb-4">📋</div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Transaksi</h3>
                <p class="text-gray-600 mb-6">Anda belum memiliki riwayat booking</p>
                <div class="flex gap-4 justify-center">
                    <a href="main_ps.php" 
                       class="bg-gradient-to-r from-emerald-500 to-lime-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-600 hover:to-lime-600 transition-all">
                        Booking PlayStation
                    </a>
                    <a href="sewa_pc.php" 
                       class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all">
                        Sewa PC
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <script>
        // Auto refresh setiap 30 detik untuk update status
        setTimeout(() => {
            location.reload();
        }, 30000);
    </script>

</body>
</html>
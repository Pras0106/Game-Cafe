<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION["auth_lock"]);

// Koneksi database
$conn = new mysqli("localhost", "root", "", "gamecafe_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query cemilan/makanan minuman
$sql = "SELECT * FROM food_or_drink ORDER BY kategori ASC, nama ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cemilan & Minuman - Game Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50">

    <?php include 'navbar.php'; ?>

    <div class="w-full bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 py-6 flex justify-center">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-lime-400 via-emerald-500 to-lime-500
               bg-clip-text text-transparent drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
               relative
               after:content-[''] after:absolute after:left-0 after:-bottom-1
               after:w-0 after:h-[4px] after:bg-lime-400 after:transition-all after:duration-300 hover:after:w-full">
            Cemilan & Minuman
        </h1>
    </div>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-600 via-gray-700 to-gray-600 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
                    bg-clip-text text-transparent drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)] mb-4">
                    Nikmati Makanan & Minuman Favorit Anda
                </h2>
                <p class="text-lime-400 text-lg font-semibold drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]">
                    Tersedia berbagai pilihan makanan ringan dan minuman segar untuk menemani waktu bermain Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="max-w-7xl mx-auto px-6 py-12">
        
        <?php if ($result && $result->num_rows > 0): ?>
            
            <?php
            // Kelompokkan berdasarkan kategori
            $items_by_category = [];
            while ($item = $result->fetch_assoc()) {
                $kategori = $item['kategori'] ?? 'Lainnya';
                if (!isset($items_by_category[$kategori])) {
                    $items_by_category[$kategori] = [];
                }
                $items_by_category[$kategori][] = $item;
            }
            ?>

            <?php foreach ($items_by_category as $kategori => $items): ?>
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-lime-500">
                        <?= htmlspecialchars($kategori) ?>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach ($items as $item): ?>
                            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                
                                <?php if (!empty($item['url_gambar'])): ?>
                                    <img src="<?= htmlspecialchars($item['url_gambar']) ?>" 
                                         class="w-full h-48 object-cover" 
                                         alt="<?= htmlspecialchars($item['nama']) ?>">
                                <?php else: ?>
                                    <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 text-4xl">🍽️</span>
                                    </div>
                                <?php endif; ?>

                                <div class="p-4">
                                    <h4 class="font-bold text-lg text-gray-800 mb-2">
                                        <?= htmlspecialchars($item['nama']) ?>
                                    </h4>
                                    
                                    <?php if (!empty($item['deskripsi'])): ?>
                                        <p class="text-sm text-gray-600 mb-3">
                                            <?= htmlspecialchars($item['deskripsi']) ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-xl font-bold text-emerald-600">
                                            Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                        </span>
                                        
                                        <?php if ($item['stok'] > 0): ?>
                                            <span class="text-sm text-green-600 font-semibold">
                                                Stok: <?= number_format($item['stok'], 0) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-sm text-red-600 font-semibold">
                                                Habis
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (isset($_SESSION['id_pelanggan']) && $item['stok'] > 0): ?>
                                        <button onclick="pesanItem(<?= $item['id_food'] ?>, '<?= htmlspecialchars(addslashes($item['nama'])) ?>', <?= $item['harga'] ?>)"
                                            class="mt-4 w-full bg-gradient-to-r from-emerald-500 to-lime-500 text-white font-semibold py-2 rounded-lg hover:from-emerald-600 hover:to-lime-600 transition-all">
                                            Pesan Sekarang
                                        </button>
                                    <?php elseif (!isset($_SESSION['id_pelanggan'])): ?>
                                        <a href="login.php" 
                                           class="mt-4 block w-full bg-gray-400 text-white font-semibold py-2 rounded-lg text-center hover:bg-gray-500 transition-all">
                                            Login untuk Pesan
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="text-center py-16">
                <div class="text-6xl mb-4">🍕</div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Menu Segera Hadir</h3>
                <p class="text-gray-600">Kami sedang menyiapkan menu cemilan dan minuman yang lezat untuk Anda</p>
            </div>
        <?php endif; ?>

    </section>

    <script>
        function pesanItem(id, nama, harga) {
            if (confirm(`Pesan ${nama}?\nHarga: Rp ${harga.toLocaleString('id-ID')}`)) {
                // Implementasi pemesanan
                // Bisa redirect ke halaman checkout atau tambah ke keranjang
                alert('Fitur pemesanan akan segera tersedia!');
                // window.location.href = `checkout.php?id=${id}`;
            }
        }
    </script>

</body>
</html>
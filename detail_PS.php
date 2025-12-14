<?php
session_start(); // jika perlu navbar pakai session
// koneksi DB
$conn = new mysqli("localhost", "root", "", "gamecafe_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil id dari query string dan validasi
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID PlayStation tidak valid.");
}
$id = (int) $_GET['id'];

// Ambil data playstation (prepared statement lebih aman)
$stmt = $conn->prepare("SELECT id_playstation, harga, tipe, status, url_gambar FROM playstation WHERE id_playstation = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$rs = $stmt->get_result();
$ps = $rs->fetch_assoc();
$stmt->close();

if (!$ps) {
    die("PlayStation tidak ditemukan.");
}

// Ambil aksesoris yang berelasi
$stmt = $conn->prepare("
    SELECT id_aksesoris, id_playstation, nama, url_gambar
    FROM aksesoris_ps
    WHERE id_playstation = ?
    ORDER BY id_aksesoris ASC
");
$stmt->bind_param("i", $id);

$stmt->execute();
$accRes = $stmt->get_result();
$aksesoris = $accRes->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Detail PlayStation #<?= (int)$ps['id_playstation'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .product-thumbnail {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
        }

        .thumbnail-active {
            outline: 3px solid #10B981;
        }

        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="bg-white text-gray-900">
    <?php include 'navbar.php'; ?>
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- KOLOM GAMBAR -->
        <div>
            <img id="mainImage" src="<?= htmlspecialchars($ps['url_gambar']) ?>" class="w-full h-96 object-contain bg-gray-100 rounded-xl" alt="Gambar utama">
            <div class="flex gap-3 mt-3" id="thumbnailContainer">
                <!-- Thumbnail pertama: PlayStation -->
                <img class="product-thumbnail thumbnail-item thumbnail-active"
                    src="<?= htmlspecialchars($ps['url_gambar']) ?>"
                    data-full="<?= htmlspecialchars($ps['url_gambar']) ?>"
                    data-type="ps"
                    data-name="<?= htmlspecialchars($ps['tipe']) ?>"
                    alt="PlayStation">

                <!-- Thumbnails aksesoris -->
                <?php foreach ($aksesoris as $a): ?>
                    <img class="product-thumbnail thumbnail-item"
                        src="<?= htmlspecialchars($a['url_gambar']) ?>"
                        data-full="<?= htmlspecialchars($a['url_gambar']) ?>"
                        data-type="aksesoris"
                        data-name="<?= htmlspecialchars($a['nama']) ?>"
                        alt="<?= htmlspecialchars($a['nama']) ?>">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- KOLOM INFO -->
        <div>
            <h1 id="title" class="text-3xl font-bold relative inline-block after:content-[''] after:absolute after:left-0 after:-bottom-1 after:w-0 after:h-[3px] after:bg-black after:transition-all after:duration-300 hover:after:w-full"><?= htmlspecialchars($ps['tipe']) ?></h1>

            <br>
            <p id="status"
                class="mt-2 <?= $ps['status'] === 'Tersedia'
                                ? "relative inline-block after:content-[''] after:absolute after:left-0 after:-bottom-1 after:w-0 after:h-[3px] after:bg-green-700 after:transition-all after:duration-300 hover:after:w-full text-green-600"
                                : "relative inline-block after:content-[''] after:absolute after:left-0 after:-bottom-1 after:w-0 after:h-[3px] after:bg-red-700 after:transition-all after:duration-300 hover:after:w-full text-red-600"
                            ?>">
                <?= htmlspecialchars($ps['status']) ?>
            </p>

            <p class="mt-3 text-gray-700">
                Lokasi : Nomor <?= (int)$ps['id_playstation'] ?>
            </p>

            <p class="mt-4 text-xl font-semibold" id="price">Rp <?= number_format($ps['harga'], 0, ',', '.') ?> / jam</p>

            <div class="mt-6 flex gap-3">
                <?php
                $bookingLink = isset($_SESSION['id_pelanggan'])
                ? "booking.php?tipe=playstation&id=" . (int)$ps['id_playstation']
                : "login.php?redirect=booking&tipe=playstation&id=" . (int)$ps['id_playstation'];            
                ?>

                <a href="<?= $bookingLink ?>"
                    class="px-4 py-3 bg-black text-white rounded-full font-semibold">
                    Booking
                </a>

                <a href="main_ps.php" class="px-4 py-3 border rounded-full">Kembali</a>
            </div>

            <!-- opsional: list aksesoris -->
            <?php if (count($aksesoris) > 0): ?>
                <h3 class="mt-8 text-lg font-semibold">Aksesoris tersedia</h3>
                <ul class="mt-2 space-y-2">
                    <?php foreach ($aksesoris as $a): ?>
                        <li class="flex items-center gap-3">
                            <img src="<?= htmlspecialchars($a['url_gambar']) ?>" class="w-12 h-12 object-cover rounded" alt="<?= htmlspecialchars($a['nama']) ?>">
                            <span><?= htmlspecialchars($a['nama']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </div>

    <script>
        // Switch main image jika thumbnail diklik
        document.querySelectorAll('.thumbnail-item').forEach(th => {
            th.addEventListener('click', function() {
                // update main image
                const url = this.getAttribute('data-full');
                document.getElementById('mainImage').src = url;

                // update active class
                document.querySelectorAll('.thumbnail-item').forEach(t => t.classList.remove('thumbnail-active'));
                this.classList.add('thumbnail-active');

                // jika thumbnail punya data-name (aksesoris) kita bisa update title/per info
                const name = this.getAttribute('data-name') || '';
                const type = this.getAttribute('data-type') || '';
                // contoh: jika aksesoris, ganti judul kecil (opsional)
                if (type === 'aksesoris' && name) {
                    // misal tampilkan nama aksesoris sebagai product label sementara (pilih sendiri)
                    //document.getElementById('title').innerText = name;
                } else {
                    // bila ingin restore ke tipe playstation: tidak diubah
                    // document.getElementById('title').innerText = "<?= addslashes(htmlspecialchars($ps['tipe'])) ?>";
                }
            });
        });
    </script>
</body>

</html>
<?php
session_start();

date_default_timezone_set('Asia/Jakarta');

/* ======================
   1. CEK LOGIN
====================== */
if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login.php");
    exit;
}

/* ======================
   2. KONEKSI DATABASE
====================== */
$conn = new mysqli("localhost", "root", "", "gamecafe_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

/* ======================
   3. VALIDASI ID
====================== */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}
$id = (int) $_GET['id'];

/* ======================
   4. DETEKSI TIPE SEWA
====================== */
if (!isset($_GET['tipe']) || !in_array($_GET['tipe'], ['komputer', 'playstation'])) {
    die("Tipe sewa tidak valid.");
}

$tipe = $_GET['tipe'];

if ($tipe === 'playstation') {

    $stmt = $conn->prepare("SELECT id_playstation, harga, tipe FROM playstation WHERE id_playstation = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    if (!$data) die("PlayStation tidak ditemukan.");

    $tipe_sewa = "PlayStation";
    $harga_per_jam = $data['harga'];
    $id_playstation = $data['id_playstation'];
    $id_komputer = null;
} else {

    $stmt = $conn->prepare("SELECT id_komputer, harga_per_jam, tipe_pc FROM komputer WHERE id_komputer = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    if (!$data) die("Komputer tidak ditemukan.");

    $tipe_sewa = "Komputer";
    $harga_per_jam = $data['harga_per_jam'];
    $id_komputer = $data['id_komputer'];
    $id_playstation = null;
}

$stmt->close();

/* ======================
   5. PROSES FORM
====================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $waktu_mulai = $_POST['waktu_mulai'];
    $durasi = $_POST['durasi']; // HH:MM

    // ======================
    // VALIDASI WAKTU MULAI TIDAK BOLEH LEWAT
    // ======================
    $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
    $dt_mulai_check = new DateTime($waktu_mulai, new DateTimeZone('Asia/Jakarta'));

    if ($dt_mulai_check <= $now) {
        die("❌ Waktu mulai harus lebih besar dari waktu sekarang.");
    }

    // VALIDASI DURASI (HARUS KELIPATAN 1 JAM, 01:00 - 24:00)
    if (!preg_match('/^(0[1-9]|1[0-9]|2[0-4]):00$/', $durasi)) {
        die("Durasi tidak valid. Durasi harus antara 1 sampai 24 jam.");
    }

    $dt_mulai = new DateTime($waktu_mulai);

    // durasi HH:MM → jam
    list($jam, $menit) = explode(':', $durasi);

    // tambah jam
    $dt_mulai->add(new DateInterval("PT{$jam}H"));

    // hasil akhir
    $waktu_selesai = $dt_mulai->format("Y-m-d H:i:s");

    // ======================
    // VALIDASI BENTROK JAM
    // ======================
    if ($tipe === 'playstation') {

        $sql = "
        SELECT 1 FROM booking
        WHERE id_playstation = ?
        AND (
            waktu_mulai < ?
            AND waktu_selesai > ?
        )
        LIMIT 1
    ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $id_playstation, $waktu_selesai, $waktu_mulai);
    } else {

        $sql = "
        SELECT 1 FROM booking
        WHERE id_komputer = ?
        AND (
            waktu_mulai < ?
            AND waktu_selesai > ?
        )
        LIMIT 1
    ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $id_komputer, $waktu_selesai, $waktu_mulai);
    }

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("❌ Waktu booking bentrok dengan booking lain. Silakan pilih waktu lain.");
    }

    $stmt->close();


    // hitung biaya
    list($jam, $menit) = explode(":", $durasi);
    $total_jam = $jam + ($menit / 60);
    $biaya = $total_jam * $harga_per_jam;

    // insert booking
    $stmt = $conn->prepare("
        INSERT INTO booking (
            id_playstation, id_komputer, tipe_sewa,
            waktu_mulai, durasi, waktu_selesai, biaya,
            nama_kartu_debit_or_credit,
            nomor_kartu_debit_or_credit,
            waktu_kadaluarsa_kartu_debit_or_credit,
            pin_kartu_debit_or_credit
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "iissssdssss",
        $id_playstation,
        $id_komputer,
        $tipe_sewa,
        $waktu_mulai,
        $durasi,
        $waktu_selesai,
        $biaya,
        $_POST['nama_kartu'],
        $_POST['nomor_kartu'],
        $_POST['expired'],
        $_POST['pin']
    );

    $stmt->execute();
    $stmt->close();

    header("Location: riwayat_transaksi.php");
    exit;
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Booking <?= htmlspecialchars($tipe_sewa) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <div class="max-w-xl mx-auto bg-white p-6 mt-10 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">
            Booking <?= htmlspecialchars($tipe_sewa) ?>
        </h1>

        <p class="mb-2 font-semibold">
            Harga: Rp <?= number_format($harga_per_jam, 0, ',', '.') ?> / jam
        </p>

        <form method="POST" class="space-y-4">

            <div>
                <label class="block font-semibold">Waktu Mulai</label>
                <input
                    type="datetime-local"
                    name="waktu_mulai"
                    required
                    step="60"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold">Durasi (Jam)</label>
                <select name="durasi" required
                    class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Durasi --</option>
                    <?php for ($i = 1; $i <= 24; $i++): ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>:00">
                            <?= $i ?> Jam
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Waktu Selesai</label>
                <input type="datetime-local" name="waktu_selesai_display" readonly
                    class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
            </div>


            <hr>

            <div>
                <label class="block font-semibold">Nama Kartu</label>
                <input type="text" name="nama_kartu" required class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="block font-semibold">Nomor Kartu</label>
                <input type="text" name="nomor_kartu" required class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="block font-semibold">Kadaluarsa (MM/YY)</label>
                <input type="date" name="expired" required class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="block font-semibold">PIN</label>
                <input type="password" name="pin" maxlength="6" required class="w-full border px-3 py-2 rounded">
            </div>

            <button class="w-full bg-black text-white py-3 rounded font-semibold">
                Konfirmasi Booking
            </button>
        </form>
    </div>

    <script>
        const waktuMulaiInput = document.querySelector('input[name="waktu_mulai"]');
        const durasiSelect = document.querySelector('select[name="durasi"]');
        const waktuSelesaiInput = document.querySelector('input[name="waktu_selesai_display"]');

        function updateMinTime() {
            const now = new Date();

            const yyyy = now.getFullYear();
            const mm = String(now.getMonth() + 1).padStart(2, '0');
            const dd = String(now.getDate()).padStart(2, '0');
            const hh = String(now.getHours()).padStart(2, '0');
            const min = String(now.getMinutes()).padStart(2, '0');

            waktuMulaiInput.min = `${yyyy}-${mm}-${dd}T${hh}:${min}`;
        }

        updateMinTime();
        setInterval(updateMinTime, 60000); // update tiap 1 menit

        function hitungWaktuSelesai() {
            if (!waktuMulaiInput.value || !durasiSelect.value) {
                waktuSelesaiInput.value = "";
                return;
            }

            const mulai = new Date(waktuMulaiInput.value);
            const [jam] = durasiSelect.value.split(":");

            // tambahkan jam ke waktu mulai
            mulai.setHours(mulai.getHours() + parseInt(jam));

            // format ke datetime-local (YYYY-MM-DDTHH:MM)
            const yyyy = mulai.getFullYear();
            const mm = String(mulai.getMonth() + 1).padStart(2, '0');
            const dd = String(mulai.getDate()).padStart(2, '0');
            const hh = String(mulai.getHours()).padStart(2, '0');
            const min = String(mulai.getMinutes()).padStart(2, '0');

            waktuSelesaiInput.value = `${yyyy}-${mm}-${dd}T${hh}:${min}`;
        }

        waktuMulaiInput.addEventListener('change', hitungWaktuSelesai);
        durasiSelect.addEventListener('change', hitungWaktuSelesai);
    </script>

</body>

</html>
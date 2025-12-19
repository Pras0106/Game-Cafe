<?php
session_start();

// CEK LOGIN
if (!isset($_SESSION["id_pelanggan"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gamecafe_db");
if ($conn->connect_error) {
    die("Koneksi gagal");
}

$id = $_SESSION["id_pelanggan"];
$message = "";

// AMBIL DATA USER
$data = $conn->query("SELECT * FROM pelanggan WHERE id_pelanggan = $id")->fetch_assoc();

// =====================
// UPDATE USERNAME
// =====================
if (isset($_POST["update_username"])) {
    $username_baru = $_POST["username"];

    $conn->query("UPDATE pelanggan 
                  SET nama_pelanggan='$username_baru' 
                  WHERE id_pelanggan=$id");

    $_SESSION["nama"] = $username_baru;
    $message = "Username berhasil diperbarui";
}

// =====================
// UPDATE PASSWORD
// =====================
if (isset($_POST["update_password"])) {
    $pass_lama = $_POST["password_lama"];
    $pass_baru = $_POST["password_baru"];

    if ($pass_lama === $data["password"]) {
        $conn->query("UPDATE pelanggan 
                      SET password='$pass_baru' 
                      WHERE id_pelanggan=$id");

        $message = "Password berhasil diubah";
    } else {
        $message = "Password lama salah";
    }
}

// HITUNG SISA WAKTU
$menit = $data["sisa_waktu"];
$jam = floor($menit / 60);
$sisa_menit = $menit % 60;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-16 bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-4">Profil Pengguna</h2>

    <?php if ($message): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <p><b>Email:</b> <?= $data["email"] ?></p>
    <p class="mb-4"><b>Username:</b> <?= $data["nama_pelanggan"] ?></p>

    <hr class="my-4">

    <!-- SISA WAKTU -->
    <h3 class="font-bold mb-2">Sisa Waktu Bermain</h3>
    <p class="text-lg text-red-600">
        <?= $jam ?> jam <?= $sisa_menit ?> menit
    </p>

    <hr class="my-4">

    <!-- FORM GANTI USERNAME -->
    <form method="POST" class="mb-4">
        <h3 class="font-bold mb-2">Ganti Username</h3>
        <input type="text" name="username" class="w-full border p-2 rounded mb-2" required>
        <button name="update_username" class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan Username
        </button>
    </form>

    <!-- FORM GANTI PASSWORD -->
    <form method="POST">
        <h3 class="font-bold mb-2">Ganti Password</h3>
        <input type="password" name="password_lama" placeholder="Password lama"
            class="w-full border p-2 rounded mb-2" required>

        <input type="password" name="password_baru" placeholder="Password baru"
            class="w-full border p-2 rounded mb-2" required>

        <button name="update_password" class="bg-red-600 text-white px-4 py-2 rounded">
            Ganti Password
        </button>
    </form>

</div>

</body>
</html>


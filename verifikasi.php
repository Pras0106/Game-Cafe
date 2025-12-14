<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cegah browser menyimpan halaman (anti back button)
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gamecafe_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error = "";

// Pastikan ada data dari create_account.php
if (!isset($_SESSION["pending_register"])) {
    header("Location: create_account.php");
    exit();
}

$data       = $_SESSION["pending_register"];
$next_id    = $data["next_id"];  // <--- ID PELANGGAN DARI create_account.php
$kode_asli  = $data["kode"];
$nama       = $data["nama"];
$email      = $data["email"];
$password   = $data["password"];
$device_id  = $data["device_id"];
$nomor_telepon = $data["nomor_telepon"];
$waktu_buat = $data["created_at"];

// Cek expired 5 menit
if (time() - $waktu_buat > 300) {
    unset($_SESSION["pending_register"]);
    header("Location: create_account.php?timeout=1");
    exit();
}

// Jika user submit kode verifikasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $kode_input = trim($_POST["kode_verifikasi"]);

    if (empty($kode_input)) {
        $error = "Kode tidak boleh kosong.";
    } elseif ($kode_input != $kode_asli) {
        $error = "Kode verifikasi salah!";
    } else {

        // KODE BENAR → MASUKKAN KE DATABASE (safe retry, isi id manual)
        $nextId = isset($data['next_id']) ? (int)$data['next_id'] : 0;
        $namaEsc = $conn->real_escape_string($nama);
        $emailEsc = $conn->real_escape_string($email);
        $passEsc = $conn->real_escape_string($password); // nanti gunakan password_hash()
        $deviceEsc = $conn->real_escape_string($device_id);
        $teleponEsc = $conn->real_escape_string($nomor_telepon);

        $maxAttempts = 1000; // batasi percobaan supaya tidak infinite loop
        $attempt = 0;
        $inserted = false;

        while (!$inserted && $attempt < $maxAttempts) {
            $attempt++;

            $sql = sprintf(
                "INSERT INTO pelanggan (
                    id_pelanggan,
                    nama_pelanggan,
                    email,
                    password,
                    nomor_telepon,
                    status_member,
                    saldo_waktu_ps,
                    saldo_waktu_pc,
                    device_id
                ) VALUES (
                    %d, '%s', '%s', '%s', '%s',
                    'regular', '00:00:00', '00:00:00', '%s'
                )",
                $nextId,
                $namaEsc,
                $emailEsc,
                $passEsc,
                $teleponEsc,
                $deviceEsc
            );

            if ($conn->query($sql)) {
                // berhasil
                $inserted = true;
                unset($_SESSION["pending_register"]);
                unset($_SESSION["auth_lock"]);  // <<< WAJIB ADA!
                $_SESSION["id_pelanggan"] = $nextId;
                $_SESSION["nama"] = $nama;
                header("Location: dashboard.php");
                exit();
            } else {
                // duplicate key error kode MySQL = 1062
                if ($conn->errno == 1062) {
                    // id ini sudah dipakai, naikkan dan coba lagi
                    $nextId++;
                    continue;
                } else {
                    // error lain -> stop dan lapor
                    $error = "Gagal menyimpan akun: " . $conn->error;
                    break;
                }
            }
        }

        if (!$inserted && empty($error)) {
            $error = "Gagal membuat akun setelah beberapa percobaan. Coba lagi nanti.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <script>
        function generateFingerprint() {
            let fp = navigator.userAgent +
                screen.width +
                screen.height +
                navigator.language +
                Intl.DateTimeFormat().resolvedOptions().timeZone;
            return btoa(fp); // encode agar aman di server
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("deviceField").value = generateFingerprint();
        });
    </script>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Cafe Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body,
        html {
            width: 100%;
            min-height: 100%;
            overflow-y: auto;
            /* <-- allow scroll */
            background: #000;
        }

        /* Spline background */
        .bg-spline {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .bg-spline iframe {
            width: 100%;
            height: 100%;
            border: none;
            pointer-events: none;
            /* default tidak interaktif */
        }

        /* SECTION WRAPPER */
        .section {
            position: relative;
            width: 100%;
            min-height: 100vh;
            /* Fullscreen height */
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding-left: 40px;
            padding-top: 120px;
            z-index: 10;
            pointer-events: none;
        }

        /* Form Box */
        .register-box {
            width: 340px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            position: absolute;
            z-index: 20;
            cursor: move;
            pointer-events: auto;
        }

        .input-line {
            width: 100%;
            padding: 14px 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .input-underline {
            width: 100%;
            padding: 10px 0;
            font-size: 15px;
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
        }

        .input-underline:focus {
            border-bottom: 1px solid black;
        }

        .btn-create {
            width: 100%;
            background: #e53935;
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            margin-bottom: 18px;
        }

        .btn-create:hover {
            background: #c62828;
        }

        .btn-google {
            width: 100%;
            border: 1px solid #ccc;
            padding: 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            background: white;
        }

        .btn-google:hover {
            background: #f5f5f5;
        }

        .google-icon {
            width: 20px;
        }

        /* FOOTER (NOT FIXED) */
        footer {
            width: 100%;
            background: #000;
            color: #fff;
            padding: 60px 80px 30px;
            z-index: 20;
            position: relative;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-box h3 {
            font-size: 18px;
            margin-bottom: 14px;
        }

        .footer-box p,
        .footer-box a {
            font-size: 14px;
            line-height: 1.8;
            color: #ccc;
            text-decoration: none;
        }

        .footer-box a:hover {
            color: white;
        }

        .footer-input {
            margin-top: 10px;
            display: flex;
            align-items: center;
            border: 1px solid #777;
            border-radius: 6px;
            overflow: hidden;
            width: 220px;
        }

        .footer-input input {
            flex: 1;
            padding: 10px;
            border: none;
            background: transparent;
            outline: none;
            color: white;
        }

        .footer-input button {
            padding: 10px 14px;
            background: transparent;
            border: none;
            cursor: pointer;
            color: white;
        }

        .copyright {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
            border-top: 1px solid #222;
            padding-top: 12px;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <!-- Spline Background -->
    <div class="bg-spline">
        <iframe src="https://my.spline.design/boxeshover-ZrkOuhJRUFOiCbMsVEdIHJk0/" frameborder="0" width="100%"
            height="100%" style="border:0;">
        </iframe>
    </div>

    <!-- SECTION 1: FORM -->
    <section class="section">
        <div class="register-box">

            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 6px;">Verifikasi Akun</h1>
            <p style="color:#555; margin-bottom: 26px;">Isi kolom berikut dengan kode 8 digit yang sudah kami kirim lewat email anda</p>

            <?php if (!empty($error)): ?>
                <p style="color:red; margin-bottom:10px; font-weight:bold;">
                    <?= $error ?>
                </p>
            <?php endif; ?>

            <form method="POST">

                <input type="hidden" id="deviceField" name="device_id">

                <div style="width:100%; margin-bottom:22px;">
                    <input type="text" name="kode_verifikasi" placeholder="kode verifikasi"
                        style="width:100%; padding:10px 0; border:none; border-bottom:1px solid #ccc; outline:none; font-size:15px;">
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
                    <button type="submit" style="
            background: #21b57f;
            border:none;
            padding:12px 32px;
            color:#fff;
            border-radius:6px;
            font-weight:bold;
            cursor:pointer;
        ">Kirim kode</button>
                </div>

            </form>

        </div>
    </section>

    <script>
        const box = document.querySelector('.register-box');
        let drag = false;
        let offsetX = 0,
            offsetY = 0;

        box.addEventListener("mousedown", (e) => {
            drag = true;
            offsetX = e.clientX - box.getBoundingClientRect().left;
            offsetY = e.clientY - box.getBoundingClientRect().top;
            box.style.cursor = "grabbing";
        });

        document.addEventListener("mousemove", (e) => {
            if (drag) {
                box.style.left = `${e.clientX - offsetX}px`;
                box.style.top = `${e.clientY - offsetY}px`;
            }
        });

        document.addEventListener("mouseup", () => {
            drag = false;
            box.style.cursor = "move";
        });
    </script>

    <script>
        const iframe = document.querySelector(".bg-spline iframe");

        // Jika mouse berada di area atas (tanpa menabrak form / footer), aktifkan interaksi
        document.addEventListener("mousemove", (e) => {
            const box = document.querySelector(".register-box");

            const boxRect = box.getBoundingClientRect();
            const isHoverForm =
                e.clientX >= boxRect.left &&
                e.clientX <= boxRect.right &&
                e.clientY >= boxRect.top &&
                e.clientY <= boxRect.bottom;

            // Jika sedang hover form → nonaktifkan interaksi Spline supaya UI bisa diklik
            if (isHoverForm) {
                iframe.style.pointerEvents = "none";
                return;
            }

            // Selain itu → Spline interaktif
            iframe.style.pointerEvents = "auto";
        });
    </script>



</body>

</html>
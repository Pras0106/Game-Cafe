<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika user masih login, larang akses create_account.php
if (isset($_SESSION["id_pelanggan"])) {
    header("Location: dashboard.php");
    exit();
}

// Kunci mode agar user tidak bisa login di tab lain
$_SESSION["auth_lock"] = "register";
// Cegah browser menyimpan halaman (anti back button)
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gamecafe_db";

// IMPORT PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/PHPMailer-master/src/PHPMailer.php";
require __DIR__ . "/PHPMailer-master/src/SMTP.php";
require __DIR__ . "/PHPMailer-master/src/Exception.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = trim($_POST["nama_pelanggan"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $nomor_telepon = trim($_POST["nomor_telepon_full"] ?? '');

    // VALIDASI NOMOR TELEPON (SERVER SIDE)
    if (!preg_match('/^\+62[0-9]{9,13}$/', $nomor_telepon)) {
        $error = "Nomor telepon tidak valid.";
        goto skipInsert;
    }    

    $cekTelepon = "SELECT 1 FROM pelanggan WHERE nomor_telepon = '$nomor_telepon' LIMIT 1";
    $resTelepon = $conn->query($cekTelepon);

    if ($resTelepon->num_rows > 0) {
        $error = "Nomor telepon sudah terdaftar.";
        goto skipInsert;
    }

    $device_id = $_POST["device_id"];

    if (empty($nama) || empty($email) || empty($password)) {
        $error = "Semua field wajib diisi!";
        goto skipInsert;
    }

    // Cek email sudah digunakan
    $cekEmail = "SELECT 1 FROM pelanggan WHERE email = '$email' LIMIT 1";
    $resEmail = $conn->query($cekEmail);
    if ($resEmail->num_rows > 0) {
        $error = "Email sudah terdaftar. Gunakan email lain.";
        goto skipInsert;
    }

    // Cek username sudah digunakan
    $cekNama = "SELECT 1 FROM pelanggan WHERE nama_pelanggan = '$nama' LIMIT 1";
    $resNama = $conn->query($cekNama);
    if ($resNama->num_rows > 0) {
        $error = "Username sudah digunakan. Pilih username lain.";
        goto skipInsert;
    }

    // Cari id_pelanggan terkecil yang belum digunakan mulai dari 0
    $nextId = 0;
    $result = $conn->query("SELECT id_pelanggan FROM pelanggan ORDER BY id_pelanggan ASC");

    if ($result->num_rows > 0) {
        $usedIds = [];
        while ($row = $result->fetch_assoc()) {
            $usedIds[] = (int)$row['id_pelanggan'];
        }

        // Cari angka terendah yang hilang
        while (in_array($nextId, $usedIds)) {
            $nextId++;
        }
    } else {
        $nextId = 0; // Jika database masih kosong, pakai 0
    }


    // Generate kode verifikasi 8 digit
    $kode = rand(10000000, 99999999);

    // Simpan ke session untuk verifikasi nanti
    $_SESSION["pending_register"] = [
        "nama"          => $nama,
        "email"         => $email,
        "password"      => $password,
        "nomor_telepon" => $nomor_telepon, // ⬅ TAMBAHKAN
        "device_id"     => $device_id,
        "kode"          => $kode,
        "next_id"       => $nextId,
        "created_at"    => time()
    ];

    // -------------------------------------------------------------------
    //  SEND EMAIL VERIFIKASI
    // -------------------------------------------------------------------
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "risqiprasdika3@gmail.com";
        $mail->Password = "eqbplixzpbdtaego";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom("risqiprasdika3@gmail.com", "GameCafe");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Kode Verifikasi Akun Anda";
        $mail->Body = "
            <h2>Kode Verifikasi GameCafe</h2>
            <p>Halo <b>$nama</b>, berikut kode verifikasi akun anda:</p>
            <h1 style='letter-spacing:2px;'>$kode</h1>
            <p>Kode ini hanya berlaku 5 menit.</p>
        ";

        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        $mail->send();
    } catch (Exception $e) {
        $error = "Gagal mengirim email: " . $mail->ErrorInfo;
        goto skipInsert;
    }

    header("Location: verifikasi.php");
    exit();

    skipInsert:
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

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

            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 6px;">Buat Akun</h1>
            <p style="color:#555; margin-bottom: 26px;">Isi Detail Berikut ini</p>

            <?php if (!empty($error)): ?>
                <p style="color:red; margin-bottom:10px; font-weight:bold;">
                    <?= $error ?>
                </p>
            <?php endif; ?>

            <form method="POST">

                <input type="hidden" id="deviceField" name="device_id">

                <div style="width:100%; margin-bottom:22px;">
                    <input type="text" name="nama_pelanggan" placeholder="Username"
                        style="width:100%; padding:10px 0; border:none; border-bottom:1px solid #ccc; outline:none; font-size:15px;">
                </div>

                <div style="width:100%; margin-bottom:22px;">
                    <input type="text" name="email" placeholder="Email"
                        style="width:100%; padding:10px 0; border:none; border-bottom:1px solid #ccc; outline:none; font-size:15px;">
                </div>

                <div class="container">
                    <p>Enter your phone number:</p>
                    <input type="hidden" name="nomor_telepon_full" id="nomor_telepon_full">
                    <input id="phone" type="tel" name="nomor_telepon" />
                    <div class="alert alert-info" style="display: none;"></div>
                </div>

                <div style="width:100%; margin-bottom:22px;">
                    <input type="password" name="password" placeholder="Password"
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
        ">Buat Akun</button>
                </div>

            </form>

            <p style="text-align:center; margin-top:10px;">
                Sudah punya akun?
                <a href="login.php" style="font-weight:bold;">Login</a>
            </p>

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

<script>
    function getIp(callback) {
        fetch('https://ipinfo.io/json?token=718399042ae1d1', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(resp => resp.json())
            .catch(() => ({
                country: 'id'
            }))
            .then(resp => callback(resp.country));
    }

    const phoneInputField = document.querySelector("#phone");
    const hiddenPhone = document.querySelector("#nomor_telepon_full");

    const phoneInput = window.intlTelInput(phoneInputField, {
        initialCountry: "auto",
        geoIpLookup: getIp,
        preferredCountries: ["id"],
        separateDialCode: true,
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    document.querySelector("form").addEventListener("submit", function () {
        hiddenPhone.value = phoneInput.getNumber(); // +628xxxx
    });
</script>


</html>
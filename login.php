<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cegah user login saat sedang register
if (isset($_SESSION["auth_lock"]) && $_SESSION["auth_lock"] === "register") {
    header("Location: create_account.php");
    exit();
}

if (isset($_SESSION["id_pelanggan"])) {
    header("Location: dashboard.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gamecafe_db"; // <- sesuaikan, jangan pakai spasi!

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error = ""; // untuk menampilkan pesan error di form

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Cek email
    $sql = "SELECT * FROM pelanggan WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $error = "Email tidak ditemukan.";
    } else {
        $row = $result->fetch_assoc();

        if ($row["password"] === $password) {

            $_SESSION["id_pelanggan"] = $row["id_pelanggan"];
            $_SESSION["nama"] = $row["nama_pelanggan"];

            // 🔐 JIKA LOGIN KARENA BOOKING
            if (
                isset($_GET['redirect']) &&
                $_GET['redirect'] === 'booking' &&
                isset($_GET['id']) &&
                is_numeric($_GET['id'])
            ) {
                header("Location: booking.php?id=" . (int)$_GET['id']);
                exit;
            }

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Caffe Login</title>
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

            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 6px;">Log in</h1>
            <p style="color:#555; margin-bottom: 26px;">Enter your details below</p>

            <?php if (!empty($error)): ?>
                <p style="color:red; margin-bottom:10px; font-weight:bold;">
                    <?= $error ?>
                </p>
            <?php endif; ?>

            <form method="POST">

                <div style="width:100%; margin-bottom:22px;">
                    <input type="text" name="email" placeholder="Email"
                        style="width:100%; padding:10px 0; border:none; border-bottom:1px solid #ccc; outline:none; font-size:15px;">
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
        ">Log In</button>

                    <a href="#" style="color:#e53935; font-size:14px; text-decoration:none;">Forget Password?</a>
                </div>

            </form>

            <p style="text-align:center; margin-top:10px;">
                Don’t have an account?
                <a href="#" style="font-weight:bold;">Create Account</a>
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

</html>
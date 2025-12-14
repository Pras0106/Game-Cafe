<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION["auth_lock"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main PS</title>

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* shadow dropdown */
        .dropdown-shadow {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
    </style>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>

</head>

<body class="bg-white text-black">

    <?php include 'navbar.php'; ?>

    <div class="w-full bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 py-6 flex justify-center">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-lime-400 via-emerald-500 to-lime-500
               bg-clip-text text-transparent drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
               relative
               after:content-[''] after:absolute after:left-0 after:-bottom-1
               after:w-0 after:h-[4px] after:bg-lime-400 after:transition-all after:duration-300 hover:after:w-full">
            Welcome to Game Cafe !!
        </h1>
    </div>

    <!-- SPLINE BACKGROUND SECTION -->
    <section class="bg-black w-full h-[700px] overflow-hidden">
        <iframe src="https://my.spline.design/playstation-BMLLFrT6UwGhW0pSFfKcGHyE/"
            frameborder="0" style="width:100%; height:100%; border:none;">
        </iframe>
    </section>

    <section class="w-full px-6 py-10 bg-gradient-to-br from-gray-600 via-gray-700 to-gray-600">
        <!-- TITLE -->
        <h2 class="text-2xl font-semibold mb-6 text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">All PlayStation Games</h2>

        <!-- WRAPPER -->
        <div class="relative">

            <!-- HORIZONTAL SCROLLER -->
            <div id="innovationSlider" class="flex gap-6 overflow-x-auto scroll-smooth pb-4" style="scrollbar-width: thin;">

                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/NBA 2K26.jfif"
                        class="w-full h-full object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">NBA 2K26</h3>

              <br>

                    <p class=" text-sm text-gray-300 font-bold
                        bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500
                        bg-clip-text text-transparent
                        drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
                        relative inline-block
                        after:content-[''] after:absolute after:left-0 after:-bottom-1
                        after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300
                        hover:after:w-full"">
                        PlayStation 4 - 5
                        </p>
                </div>

                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/TEKKEN 8.jfif"
                        class="w-full h-full object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">TEKKEN 8</h3>

              <br>
              
                    <p class=" text-sm text-gray-300 font-bold
                        bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500
                        bg-clip-text text-transparent
                        drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
                        relative inline-block
                        after:content-[''] after:absolute after:left-0 after:-bottom-1
                        after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300
                        hover:after:w-full"">
                        PlayStation 4 - 5
                        </p>
                </div>

                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/eFootball™.jfif"
                        class="w-full h-full object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">eFootball™</h3>

              <br>
              
                    <p class=" text-sm text-gray-300 font-bold
                        bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500
                        bg-clip-text text-transparent
                        drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
                        relative inline-block
                        after:content-[''] after:absolute after:left-0 after:-bottom-1
                        after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300
                        hover:after:w-full"">
                        PlayStation 4 - 5
                        </p>
                </div>

                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/Gran Turismo® 7.jfif"
                        class="w-full h-full object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">Gran Turismo® 7</h3>

              <br>
              
                    <p class=" text-sm text-gray-300 font-bold
                        bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500
                        bg-clip-text text-transparent
                        drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
                        relative inline-block
                        after:content-[''] after:absolute after:left-0 after:-bottom-1
                        after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300
                        hover:after:w-full"">
                        PlayStation 4 - 5
                        </p>
                </div>

                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/EA SPORTS FC™ 26.jfif"
                        class="w-full h-full object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">EA SPORTS FC™ 26</h3>

              <br>
              
                    <p class=" text-sm text-gray-300 font-bold
                        bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500
                        bg-clip-text text-transparent
                        drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
                        relative inline-block
                        after:content-[''] after:absolute after:left-0 after:-bottom-1
                        after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300
                        hover:after:w-full"">
                        PlayStation 4 - 5
                        </p>
                </div>

            </div>
        </div>
    </section>

    <?php
    // koneksi (sesuaikan jika sudah ada koneksi global)
    $conn = new mysqli("localhost", "root", "", "gamecafe_db");
    if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

    $sql = "SELECT * FROM playstation ORDER BY id_playstation ASC";
    $result = $conn->query($sql);
    ?>
    <section>
        <div id="flash-scroll" class="flex gap-6 overflow-x-auto scroll-smooth pb-4 no-scrollbar whitespace-nowrap">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($ps = $result->fetch_assoc()): ?>
                    <a href="detail_PS.php?id=<?= (int)$ps['id_playstation'] ?>" class="block min-w-[260px]">
                        <div class="min-w-[260px] bg-white border rounded-xl p-4 relative hover:shadow-lg">
                            <img src="<?= htmlspecialchars($ps['url_gambar']) ?>" class="w-full h-40 object-contain" alt="<?= htmlspecialchars($ps['tipe']) ?>">
                            <h3 class="mt-3 font-semibold relative inline-block after:content-[''] after:absolute after:left-0 after:-bottom-1 after:w-0 after:h-[3px] after:bg-black after:transition-all after:duration-300 hover:after:w-full"><?= htmlspecialchars($ps['tipe']) ?></h3>
                            <p class="text-red-500 font-bold">Rp <?= number_format($ps['harga'], 0, ',', '.') ?> / jam</p>
                            <p class="text-gray-600 text-sm mt-1">Lokasi : Nomor <?= (int)$ps['id_playstation'] ?></p>
                            <div class="mt-2 font-semibold <?= $ps['status'] === 'Tersedia' ? 'text-green-600' : 'text-red-600' ?>">
                                <?= htmlspecialchars($ps['status']) ?>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-white">Tidak ada data PlayStation</p>
            <?php endif; ?>
        </div>
    </section>


    <script>
        const scrollBox = document.getElementById("flash-scroll");
        const leftBtn = document.getElementById("flash-left");
        const rightBtn = document.getElementById("flash-right");

        rightBtn.addEventListener("click", () => {
            scrollBox.scrollBy({
                left: 300,
                behavior: "smooth"
            });
        });

        leftBtn.addEventListener("click", () => {
            scrollBox.scrollBy({
                left: -300,
                behavior: "smooth"
            });
        });
    </script>

    <script>
        const STORAGE_KEY = "countdown_target_date";

        // Cek apakah target date sudah pernah disimpan
        let targetDate = localStorage.getItem(STORAGE_KEY);

        if (targetDate) {
            // Jika ada → gunakan target date yang tersimpan
            targetDate = new Date(targetDate);
        } else {
            // Jika belum ada → buat target date baru (30 hari dari sekarang)
            targetDate = new Date();
            targetDate.setDate(targetDate.getDate() + 30);

            // Simpan ke localStorage agar tidak hilang saat refresh
            localStorage.setItem(STORAGE_KEY, targetDate);
        }

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance <= 0) {
                document.getElementById("days").innerText = "00";
                document.getElementById("hours").innerText = "00";
                document.getElementById("minutes").innerText = "00";
                document.getElementById("seconds").innerText = "00";

                // Hapus dari storage jika ingin reset di refresh
                // localStorage.removeItem(STORAGE_KEY);

                return;
            }

            // Perhitungan waktu
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan ke HTML
            document.getElementById("days").innerText = String(days).padStart(2, '0');
            document.getElementById("hours").innerText = String(hours).padStart(2, '0');
            document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
            document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
        }

        // Update tiap detik
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>

    <script>
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', function() {

                const isFav = this.getAttribute('data-fav') === "true";

                if (isFav) {
                    this.innerText = "🤍"; // Kosong
                    this.setAttribute('data-fav', "false");
                    this.style.color = "black";
                } else {
                    this.innerText = "❤️"; // Merah
                    this.setAttribute('data-fav', "true");
                    this.style.color = "red";
                }
            });
        });
    </script>

    <script>
        const slider = document.getElementById("innovationSlider");
    </script>

    <script>
        const container = document.getElementById("flash-scroll");
        const btnLeft = document.getElementById("btn-left");
        const btnRight = document.getElementById("btn-right");

        const scrollAmount = 300; // jarak scroll setiap klik

        btnRight.addEventListener("click", () => {
            container.scrollBy({
                left: scrollAmount,
                behavior: "smooth"
            });
        });

        btnLeft.addEventListener("click", () => {
            container.scrollBy({
                left: -scrollAmount,
                behavior: "smooth"
            });
        });
    </script>


</body>

</html>
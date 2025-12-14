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
    <title>Game Cafe Dashboard</title>

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* shadow dropdown */
        .dropdown-shadow {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
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
              hover:after:w-full">Layanan Kami</h2>

        <!-- WRAPPER -->
        <div class="relative">

            <!-- HORIZONTAL SCROLLER -->
            <div id="innovationSlider" class="flex gap-6 overflow-x-auto scroll-smooth pb-4" style="scrollbar-width: thin;">

            <a href="main_ps.php">
                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/playstation.jpg"
                        class="w-[400px] h-[618px] object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">Main PS</h3>

                    <p class="text-sm text-gray-300 font-bold 
              bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">
                    mulai dari game yang bikin kamu nostalgia hingga game yang baru rilis.
                    </p>
                </div>
            </a>

            <a href="sewa_pc.php">
                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/PC.jpg"
                        class="w-[400px] h-[618px] object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">Sewa PC</h3>

                    <p class="text-sm text-gray-300 font-bold 
              bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">
                        PC gaming dengan performa kencang untuk semua kebutuhan.
                    </p>
                </div>
            </a>

            <a href="cemilan.php">
                <div class="min-w-[500px] p-4 rounded-xl 
            bg-gradient-to-br from-green-600 via-emerald-700 to-lime-600 
            shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <img src="image/food and drink.PNG"
                        class="w-[400px] h-[618px] object-cover rounded-lg mx-auto shadow-[0_4px_10px_rgba(0,0,0,0.7)]">

                    <h3 class="text-xl font-semibold mt-4 font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">Cemilan</h3>

                    <p class="text-sm text-gray-300 font-bold 
              bg-gradient-to-r from-lime-500 via-lime-500 to-lime-500 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full"">
              Tersedia berbagai pilihan makanan ringan dan minuman segar untuk menemani waktu bermainmu.
                    </p>
                </div>
            </a>

            </div>
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

</body>

</html>
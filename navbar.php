<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- ===== MAIN NAVBAR ===== -->
<header class="w-full border-b bg-white z-10 relative">
    <div class="bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 w-full flex items-center justify-center py-5 px-5">

        <nav class="flex items-center gap-10 font-medium text-lg">

            <div class="relative group inline-block">
                <a href="dashboard.php"
                    class="font-bold bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 bg-clip-text text-transparent drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)] relative inline-block after:content-[''] after:absolute after:left-0 after:-bottom-1 after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 hover:after:w-full">
                    Home
                </a>
            </div>

            <?php if (!isset($_SESSION["id_pelanggan"])): ?>

                <div class="relative group">
                    <a href="login.php" class="font-bold 
              bg-gradient-to-r from-lime-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">
                        Login
                    </a>
                </div>

                <div class="relative group">
                    <a href="create_account.php" class="font-bold 
              bg-gradient-to-r from-lime-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">
                        Create Account
                    </a>
                </div>

            <?php else: ?>

                <div class="relative group">
                    <a href="logout.php" class="font-bold 
    bg-gradient-to-r from-lime-400 via-emerald-500 to-lime-400 
    bg-clip-text text-transparent 
    drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
    relative inline-block
    after:content-[''] after:absolute after:left-0 after:-bottom-1 
    after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
    hover:after:w-full">
                        Logout (<?= htmlspecialchars($_SESSION["nama"]); ?>)
                    </a>

                </div>

            <?php endif; ?>


            <div class="relative group">
                <a href="main_ps.php" class="font-bold 
              bg-gradient-to-r from-lime-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">
                    Main PlayStation
                </a>
            </div>

            <div class="relative group">
                <a href="sewa_pc.php" class="font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">
                    Sewa PC
                </a>
            </div>

            <div class="relative group">
                <a href="cemilan.php" class="font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">
                    Cemilan
                </a>
            </div>

            <div class="relative group">
                <a href="riwayat_transaksi.php" class="font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">
                    Riwayat Transaksi
                </a>
            </div>

            <div class="relative group">
                <a href="account_setting.php" class="font-bold 
              bg-gradient-to-r from-green-400 via-emerald-500 to-lime-400 
              bg-clip-text text-transparent 
              drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]
              relative inline-block
              after:content-[''] after:absolute after:left-0 after:-bottom-1 
              after:w-0 after:h-[3px] after:bg-lime-400 after:transition-all after:duration-300 
              hover:after:w-full">
                    Account Setting
                </a>
            </div>
        </nav>
    </div>
</header>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2025 pada 13.28
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamecafe_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aksesoris_pc`
--

CREATE TABLE `aksesoris_pc` (
  `id_aksesoris` int(11) NOT NULL,
  `id_komputer` int(11) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `url_gambar` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aksesoris_pc`
--

INSERT INTO `aksesoris_pc` (`id_aksesoris`, `id_komputer`, `nama`, `url_gambar`) VALUES
(1, 1, 'monitor touch screen', 'image/monitor touch screen.PNG'),
(2, 1, 'headphone PC', 'image/headphone PC.jpg'),
(3, 1, 'Monitor light', 'image/Monitor light.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aksesoris_ps`
--

CREATE TABLE `aksesoris_ps` (
  `id_aksesoris` int(11) NOT NULL,
  `id_playstation` int(11) DEFAULT NULL,
  `nama` varchar(64) DEFAULT NULL,
  `url_gambar` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aksesoris_ps`
--

INSERT INTO `aksesoris_ps` (`id_aksesoris`, `id_playstation`, `nama`, `url_gambar`) VALUES
(1, 1, 'DualSense™ Wireless Controller', 'image/DualSense™ Wireless Controller.jfif'),
(2, 1, 'Thrustmaster T248 Steering Wheel & Pedals', 'image/Thrustmaster T248 Steering Wheel & Pedals.jfif'),
(3, 1, 'PS5 Controller & Headphone Hanger', 'image/PS5 Controller & Headphone Hanger.jfif'),
(4, 1, 'DualSense™ Charging Station', 'image/DualSense™ Charging Station.jpg'),
(5, 1, 'PS5 Vertical Stand', 'image/PS5 Vertical Stand.jpeg'),
(6, 1, 'PULSE 3D™ Wireless Headset', 'image/PULSE 3D™ Wireless Headset.jfif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `id_playstation` int(11) DEFAULT NULL,
  `id_komputer` int(11) DEFAULT NULL,
  `tipe_sewa` varchar(16) NOT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `durasi` time DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `biaya` decimal(12,2) NOT NULL,
  `nama_kartu_debit_or_credit` varchar(128) NOT NULL,
  `nomor_kartu_debit_or_credit` varchar(20) NOT NULL,
  `waktu_kadaluarsa_kartu_debit_or_credit` date NOT NULL,
  `pin_kartu_debit_or_credit` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id_booking`, `id_playstation`, `id_komputer`, `tipe_sewa`, `waktu_mulai`, `durasi`, `waktu_selesai`, `biaya`, `nama_kartu_debit_or_credit`, `nomor_kartu_debit_or_credit`, `waktu_kadaluarsa_kartu_debit_or_credit`, `pin_kartu_debit_or_credit`) VALUES
(6, 1, NULL, 'PlayStation', '2025-12-14 15:00:00', '07:00:00', '2025-12-14 22:00:00', 140000.00, 'Dummy Slayer', '123456789012345', '2001-01-01', '177013'),
(7, 1, NULL, 'PlayStation', '2025-12-14 22:00:00', '02:00:00', '2025-12-15 00:00:00', 40000.00, 'Dummy Slayer', '123456789012345', '2025-12-12', '177013');

-- --------------------------------------------------------

--
-- Struktur dari tabel `food_or_drink`
--

CREATE TABLE `food_or_drink` (
  `id_food` int(11) NOT NULL,
  `nama` varchar(64) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `deskripsi` varchar(128) DEFAULT NULL,
  `kategori` varchar(32) DEFAULT NULL,
  `url_gambar` varchar(128) DEFAULT NULL,
  `stok` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama` varchar(64) DEFAULT NULL,
  `role` varchar(64) DEFAULT NULL,
  `status_kehadiran` varchar(32) DEFAULT NULL,
  `shift` varchar(16) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `komputer`
--

CREATE TABLE `komputer` (
  `id_komputer` int(11) NOT NULL,
  `harga_per_jam` decimal(12,2) NOT NULL,
  `status_komputer` varchar(32) DEFAULT NULL,
  `tipe_pc` varchar(16) NOT NULL,
  `url_gambar` varchar(128) DEFAULT NULL,
  `Spesifikasi` varchar(512) DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komputer`
--

INSERT INTO `komputer` (`id_komputer`, `harga_per_jam`, `status_komputer`, `tipe_pc`, `url_gambar`, `Spesifikasi`) VALUES
(1, 5000.00, 'Tersedia', 'Low-End', 'image/low end pc.jpg', 'Prosesor: AMD Ryzen 5 5600G\nMotherboard: Motherboard B550M GAMING\nRAM: 16 GB DDR4 3200 MHz\nPenyimpanan: SSD 512 GB NVMe M.2\nPSU: Thermaltake 500 watt\nCasing: m-ATX casing');

-- --------------------------------------------------------

--
-- Struktur dari tabel `membeli_paket`
--

CREATE TABLE `membeli_paket` (
  `id_membeli` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_paket` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memesan`
--

CREATE TABLE `memesan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_food` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_waktu`
--

CREATE TABLE `paket_waktu` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(64) DEFAULT NULL,
  `harga_paket_waktu` decimal(12,2) DEFAULT NULL,
  `keterangan_paket_waktu` varchar(32) DEFAULT NULL,
  `jenis_paket_waktu` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(64) DEFAULT NULL,
  `nomor_telepon` varchar(25) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `status_member` varchar(16) DEFAULT NULL,
  `saldo_waktu_ps` time DEFAULT NULL,
  `saldo_waktu_pc` time DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `kode_verifikasi` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `nomor_telepon`, `email`, `password`, `status_member`, `saldo_waktu_ps`, `saldo_waktu_pc`, `device_id`, `kode_verifikasi`) VALUES
(0, 'dummyslayer', '+6289519255891', 'dummyslayer177013@gmail.com', '177013', 'regular', '00:00:00', '00:00:00', 'TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzE0My4wLjAuMCBTYWZhcmkvNTM3LjM2MTUzNjg2NGVuLVVTQXNpYS9KYWthcnRh', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `durasi` time DEFAULT NULL,
  `total_bayar` decimal(12,2) DEFAULT NULL,
  `metode_pembayaran` varchar(32) DEFAULT NULL,
  `tipe_yang_dibayar` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `playstation`
--

CREATE TABLE `playstation` (
  `id_playstation` int(11) NOT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `tipe` varchar(32) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  `url_gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `playstation`
--

INSERT INTO `playstation` (`id_playstation`, `harga`, `tipe`, `status`, `url_gambar`) VALUES
(1, 20000.00, 'Playstation 5 Standard Variant', 'Tersedia', 'image/PS5_original.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aksesoris_pc`
--
ALTER TABLE `aksesoris_pc`
  ADD PRIMARY KEY (`id_aksesoris`),
  ADD KEY `fk_aksesoris_komputer` (`id_komputer`);

--
-- Indeks untuk tabel `aksesoris_ps`
--
ALTER TABLE `aksesoris_ps`
  ADD PRIMARY KEY (`id_aksesoris`),
  ADD KEY `id_playstation` (`id_playstation`);

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `fk_booking_playstation` (`id_playstation`),
  ADD KEY `fk_booking_komputer` (`id_komputer`);

--
-- Indeks untuk tabel `food_or_drink`
--
ALTER TABLE `food_or_drink`
  ADD PRIMARY KEY (`id_food`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `komputer`
--
ALTER TABLE `komputer`
  ADD PRIMARY KEY (`id_komputer`);

--
-- Indeks untuk tabel `membeli_paket`
--
ALTER TABLE `membeli_paket`
  ADD PRIMARY KEY (`id_membeli`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indeks untuk tabel `memesan`
--
ALTER TABLE `memesan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_food` (`id_food`);

--
-- Indeks untuk tabel `paket_waktu`
--
ALTER TABLE `paket_waktu`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `playstation`
--
ALTER TABLE `playstation`
  ADD PRIMARY KEY (`id_playstation`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aksesoris_pc`
--
ALTER TABLE `aksesoris_pc`
  MODIFY `id_aksesoris` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `aksesoris_ps`
--
ALTER TABLE `aksesoris_ps`
  MODIFY `id_aksesoris` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `food_or_drink`
--
ALTER TABLE `food_or_drink`
  MODIFY `id_food` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `komputer`
--
ALTER TABLE `komputer`
  MODIFY `id_komputer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `membeli_paket`
--
ALTER TABLE `membeli_paket`
  MODIFY `id_membeli` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `memesan`
--
ALTER TABLE `memesan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `paket_waktu`
--
ALTER TABLE `paket_waktu`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `playstation`
--
ALTER TABLE `playstation`
  MODIFY `id_playstation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aksesoris_pc`
--
ALTER TABLE `aksesoris_pc`
  ADD CONSTRAINT `fk_aksesoris_komputer` FOREIGN KEY (`id_komputer`) REFERENCES `komputer` (`id_komputer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `aksesoris_ps`
--
ALTER TABLE `aksesoris_ps`
  ADD CONSTRAINT `aksesoris_ps_ibfk_1` FOREIGN KEY (`id_playstation`) REFERENCES `playstation` (`id_playstation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_komputer` FOREIGN KEY (`id_komputer`) REFERENCES `komputer` (`id_komputer`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_playstation` FOREIGN KEY (`id_playstation`) REFERENCES `playstation` (`id_playstation`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `membeli_paket`
--
ALTER TABLE `membeli_paket`
  ADD CONSTRAINT `membeli_paket_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `membeli_paket_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `paket_waktu` (`id_paket`);

--
-- Ketidakleluasaan untuk tabel `memesan`
--
ALTER TABLE `memesan`
  ADD CONSTRAINT `memesan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `memesan_ibfk_2` FOREIGN KEY (`id_food`) REFERENCES `food_or_drink` (`id_food`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

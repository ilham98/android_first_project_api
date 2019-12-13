-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table pkt_sim_aset_ti.ms_vendor: ~2 rows (approximately)
/*!40000 ALTER TABLE `ms_vendor` DISABLE KEYS */;
INSERT INTO `ms_vendor` (`id`, `nama`, `contact_person`, `createdBy`, `createdOn`, `updatedBy`, `updatedOn`) VALUES
	(1, 'test', 'haha', NULL, '2019-12-05 21:22:23', NULL, '2019-12-06 00:21:08'),
	(2, 'sfsdf', 'a', NULL, '2019-12-05 21:22:23', NULL, '2019-12-05 21:44:49');
/*!40000 ALTER TABLE `ms_vendor` ENABLE KEYS */;

-- Dumping data for table pkt_sim_aset_ti.tr_aset: ~0 rows (approximately)
/*!40000 ALTER TABLE `tr_aset` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_aset` ENABLE KEYS */;

-- Dumping data for table pkt_sim_aset_ti.tr_item: ~3 rows (approximately)
/*!40000 ALTER TABLE `tr_item` DISABLE KEYS */;
INSERT INTO `tr_item` (`id`, `nama`, `jumlah`, `jumlah_temp`, `po_number`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
	(43, 'mantap3', 5, 5, '232', '2019-12-06 07:03:21', NULL, '2019-12-06 07:03:21', NULL),
	(44, 'item 2', 3, 3, '232', '2019-12-06 07:03:21', NULL, '2019-12-06 07:03:21', NULL),
	(45, 'sdfs', 3, 3, '232', '2019-12-06 07:03:21', NULL, '2019-12-06 07:03:21', NULL);
/*!40000 ALTER TABLE `tr_item` ENABLE KEYS */;

-- Dumping data for table pkt_sim_aset_ti.tr_purchase_order: ~2 rows (approximately)
/*!40000 ALTER TABLE `tr_purchase_order` DISABLE KEYS */;
INSERT INTO `tr_purchase_order` (`po_number`, `date`, `vendor_id`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
	('123', '2019-12-06', 1, NULL, NULL, NULL, NULL),
	('232', '2019-12-03', 2, '2019-12-06 06:28:48', NULL, '2019-12-06 06:56:15', NULL);
/*!40000 ALTER TABLE `tr_purchase_order` ENABLE KEYS */;

-- Dumping data for table pkt_sim_aset_ti.vl_status_asset: ~0 rows (approximately)
/*!40000 ALTER TABLE `vl_status_asset` DISABLE KEYS */;
/*!40000 ALTER TABLE `vl_status_asset` ENABLE KEYS */;

-- Dumping data for table pkt_sim_aset_ti.vl_status_tracking_asset: ~7 rows (approximately)
/*!40000 ALTER TABLE `vl_status_tracking_asset` DISABLE KEYS */;
INSERT INTO `vl_status_tracking_asset` (`id`, `nama`) VALUES
	(1, 'Aset Baru Ditambahkan'),
	(2, 'Aset Masuk Pada Permintaan Pengeluaran Barang'),
	(3, 'Aset di Disposisi Kepada teknisi'),
	(4, 'Aset telah di input kontrol aset kepada kasie layanan'),
	(5, 'Aset di disposisi pengeluaran aset'),
	(6, 'Aset di approve'),
	(7, 'Aset di disposisi kepada karyawan');
/*!40000 ALTER TABLE `vl_status_tracking_asset` ENABLE KEYS */;

-- Dumping data for table pkt_sim_aset_ti.vl_tipe_asset: ~3 rows (approximately)
/*!40000 ALTER TABLE `vl_tipe_asset` DISABLE KEYS */;
INSERT INTO `vl_tipe_asset` (`id`, `nama`) VALUES
	(1, 'Laptop'),
	(2, 'Desktop'),
	(3, 'Monitor');
/*!40000 ALTER TABLE `vl_tipe_asset` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

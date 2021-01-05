# Host: localhost  (Version: 5.5.5-10.1.37-MariaDB)
# Date: 2020-07-17 19:18:54
# Generator: MySQL-Front 5.2  (Build 5.66)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

#
# Source for table "absensi"
#

DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
  `id_absen` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_absen` date NOT NULL,
  PRIMARY KEY (`id_absen`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

#
# Data for table "absensi"
#

/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
INSERT INTO `absensi` VALUES (48,'2020-06-20'),(51,'2020-07-02');
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;

#
# Source for table "absensi_detl"
#

DROP TABLE IF EXISTS `absensi_detl`;
CREATE TABLE `absensi_detl` (
  `id_absen_detl` int(5) NOT NULL AUTO_INCREMENT,
  `id_absen` int(5) NOT NULL,
  `id_pegawai` int(5) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `jam_lembur` int(2) NOT NULL,
  PRIMARY KEY (`id_absen_detl`),
  KEY `id_absen` (`id_absen`),
  KEY `id_pegawai` (`id_pegawai`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

#
# Data for table "absensi_detl"
#

/*!40000 ALTER TABLE `absensi_detl` DISABLE KEYS */;
INSERT INTO `absensi_detl` VALUES (50,48,7,'08:00:00','17:00:00',3),(54,51,7,'08:00:00','17:00:00',3),(55,51,8,'08:00:00','17:00:00',1),(56,51,9,'08:59:00','17:00:00',2);
/*!40000 ALTER TABLE `absensi_detl` ENABLE KEYS */;

#
# Source for table "admin"
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `idadmin` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `namalengkap` varchar(40) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "admin"
#

INSERT INTO `admin` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','aing');

#
# Source for table "golongan"
#

DROP TABLE IF EXISTS `golongan`;
CREATE TABLE `golongan` (
  `id_golongan` int(10) NOT NULL AUTO_INCREMENT,
  `kode_golongan` varchar(5) NOT NULL,
  `nama_golongan` varchar(10) NOT NULL,
  `tunjangan_suami_istri` int(10) NOT NULL DEFAULT '0',
  `tunjangan_anak` int(10) NOT NULL DEFAULT '0',
  `uang_makan` int(10) NOT NULL DEFAULT '0',
  `uang_lembur` int(10) NOT NULL DEFAULT '0',
  `potongan1` int(3) DEFAULT '0',
  `potongan2` int(3) DEFAULT '0',
  PRIMARY KEY (`id_golongan`),
  KEY `potongan1` (`potongan1`),
  KEY `potongan2` (`potongan2`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Data for table "golongan"
#

/*!40000 ALTER TABLE `golongan` DISABLE KEYS */;
INSERT INTO `golongan` VALUES (7,'G01','OB',100000,50000,10000,9000,NULL,NULL),(8,'G02','web master',10000,50000,10000,8000,1,2);
/*!40000 ALTER TABLE `golongan` ENABLE KEYS */;

#
# Source for table "jabatan"
#

DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan` (
  `id_jabatan` int(10) NOT NULL AUTO_INCREMENT,
  `kode_jabatan` varchar(10) NOT NULL,
  `nama_jabatan` varchar(20) NOT NULL,
  `gaji_pokok` int(10) NOT NULL DEFAULT '0',
  `tunjangan_jabatan` int(10) NOT NULL DEFAULT '0',
  `upah_harian` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jabatan`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

#
# Data for table "jabatan"
#

/*!40000 ALTER TABLE `jabatan` DISABLE KEYS */;
INSERT INTO `jabatan` VALUES (6,'J01','Office Boy',3000000,50000,80000),(9,'J02','Web master',1500000,750000,75000),(10,'J03','admin',3000000,100000,100000);
/*!40000 ALTER TABLE `jabatan` ENABLE KEYS */;

#
# Source for table "pegawai"
#

DROP TABLE IF EXISTS `pegawai`;
CREATE TABLE `pegawai` (
  `id_pegawai` int(5) NOT NULL AUTO_INCREMENT,
  `nip_pegawai` varchar(25) NOT NULL,
  `nama_pegawai` varchar(50) NOT NULL,
  `id_jabatan` int(5) NOT NULL,
  `id_golongan` int(5) NOT NULL,
  `status` varchar(15) NOT NULL,
  `jumlah_anak` int(2) NOT NULL DEFAULT '0',
  `is_active` bit(1) NOT NULL DEFAULT b'0',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id_pegawai`),
  KEY `id_jabatan` (`id_jabatan`),
  KEY `id_golongan` (`id_golongan`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

#
# Data for table "pegawai"
#

/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES (7,'001','alam',6,7,'Menikah',12,b'1',b'1'),(8,'002','shafa',6,7,'Menikah',2,b'1',b'0'),(9,'001','alam kaka',6,7,'Menikah',4,b'1',b'0'),(10,'1712510427','<h1 style: top=0; right=0; position=absolute;> Ary',6,7,'Menikah',1,b'1',b'1'),(11,'1712510400','<h1 style=\"position: absolute|important!; top:0; l',9,7,'Belum Menikah',0,b'1',b'1');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;

#
# Source for table "potongan"
#

DROP TABLE IF EXISTS `potongan`;
CREATE TABLE `potongan` (
  `id_potongan` int(3) NOT NULL AUTO_INCREMENT,
  `nama_potongan` varchar(20) NOT NULL,
  `keterangan_potongan` varchar(50) NOT NULL,
  `nominal_potongan` int(20) NOT NULL,
  PRIMARY KEY (`id_potongan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Data for table "potongan"
#

INSERT INTO `potongan` VALUES (1,'mangkir','sakit',50000),(2,'Asusansi Kesehatan','Bpjs',70000);

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

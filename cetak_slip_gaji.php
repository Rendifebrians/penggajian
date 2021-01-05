<?php
session_start();
if(isset($_SESSION['login'])){
	include "koneksi.php";
	include "fungsi.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cetak Slip Gaji Pegawai</title>
	<style type="text/css">
		body{
			font-family: Arial;
		}
		@media print{
			.no-print{
				display: none;
			}
		@page {
		size: auto;   /* auto is the initial value */
		margin: 0;  /* this affects the margin in the printer settings */
			}
		}

		table{
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<?php 
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$idpeg = $_GET['id'];
	$sqlPrint = mysqli_query($konek, "SELECT H.*, (tot_masuk*upah_harian) as Tupah_harian, (tot_masuk*uang_makan) as Tuang_makan, (tot_lembur*uang_lembur) as Tuang_lembur FROM
	(
	SELECT DISTINCT nip_pegawai, nama_pegawai, nama_jabatan, nama_golongan, sum(jam_lembur) as tot_lembur, sum(status_masuk) as tot_masuk, gaji_pokok, tunjangan_jabatan, tunjangan_suami_istri, tunjangan_anak, upah_harian, uang_makan, uang_lembur, COUNT(IF(status_masuk='0',1, NULL)) 'mangkir', nampot2, nampot1, nompot2, nompot1 FROM 
			(
			SELECT F.*, IF(F.jam_kerja <> 0,'1','0') as status_masuk FROM 
					(          
					SELECT A.tgl_absen, A.id_absen,  C.nip_pegawai, C.nama_pegawai, D.nama_golongan, E.nama_jabatan, B.jam_masuk, B.jam_keluar, TIMEDIFF(B.jam_keluar,B.jam_masuk) as jam_kerja, B.jam_lembur, D.tunjangan_suami_istri, D.tunjangan_anak, D.uang_makan, D.uang_lembur, E.gaji_pokok, E.tunjangan_jabatan, E.upah_harian, F.nama_potongan as nampot1, G.nama_potongan as nampot2, F.nominal_potongan as nompot1,G.nominal_potongan as nompot2
					FROM absensi A 
					LEFT JOIN absensi_detl B ON B.id_absen=A.id_absen
					LEFT JOIN pegawai C ON C.id_pegawai=B.id_pegawai
					LEFT JOIN golongan D ON D.id_golongan=C.id_jabatan
					LEFT JOIN jabatan E ON E.id_jabatan=C.id_jabatan
					LEFT JOIN potongan F ON F.id_potongan=D.potongan1 
					LEFT JOIN potongan G ON G.id_potongan=D.potongan2 
					WHERE MONTH(A.tgl_absen) = $bulan AND YEAR(A.tgl_absen) = $tahun AND C.id_pegawai = $idpeg
					) AS F
			) AS G
	 ) AS H");
	$p = mysqli_fetch_array($sqlPrint);
	?>
<a href="#" class="no-print" onclick="window.print();">Cetak/Print</a>&nbsp;
<a href="#" class="no-print" onclick="window.close();">Tutup/Close</a>&nbsp;

<table border="0" width="100%">
	<tr><td><h3 align="center">CV. Sari Bumi Sakti</h3></td></tr>
	<tr><td align="center">Jl. Sulaiman 40a Kemanggisan Palmerah<br>Kota Jakarta Barat, DKI Jakarta 11480<hr></td></tr><hr></td></tr>
</table>

<table border="0" width="100%">
<tr height="5%">
	<td colspan="3" align="center">
		<u><b>SLIP GAJI PEGAWAI</b></u>
	</td>
</tr>
<tr height="5%">
	<td colspan="3" align="center">
	<b>Periode bulan Juli, tahun 2020</b>
	</td>
</tr>
<tr height="5%">
	<td colspan="3" align="center">
		&nbsp;
	</td>
</tr>
<tr height=5% >
	<td width="15%">Nip</td>
	<td width="1%">:</td>
	<td><?= $p['nip_pegawai']; ?></td>
</tr>
<tr height=5%>
	<td>Nama</td>
	<td>:</td>
	<td><?= $p['nama_pegawai']; ?></td>
</tr>
<tr height=5%>
	<td>Jabatan</td>
	<td >:</td>
	<td><?= $p['nama_jabatan']; ?></td>
</tr>
<tr height=5%>
	<td>Golongan</td>
	<td>:</td>
	<td><?= $p['nama_golongan']; ?></td>
</tr>
<tr height=5%><td colspan="3">&nbsp;</td></tr>
<!-- <tr height=5%><td colspan="3">&nbsp;</td></tr> -->
</table>

<!-- <br> -->

<table border="0" width="100%">
<tr height="5%">
	<td colspan="4">
		<u><b>PENGHASILAN</b></u>
	</td>
	<td colspan="3">
		<u><b>POTONGAN</b></u>
	</td>
</tr>
<tr height=5% >
	<td width="25%">Gaji Pokok</td>
	<td width="2%">=</td>
	<td align="right" width="20%"><?= buatRp($p['gaji_pokok']); ?></td>
	<td width="5%">&nbsp;</td>
	<!-- <td width="20%">PPh 21</td> -->
	<td width="20%">&nbsp;</td>
	<!-- <td width="2%">=</td> -->
	<td width="2%">&nbsp;</td>
	<!-- <td align="right" width="20%">Rp. 0</td> -->
	<td align="right" width="20%">&nbsp;</td>
</tr>
<?php 
	$PotHari = $p['mangkir']*$p['nompot1'];
	$TPotongan = $PotHari+$p['nompot2'];
?>
<tr height=5%>
	<td>Tunjangan Jabatan</td>
	<td>=</td>
	<td align="right"><?= buatRp($p['tunjangan_jabatan']); ?></td>
	<td>&nbsp;</td>
	<td><?=$p['nampot2'];?></td>
	<td>=</td>
	<td align="right"><?= buatRp($PotHari); ?></td>
</tr>
<tr height=5%>
	<td>Tunjangan S/I</td>
	<td>=</td>
	<td align="right"><?= buatRp($p['tunjangan_suami_istri']); ?></td>
	<td>&nbsp;</td>
	<td><?=$p['nampot1'];?></td>
	<td>=</td>
	<td align="right"><?= buatRp($p['nompot1']); ?></td>
</tr>
<tr height=5%>
	<td>Tunjangan Anak</td>
	<td>=</td>
	<td align="right"><?= buatRp($p['tunjangan_anak']); ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right">&nbsp;</td>
</tr>
<tr height=5%>
	<td>Upah Harian</td>
	<td>=</td>
	<td align="right"><?= buatRp($p['Tupah_harian']); ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right">&nbsp;</td>
</tr>
<tr height=5%>
	<td>Uang Makan</td>
	<td>=</td>
	<td align="right"><?= buatRp($p['Tuang_makan']); ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right">&nbsp;</td>
</tr>
<tr height=5%>
	<td>Uang Lembur</td>
	<td>=</td>
	<td align="right"><?= buatRp($p['Tuang_lembur']); ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right">&nbsp;</td>
</tr>
<tr height=5%>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><hr></td>
	<td>&nbsp;</td>
	<td>Total (B)</td>
	<td>&nbsp;</td>
	<td align="right">&nbsp;</td>
</tr>
<tr height=5%>
	<td align="right"><b>Total (A)</b></td>
	<td>&nbsp;</td>
	<td align="right"><b>
		<?php 
			$pp=$p['gaji_pokok']+$p['tunjangan_jabatan']+$p['tunjangan_suami_istri']+$p['tunjangan_anak']+$p['Tupah_harian']+$p['Tuang_makan']+$p['Tuang_lembur'];
			echo buatRp($pp);
		?>
	</b></td>
	<td>&nbsp;</td>
	<td align="right"><b>Total (B)</b></td>
	<td>&nbsp;</td>
	<td align="right"><b><?= buatRp($TPotongan);?></b></td>
</tr>
<tr height=5%><td colspan="7">&nbsp;</td></tr>
<tr height=5%>
	<td colspan="3" align="center"><b>PENERIMAAN BERSIH (A - B)</b></td>
	<td colspan="1" align="center"><b>=</b></td>
	<td colspan="3" align="center"><b><?= buatRp($pp-$TPotongan);?></b></td>
</tr>
<tr height=5%><td colspan="7">&nbsp;</td></tr>
<tr height=5%><td colspan="7">&nbsp;</td></tr>
<tr height=5%><td colspan="7">&nbsp;</td></tr>
<tr height=5%><td colspan="7">&nbsp;</td></tr>
</table>
</body>
</html>
<?php
mysqli_close($konek);
}else{
	header('location:login.php');
}
?>
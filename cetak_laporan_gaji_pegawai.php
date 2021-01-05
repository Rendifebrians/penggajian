<?php
session_start();
if(isset($_SESSION['login'])){
	include "koneksi.php";
	include "fungsi.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cetak Laporan Gaji Pegawai</title>
	<style type="text/css">
		body{
			font-family: Arial;
		}
		table{
			border-collapse: collapse;
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
	</style>
</head>
<body>
<a href="#" class="no-print" onclick="window.print();">Cetak/Print</a>&nbsp;
<a href="#" class="no-print" onclick="window.close();">Tutup/Close</a>&nbsp;
<table border="0" width="100%">
	<tr><td><h3 align="center">CV. Sari Bumi Sakti</h3></td></tr>
	<tr><td align="center">Jl. Sulaiman 40a Kemanggisan Palmerah<br>Kota Jakarta Barat, DKI Jakarta 11480<hr></td></tr>
</table>

<table>
<b>
<p>
LAPORAN GAJI PEGAWAI
</p>
</b>
	<tr>
		<td width="100px">Bulan</td>
		<td width="4px">:</td>
		<td><?php echo bulanIndonesia($_GET['bulan']); ?></td>
	</tr>
	<tr>
		<td width="100px">Tahun</td>
		<td width="4px">:</td>
		<td><?php echo $_GET['tahun']; ?></td>
	</tr>
</table>
<hr>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<th>No.</th>
		<th>NIP</th>
		<th>Nama Pegawai</th>
		<th>Jabatan</th>
		<th>Golongan</th>
		<th>Gaji Pokok</th>
		<th>Tj. Jabatan</th>
		<th>Tj. SI</th>
		<th>Tj. Anak</th>
		<th>Upah</th>
		<th>Uang Makan</th>
		<th>Uang Lembur</th>
		<th>Potongan</th>
		<th>Total Gaji</th>
	</tr>
	<?php
	if(isset($_GET['bulan']) && $_GET['bulan']!=''){
        $bulan = $_GET['bulan'];
    }else{
        $bulan = date('n');
    }
    if(isset($_GET['tahun']) && $_GET['tahun']!=''){
        $tahun = $_GET['tahun'];
    }else{
        $tahun = date('Y');
    }

	$sql = mysqli_query($konek, "SELECT G.*, SUM(jam_lembur) as Tjam_lembur, SUM(status_masuk) as Tstatus_masuk, COUNT(IF(status_masuk='0',1, NULL)) 'mangkir'
	FROM 
			(
			SELECT F.*, IF(F.jam_kerja <> 0,'1','0') as status_masuk FROM 
					(          
					SELECT A.id_absen, B.id_pegawai, C.nip_pegawai, C.nama_pegawai, D.nama_golongan, E.nama_jabatan, TIMEDIFF(B.jam_keluar,B.jam_masuk) as jam_kerja, B.jam_lembur, 
					E.tunjangan_jabatan, E.gaji_pokok, D.tunjangan_suami_istri, D.tunjangan_anak, E.upah_harian, D.uang_makan, D.uang_lembur,F.nama_potongan as nampot1, G.nama_potongan as nampot2, F.nominal_potongan as nompot1,G.nominal_potongan as nompot2
					FROM absensi A 
					left JOIN absensi_detl B ON B.id_absen=A.id_absen
					LEFT JOIN pegawai C ON C.id_pegawai=B.id_pegawai
					LEFT JOIN golongan D ON D.id_golongan=C.id_golongan
					LEFT JOIN jabatan E ON E.id_jabatan=C.id_jabatan
					LEFT JOIN potongan F ON F.id_potongan=D.potongan1 
					LEFT JOIN potongan G ON G.id_potongan=D.potongan2 
					WHERE MONTH(A.tgl_absen) = $bulan AND YEAR(A.tgl_absen) = $tahun
					) AS F
			) AS G
			GROUP BY id_pegawai");
	$no = 1;
	while($d=mysqli_fetch_array($sql)) {
		$Tupah = $d['Tstatus_masuk']*$d['upah_harian'];
                $Tmakan = $d['Tstatus_masuk']*$d['uang_makan'];
                $Tlembur = $d['Tjam_lembur']*$d['uang_lembur'];
                // $TPotongan = $d['askes'];
                $TPotongan = ($d['mangkir']*$d['nompot1'])+$d['nompot2'];
                $TgajiKotor = $d['gaji_pokok'] + $d['tunjangan_jabatan'] + $d['tunjangan_suami_istri'] + $d['tunjangan_anak'] + $Tupah + $Tmakan + $Tlembur ;
                $TotalGaji = $TgajiKotor - $TPotongan;
                // echo var_dump($upah);die;
                echo "<tr>
                    <td>$no</td>
                    <td>$d[nip_pegawai]</td>
                    <td>$d[nama_pegawai]</td>
                    <td>$d[nama_jabatan]</td>
                    <td>$d[nama_golongan]</td>
                    <td>".buatRp($d['gaji_pokok'])."</td>
                    <td>".buatRp($d['tunjangan_jabatan'])."</td>
                    <td>".buatRp($d['tunjangan_suami_istri'])."</td>
                    <td>".buatRp($d['tunjangan_anak'])."</td>
                    <td>".buatRp($Tupah)."</td>
                    <td>".buatRp($Tmakan)."</td>
                    <td>".buatRp($Tlembur)."</td>
                    <td>".buatRp($TPotongan)."</td>
                    <td>".buatRp($TotalGaji)."</td>
                </tr>";
		$no++;
	}

	if(mysqli_num_rows($sql) < 1){
		echo "<tr><td collapse='9'>Belum ada data....</td></tr>";
	}
	?>
		
<table width="100%">
	<tr>
		<td></td>
		<td width="200px">
			<p>
			Kota Tangerang Selatan, <?php echo tglIndonesia(date("Y/m/d")); ?>
				<br>
			Administrator,
			</p>
			<br>
			<br>
			<br>
			<p>___________________________________</p>
		</td>
	</tr>
</table>
</body>
</html>
<?php
mysqli_close($konek);
}else{
	header('location:login.php');
}
?> 
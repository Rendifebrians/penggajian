<?php include "header.php"; ?>  
<?php include "sidebar.php"; ?>  
<?php include "topbar.php"; ?>
<?php include "fungsi.php"; ?>
<div class="container">

<?php
$view = isset($_GET['view']) ? $_GET['view'] : null;

switch($view){
	default:
	?>
	<!--menampilkan pesan -->
	<?php
	if(isset($_GET['e']) && $_GET['e']=='sukses'){
	?>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span 
					aria-hidden="true">&times;</span></button>
  					<strong>Selamat!</strong> Proses berhasil!
  			</div>
		</div>
	</div>
	<?php
	}elseif(isset($_GET['e']) && $_GET['e']=='gagal'){
	?>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span 
					aria-hidden="true">&times;</span></button>
  					<strong>Error!</strong> Proses gagal dilakukan..!
  			</div>
		</div>
	</div>
	<?php
	}
	?>
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						Data Golongan 
					</h3>
				</div>
				
				<div class="panel-body">
					<a href="data_golongan.php?view=tambah" style="margin-bottom:10px" class="btn btn-primary">Tambah Data</a>
					<table class="table table-bordered table-striped">
					 	<tr>
					 		<th>No</th>
					 		<th>Kode</th>
					 		<th>Nama Golongan</th>
					 		<th>Tunjangan S/I</th>
					 		<th>Tunjangan Anak</th>
					 		<th>Uang Makan</th>
					 		<th>Uang Lembur</th>
					 		<th>Potongan 1</th>
					 		<th>Potongan 2</th>
					 		<th>Aksi</th>
						</tr>
						<?php
						$sql = "SELECT A.*, B.nama_potongan as nampot1, B.nominal_potongan as nompot1, C.nama_potongan as nampot2, C.nominal_potongan as nompot2 FROM golongan A
								LEFT JOIN potongan B on B.id_potongan = potongan1 
								LEFT JOIN potongan C on C.id_potongan = potongan2 
								ORDER BY A.kode_golongan ASC
								";
						$sqlview = mysqli_query($konek, $sql);
						$no=1;
						
						while($d=mysqli_fetch_array($sqlview)){
							// $uangmakan=number_format("$d[uang_makan]",2,",",".");
							$tunjangan_suami_istri=buatRp("$d[tunjangan_suami_istri]");
							$tunjangan_anak=buatRp("$d[tunjangan_anak]");
							$uangmakan=buatRp("$d[uang_makan]");
							$uang_lembur=buatRp("$d[uang_lembur]");
							$nampot1=$d['nampot1'];
							$nampot2=$d['nampot2'];
							$potongan1=buatRp($d['nompot1']);
							$potongan2=buatRp($d['nompot2']);

							echo "<tr>
								<td width='40px' align='center'>$no</td>
								<td>$d[kode_golongan]</td>
								<td>$d[nama_golongan]</td>
								<td>$tunjangan_suami_istri</td>
								<td>$tunjangan_anak</td>
								<td>$uangmakan</td>
								<td>$uang_lembur</td>
								<td>$nampot1 - $potongan1</td>
								<td>$nampot2 - $potongan2</td>
								<td width='160px' align='center'>
			<a class='btn btn-warning btn-sm' href='data_golongan.php?view=edit&id=$d[id_golongan]'>Edit</a>
			<a class='btn btn-danger btn-sm' href='aksi_golongan.php?act=del&id=$d[id_golongan]'>Hapus</a>
			</td>
			</tr>";
			$no++;
		  	}
			?>
					</table>
				</div> 
			</div>
		</div>
	<?php
	break;
	case "tambah":
		//membuat kode golongan otomatis
		$simbol = "G";
		$query  = mysqli_query($konek, "SELECT max(kode_golongan) AS last FROM golongan WHERE 
			kode_golongan LIKE '$simbol%'");
		$data = mysqli_fetch_array($query);

		$kodeterakhir = $data['last'];
		$nomerterakhir = substr($kodeterakhir, 1, 2);
		$nextNomer = $nomerterakhir + 1;
		$nextKode = $simbol.sprintf('%02s',$nextNomer);

	?>
		<?php
		if(isset($_GET['e']) && $_GET['e']=='bl'){
		?>
		<div class="row">
			<div class="col-md-8 col-md-offset2">
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span 
					aria-hidden="true">&times;</span></button>
  						<strong>peringatan</strong> Form anda belum lengkap, silahkan dilengkapi!
  				</div>
			</div>
		</div>
		<?php
		}
		?>


		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						Tambah Data Golongan
					</h3>
				</div>
				
				<div class="panel-body">

					<form method="post" action="aksi_golongan.php?act=insert">
						<table class="table">
							<tr>
								<td width="160px">Kode Golongan </td>
								<td>
									<input class="form-control" type="text" name="kodegolongan" value="<?php
									echo $nextKode; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td>Nama Golongan</td>
								<td>
									<input class="form-control" type="text" name="namagolongan" required>
								</td>
							</tr>
							<tr>
								<td>Tunjangan S/I</td>
								<td>
									<input class="form-control" type="number" name="tunjangansi" required>
								</td>
							</tr>
							<tr>
								<td>Tunjangan Anak</td> 
								<td>
									<input class="form-control" type="number" name="tunjangananak" required>
								</td>
							</tr>
							<tr>
								<td>Uang Makan</td> 
								<td>
									<input class="form-control" type="number" name="uangmakan" required>
								</td>
							</tr>
							<tr>
								<td>Uang Lembur</td> 
								<td>
									<input class="form-control" type="number" name="uanglembur" required>
								</td>
							</tr>
							<tr>
								<td>Potongan 1</td>
								<td>
									<select name="potongan1" class="form-control">
										<option value="">- Pilih -</option>
										<?php
										$sql='SELECT A.*, B.potongan1 FROM potongan A
										LEFT JOIN golongan B ON B.potongan1 = A.id_potongan AND 
										B.potongan1 IS NULL AND B.potongan2 IS NULL';
										$sqlJabatan=mysqli_query($konek, $sql);
										while($j=mysqli_fetch_array($sqlJabatan)){
											echo "<option value='$j[id_potongan]'>$j[nama_potongan] - $j[nominal_potongan]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Potongan 2</td>
								<td>
									<select name="potongan2" class="form-control">
										<option value="">- Pilih -</option>
										<?php
										$sql='SELECT A.*, B.potongan1 FROM potongan A
										LEFT JOIN golongan B ON B.potongan1 = A.id_potongan AND 
										B.potongan1 IS NULL AND B.potongan2 IS NULL';
										$sqlJabatan=mysqli_query($konek, $sql);
										while($j=mysqli_fetch_array($sqlJabatan)){
											echo "<option value='$j[id_potongan]'>$j[nama_potongan] - $j[nominal_potongan]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td> 
									<input type="submit" class="btn btn-primary" value="Simpan">
									<a class="btn btn-danger" href="data_golongan.php">Kembali</a>
								</td>
							</tr>
						</table>
					</form>
			</div>
		</div>
	</div>

	<?php
 	break;
	case "edit":
		//kode
		$sqlEdit = mysqli_query($konek, "SELECT * FROM golongan WHERE id_golongan='$_GET[id]'");
		$e = mysqli_fetch_array($sqlEdit);
	?>

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Edit Data Golongan</h3>
			</div>
			<div class="panel-body">
				<form method="post" action="aksi_golongan.php?act=update">
					<table class="table">
						<tr>
							<td width="160">Kode Jabatan</td>
							<td>
								<input type="text" name="kodegolongan" class="form-control" value="<?=$e['kode_golongan']; ?>" readonly />
							</td> 
						</tr>
						<input type="hidden" name="idgol" value="<?= $e['id_golongan']; ?>" />
						<tr>
							<td>Nama Golongan</td>
							<td>
								<input class="form-control" type="text" name="namagolongan" value="<?= $e['nama_golongan']; ?>" required>
							</td>
						</tr>
						<tr>
							<td>Tunjangan S/I</td>
							<td>
								<input class="form-control" type="number" name="tunjangansi" value="<?= $e['tunjangan_suami_istri']; ?>" required>
							</td>
						</tr>
						<tr>
							<td>Tunjangan Anak</td> 
							<td>
								<input class="form-control" type="number" name="tunjangananak" value="<?= $e['tunjangan_anak']; ?>" required>
							</td>
						</tr>
						<tr>
							<td>Uang Makan</td> 
							<td>
								<input class="form-control" type="number" name="uangmakan" value="<?= $e['uang_makan']; ?>" required>
							</td>
						</tr>
						<tr>
							<td>Uang Lembur</td> 
							<td>
								<input class="form-control" type="number" name="uanglembur" value="<?= $e['uang_lembur']; ?>" required>
							</td>
						</tr>
						<tr>
							<td>Potongan 1</td>
							<td>
								<select name="potongan1" class="form-control">
									<option value='NULL'>- Pilih / Kosongkan -</option>
									<?php
									$sql1="SELECT A.*, B.potongan1 FROM potongan A 
									LEFT JOIN golongan B ON B.potongan1 = A.id_potongan AND B.id_golongan='$_GET[id]'
									";
									$sqlPotongan1=mysqli_query($konek,$sql1);
									while($j=mysqli_fetch_array($sqlPotongan1)){

										$selected = ($j['id_potongan'] == $e['potongan1']) ? 'selected="selected"' : "";

										echo "<option value='$j[id_potongan]' $selected>$j[nama_potongan] - $j[nominal_potongan]</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Potongan 2</td>
							<td>
								<select name="potongan2" class="form-control">
									<option value='NULL'>- Pilih / Kosongkan -</option>
									<?php
									$sql2="SELECT A.*, B.potongan2 FROM potongan A 
									LEFT JOIN golongan B ON B.potongan2 = A.id_potongan AND B.id_golongan='$_GET[id]'
									";
									$sqlPotongan2=mysqli_query($konek,$sql2);
									while($j=mysqli_fetch_array($sqlPotongan2)){

										$selected = ($j['id_potongan'] == $e['potongan2']) ? 'selected="selected"' : "";

										echo "<option value='$j[id_potongan]' $selected>$j[nama_potongan] - $j[nominal_potongan]</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" value="Update Data" class="btn btn-primary" />
								<a href="data_golongan.php" class="btn btn-danger">Kembali</a> 
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>

	<?php
	break;

}
?>

</div>
</div>
      <!-- End of Main Content -->
<?php include "footer.php"; ?> 
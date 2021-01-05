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
						Data Potongan 
					</h3>
				</div>
				
				<div class="panel-body">
					<a href="data_potongan.php?view=tambah" style="margin-bottom:10px" class="btn btn-primary">Tambah Data</a>
					<table class="table table-bordered table-striped">
					 	<tr>
					 		<th>No</th>
					 		<th>Nama Potongan</th>
					 		<th>Nominal Potongan</th>
					 		<th>Keterangan Potongan</th>
					 		<th>Aksi</th>
						</tr>
						<?php
						$sql = mysqli_query($konek, "SELECT * FROM potongan ORDER BY nama_potongan ASC");
						$no=1;
						
						while($d=mysqli_fetch_array($sql)){
							echo "<tr>
								<td width='40px' align='center'>$no</td>
								<td>$d[nama_potongan]</td>
								<td>".buatRp($d['nominal_potongan'])."</td>
								<td>$d[keterangan_potongan]</td><td>
			<a class='btn btn-warning btn-sm' href='data_potongan.php?view=edit&id=$d[id_potongan]'>Edit</a>
			<a class='btn btn-danger btn-sm' href='aksi_potongan.php?act=del&id=$d[id_potongan]'>Delete</a>
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
						Tambah Data Potongan
					</h3>
				</div>
				
				<div class="panel-body">

					<form method="post" action="aksi_potongan.php?act=insert">
						<table class="table">
							<tr>
								<td>Nama Potongan</td>
								<td>
				 					<input class="form-control" type="text" name="namapotongan" required>
								</td>
							</tr>
							<tr>
								<td>Nominal Potongan</td>
								<td>
				 					<input class="form-control" type="number" name="nominal" required>
								</td>
							</tr>
							<tr>
								<td>Keterangan Potongan</td>
								<td>
									<input class="form-control" type="text" name="keterangan" required>
								</td>
							</tr>
							<tr>
								<td></td>
								<td> 
									<input type="submit" class="btn btn-primary" value="Simpan">
									<a class="btn btn-danger" href="data_potongan.php">Kembali</a>
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
		$sqlEdit = mysqli_query($konek, "SELECT * FROM potongan WHERE id_potongan='$_GET[id]'");
		$e = mysqli_fetch_array($sqlEdit);
	?>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Edit Data Potongan</h3>
			</div>
			<div class="panel-body">
				<form method="post" action="aksi_potongan.php?act=update">
					<table class="table">
						<input type="hidden" name="id" value="<?= $e['id_potongan']; ?>" />
						<tr>
							<td>Nama Potongan</td>
							<td>
								<input class="form-control" type="text" name="namapotongan" value="<?= $e['nama_potongan']; ?>" required>
							</td>
						</tr>
						<tr>
							<td>Nominal Potongan</td>
							<td>
								<input class="form-control" type="number" name="nominal" value="<?= $e['nominal_potongan']; ?>" required>
							</td>
						</tr>
						<tr>
							<td>Keterangan Potongan</td> 
							<td>
								<input class="form-control" type="text" name="keterangan" value="<?= $e['keterangan_potongan']; ?>">
							</td>
						</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" value="Update Data" class="btn btn-primary" />
							<a href="data_potongan.php" class="btn btn-danger">Kembali</a> 
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
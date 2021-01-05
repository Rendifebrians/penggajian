<?php include "header.php"; ?>  
<?php include "sidebar.php"; ?>  
<?php include "topbar.php"; ?>
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
  					<strong>Error!</strong> Proses gagal dilakkukan..!
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
						Data Pegawai 
					</h3>
				</div>
				
				<div class="panel-body">
					<a href="data_pegawai.php?view=tambah" style="margin-bottom:10px" class="btn btn-primary">Tambah Data</a>
					<table class="table table-bordered table-striped">
					 	<tr>
					 		<th>No</th>
					 		<th>NIP</th>
					 		<th>Nama Pegawai</th>
					 		<th>Jabatan</th>
					 		<th>Golongan</th>
					 		<th>Status</th>
					 		<th>Jumlah Anak</th>
					 		<th>Is Active</th>
					 		<th>Aksi</th>
						</tr>
						<?php
						$sql = mysqli_query($konek, "SELECT pegawai.*, jabatan.kode_jabatan,jabatan.nama_jabatan, golongan.kode_golongan, golongan.nama_golongan FROM pegawai 
													INNER JOIN jabatan ON pegawai.id_jabatan=jabatan.id_jabatan 
													INNER JOIN golongan ON pegawai.id_golongan=golongan.id_golongan 
													WHERE pegawai.is_deleted=0
													ORDER BY pegawai.nip_pegawai ASC");
						$no=1;
						while($d=mysqli_fetch_array($sql)){
							echo "<tr>
								<td width='40px' align='center'>$no</td>
								<td>$d[nip_pegawai]</td>
								<td>$d[nama_pegawai]</td>
								<td>$d[kode_jabatan] - $d[nama_jabatan]</td>
								<td>$d[kode_golongan] - $d[nama_golongan]</td>
								<td>$d[status]</td>
								<td>$d[jumlah_anak]</td>";
								?>
									
								
								<td>
								<div class='custom-control custom-checkbox'>	
								<?php if((int)$d['is_active'] == 1) : ?>
								  <input class="custom-control-input" type="checkbox" id="customCheckbox3" checked disabled="">
								  <label for="customCheckbox3" class="custom-control-label">Actived</label>
								<?php else : ?>
								  <input class="custom-control-input" type="checkbox" id="customCheckbox3" disabled="">
								  <label for="customCheckbox3" class="custom-control-label">Not Actived</label>
								<?php endif; ?>
								</div>
								</td>

								<td width='160px' align='center'>
			<?php echo "
			<a class='btn btn-warning btn-sm' href='data_pegawai.php?view=edit&id=$d[id_pegawai]'>Edit</a>
			<a class='btn btn-danger btn-sm' href='aksi_pegawai.php?act=del&id=$d[id_pegawai]'>Hapus</a>"
			?>
			</td>
			</tr>
			<?php
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
						Tambah Data Pegawai
					</h3>
				</div>
				
				<div class="panel-body">

					<form method="post" action="aksi_pegawai.php?act=insert">
						<table class="table">
							<tr>
								<td width="160px">NIP </td>
								<td>
									<input class="form-control" type="text" name="nip" required>
								</td>
							</tr>
							<tr>
								<td>Nama Pegawai</td>
								<td>
									<input class="form-control" type="text" name="namapegawai" required>
								</td>
							</tr>
							<tr>
								<td>Jabatan</td>
								<td>
									<select name="jabatan" class="form-control">
										<option value="">- Pilih -</option>
										<?php
										$sqlJabatan=mysqli_query($konek, "SELECT * FROM jabatan ORDER BY kode_jabatan ASC");
										while($j=mysqli_fetch_array($sqlJabatan)){
											echo "<option value='$j[id_jabatan]'>$j[kode_jabatan] - $j[nama_jabatan]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Golongan</td>
								<td>
									<select name="golongan" class="form-control">
										<option value="">- Pilih -</option>
										<?php
										$sqlGolongan=mysqli_query($konek, "SELECT * FROM golongan ORDER BY kode_golongan ASC");
										while($g=mysqli_fetch_array($sqlGolongan)){
											echo "<option value='$g[id_golongan]'>$g[kode_golongan] - $g[nama_golongan]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Status</td> 
								<td>
									<select name="status" class="form-control">
										<option value="">- Pilih -</option> 
										<option value="Menikah">Menikah</option>
										<option value="Belum Menikah">Belum Menikah</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Jumlah Anak</td>
								<td>
									<input type="number" name="jumlahanak" class="form-control">
								</td>
							</tr>
							<tr>
								<td>
									<script>
									function change()
									{
										if (document.getElementById('is_active').checked)
										{
										document.getElementById('is_active').value = 1;
										} else 
										{
										document.getElementById('is_active').value = 0;
										}
									}
									</script>

									<div class="icheck-primary d-inline">
									<input type="checkbox" name="is_active[]" id="is_active" onclick="change();" checked>
											<label for="is_active">Is Active</label>
									</div>
								</td>
							</tr>
							<tr>
								<td></td>
								<td> 
									<input type="submit" class="btn btn-primary" value="Simpan">
									<a class="btn btn-danger" href="data_pegawai.php">Kembali</a>
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
		$sqlEdit = mysqli_query($konek, "SELECT * FROM pegawai WHERE id_pegawai='$_GET[id]'");
		$e = mysqli_fetch_array($sqlEdit);
	?>

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Edit Data Pegawai</h3>
			</div>
			<div class="panel-body">
				<form method="post" action="aksi_pegawai.php?act=update">
					<table class="table">
					<input type="hidden" name="id_pegawai" value="<?php echo $e['id_pegawai']; ?>" />
						<tr>
							<td width="160px">NIP </td>
								<td>
									<input class="form-control" type="text" name="nip" value="<?php echo $e['nip_pegawai']; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td>Nama Pegawai</td>
								<td>
									<input class="form-control" type="text" name="namapegawai"  value="<?php echo $e['nama_pegawai']; ?>" required>
								</td>
							</tr>
							<tr>
								<td>Jabatan</td>
								<td>
									<select name="jabatan" class="form-control">
										<option value="">- Pilih -</option>
										<?php
										$sqlJabatan=mysqli_query($konek, "SELECT * FROM jabatan ORDER BY kode_jabatan ASC");
										while($j=mysqli_fetch_array($sqlJabatan)){

											$selected = ($j['id_jabatan'] == $e['id_jabatan']) ? 'selected="selected"' : "";

											echo "<option value='$j[id_jabatan]' $selected>$j[kode_jabatan] - $j[nama_jabatan]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Golongan</td>
								<td>
									<select name="golongan" class="form-control">
										<option value="">- Pilih -</option>
										<?php
										$sqlGolongan=mysqli_query($konek, "SELECT * FROM golongan ORDER BY kode_golongan ASC");
										while($g=mysqli_fetch_array($sqlGolongan)){

											$selected = ($g['id_golongan'] == $e['id_golongan']) ? 'selected="selected"' : "";

											echo "<option value='$g[id_golongan]' $selected>$g[kode_golongan] - $g[nama_golongan]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Status</td> 
								<td>
									<select name="status" class="form-control">
										<option value="<?php echo $e['status']; ?>" selected><?php echo $e['status']; ?></option> 
										<option value="Menikah">Menikah</option>
										<option value="Belum Menikah">Belum Menikah</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Jumlah Anak</td>
								<td>
									<input type="number" name="jumlahanak" value="<?php echo $e['jumlah_anak']; ?>" class="form-control" required> 
								</td>
							</tr>
							<tr>
								<td>
									<div class="icheck-primary d-inline">
									<input type="checkbox" name="is_active[]" id="checkboxPrimary1" onclick="change();" onload="onPageLoad();">
											<label for="checkboxPrimary1">Is Active</label>
									</div>

									<script>
									window.onload = onPageLoad();
									function onPageLoad(){
										//console.log('checked');
										if(<?=(int)$e['is_active'];?> == 1){
										document.getElementById("checkboxPrimary1").checked=true;
										}
									function change(){
										if (document.getElementById('checkboxPrimary1').checked){
										document.getElementById('checkboxPrimary1').value = 1;
										} else {
										document.getElementById('checkboxPrimary1').value = 0;
										}
										}
									}

									</script>
								</td>
							</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="submit" value="Update Data" class="btn btn-primary" />
								<a href="data_pegawai.php" class="btn btn-danger">Kembali</a> 
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
<?php include "header.php"; ?>  
<?php include "sidebar.php"; ?>  
<?php include "topbar.php"; ?>
<?php include "fungsi.php"; ?>
<div class="container">
<h1 class="h3 mb-4 text-gray-800">Input Data Absensi Harian</h1>
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
				
				<div class="panel-body">
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubAbsensiModal">Add new absensi</a>
					<table class="table table-bordered table-striped">
					 	<tr>
             <tr>
              <th scope="col">No.</th>
              <th scope="col">Tanggal Absensi</th>
              <th scope="col" style="text-align:center">Aksi</th>
          </tr>
						</tr>
						<?php
						$sql = mysqli_query($konek, "SELECT * FROM absensi ORDER BY tgl_absen ASC");
						$no=1;
						
						while($d=mysqli_fetch_array($sql)){
							echo "<tr>
              <td>$no</td>
              <td>$d[tgl_absen]</td>
              </td>
              <td align='left'>
              <a class='btn btn-info btn-sm' href='absensi.php?view=editdetl&id=$d[id_absen]&date=$d[tgl_absen]'>Detail Absensi</a>
              <a class='btn btn-warning btn-sm passingID' data-toggle='modal' data-id='$d[id_absen]' data-date=$d[tgl_absen] href='#' data-target='#editSubAbsensiModal'>Edit</a>
              <a class='btn btn-danger btn-sm' href='aksi_absensi.php?act=del&id=$d[id_absen]'>Delete</a>
              </tr>";
			$no++;
		  	}
			?>
					</table>
				</div> 
			</div>
		</div>

    <!-- Modal -->
    <div class="modal fade" id="newSubAbsensiModal" tabindex="-1" role="dialog" aria-labelledby="newSubAbsensiModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newSubMenuModalLabel">Create Absensi Harian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="aksi_absensi.php?act=insert" method="post">
          <div class="modal-body">
            <div class="form-group">
                  <label for="new_password2">Tanggal Absensi</label>
                  <input class="form-control" id="datepicker" name="tgl_absen" placeholder="YYYY-MM-DD" type="text" autocomplete="off">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal 2 -->
<div class="modal fade" id="editSubAbsensiModal" tabindex="-1" role="dialog" aria-labelledby="editSubAbsensiModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSubMenuModalLabel">Edit Tanggal Absensi Harian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="aksi_absensi.php?act=update" method="post">
	  <div class="modal-body1">
		<input type="hidden" class="form-control" name="id_absen" id="id_absen" value="">
	  </div>
      <div class="modal-body">
        <div class="form-group">
              <label for="new_password2">Tanggal Absensi</label>
              <input class="form-control" id="datepicker2" name="tgl_absenedit" placeholder="YYYY-MM-DD" type="text" autocomplete="off" value="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

	<?php
break;

case "edit":

break;
	case "editdetl":
		//kode
		$idget 		= $_GET['id'];
    $dateget 	= $_GET['date'];
	?>

<div class=row>
			<div class="col-lg">
				<div class="alert alert-info">
					<strong>Detail Absensi | Tanggal : <?php echo $dateget; ?></strong>
				</div>

				<form method="post" action="aksi_absensi_detail.php?act=update">
				<table class="table table-hover">
					<tr>
						<th>No.</th>
						<th>NIP</th>
						<th>Nama Pegawai</th>
						<th>Jabatan</th>
						<th>Jam Masuk</th>
						<th>Jam Keluar</th>
						<th>Lembur</th>
					</tr>

					<?php
					$no=1;
					$query=mysqli_query($konek, "SELECT absensi_detl.*,pegawai.nip_pegawai, pegawai.nama_pegawai, jabatan.nama_jabatan FROM absensi_detl
						INNER JOIN pegawai ON absensi_detl.id_pegawai=pegawai.id_pegawai
						INNER JOIN jabatan ON pegawai.id_jabatan=jabatan.id_jabatan
						WHERE absensi_detl.id_absen='$idget'
						ORDER BY pegawai.nip_pegawai ASC");
					$jmlPegawai=mysqli_num_rows($query);
					while($d=mysqli_fetch_array($query)){
					?>
            <input type="hidden" name="id_absen[]" value="<?php echo $d['id_absen']; ?>" />
            <input type="hidden" name="id_absen_detl[]" value="<?php echo $d['id_absen_detl']; ?>" />
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $d['nip_pegawai']; ?></td>
							<td><?php echo $d['nama_pegawai']; ?></td>
							<td><?php echo $d['nama_jabatan']; ?></td>
							<td>
                <input class="form-control" name="jam_masuk[]" type="time" value="<?php echo $d['jam_masuk']; ?>" autocomplete="off" required>
							</td>
							<td>
                <input class="form-control" name="jam_keluar[]" type="time" value="<?php echo $d['jam_keluar']; ?>" autocomplete="off" required>
							</td>
							<td>
								<input type="number" name="jam_lembur[]" class="form-control" value="<?php echo $d['jam_lembur']; ?>" required />
							</td>
						</tr>
					<?php
						$no++; 
					}

					?>
					<tr>
						<td colspan="7">
							<input class="btn btn-primary" type="submit" value="Update">
							<a href="absensi.php" class="btn btn-danger">Kembali</a>
						</td>
					</tr>
				</table>
			</form>
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

<script>
$(".passingID").click(function () {
//   var myVal = $(event.relatedTarget).data('val');
//    $(this).find(".modal-body").text(myVal);
	var ids = $(this).attr('data-id');
	var dates = $(this).attr('data-date');
    $("#id_absen").val( ids );
    $("#datepicker2").val( dates );
    $('#myModal').modal('show');
});
</script>
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
    <div class="panel-heading">
        <h3 class="panel-title">
            Cetak Slip Gaji 
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-6">
        <div class="form-group">
        <form class="form-inline" method="get" action="">
        <label class="my-1 mr-2" for="inlineFormCustomSelectPref1">Bulan</label>
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref1" name="bulan">
            <option value="" selected>Pilih...</option>
            <?php
            $sqlbulan=mysqli_query($konek, "SELECT DISTINCT MONTH(tgl_absen)as bulan FROM absensi ORDER BY bulan ASC");
            while($j=mysqli_fetch_array($sqlbulan)){

                $selected = ($j['bulan'] == $e['bulan']) ? 'selected="selected"' : "";

                echo "<option value='$j[bulan]' $selected>".bulanindonesia($j['bulan'])."</option>";
            }
            ?>
        </select>

        <label class="my-1 mr-2" for="inlineFormCustomSelectPref2">Tahun</label>
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref2" name=tahun>
            <option value="" selected>Pilih...</option>
            <?php
            $sqltahun=mysqli_query($konek, "SELECT DISTINCT YEAR(tgl_absen)as tahun FROM absensi ORDER BY tahun ASC");
            while($j=mysqli_fetch_array($sqltahun)){

                $selected = ($j['tahun'] == $e['tahun']) ? 'selected="selected"' : "";

                echo "<option value='$j[tahun]' $selected> $j[tahun]</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn btn-primary my-1">Submit</button>
        </form>
        </div>
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

    // echo var_dump($bulan);die;
    ?>
    <!-- <br> -->
    <div class="alert alert-info">
            <strong>Bulan : <?= bulanindonesia($bulan); ?>, Tahun : <?= $tahun; ?></strong>
        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
            <?php
            $sql = mysqli_query($konek, "SELECT DISTINCT B.id_pegawai, C.nip_pegawai, C.nama_pegawai, D.nama_jabatan FROM absensi A 
            LEFT JOIN absensi_detl B ON B.id_absen=A.id_absen
            LEFT JOIN pegawai C ON C.id_pegawai=B.id_pegawai
            LEFT JOIN jabatan D ON D.id_jabatan=C.id_jabatan
            WHERE MONTH(A.tgl_absen) = $bulan AND YEAR(A.tgl_absen) = $tahun
            GROUP BY B.id_pegawai
            ORDER BY C.nip_pegawai ASC");

            $no=1;
            while($d=mysqli_fetch_array($sql)){
                echo "<tr>
                    <td>$no</td>
                    <td>$d[nip_pegawai]</td>
                    <td>$d[nama_pegawai]</td>
                    <td>$d[nama_jabatan]</td>
                    <td><a class='btn btn-success btn-sm' href='cetak_slip_gaji.php?bulan=$bulan&tahun=$tahun&id=$d[id_pegawai]' target='_blank'>Cetak Slip Gaji</a></td>
                </tr>";
                $no++;
            }
            ?>
        </table>
        </div>
    </div>
	<?php
	break;
	case "edit":
		//kode
		$sqlEdit = mysqli_query($konek, "SELECT * FROM golongan WHERE kode_golongan='$_GET[id]'");
		$e = mysqli_fetch_array($sqlEdit);
	?>
	<?php
	break;
}
mysqli_close($konek);
?>

</div>
</div>
      <!-- End of Main Content -->
<?php include "footer.php"; ?> 
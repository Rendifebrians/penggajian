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
            Cetak Laporan Kehadiran 
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-8">
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
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Golongan</th>
                <th>Hadir</th>
                <th>Lembur</th>
                <th>Mangkir</th>
            </tr>
            <?php
            $sql = mysqli_query($konek, "SELECT G.*, sum(jam_lembur) as Tjam_lembur, sum(status_masuk) as Tstatus_masuk, COUNT(IF(status_masuk='0',1, NULL)) 'mangkir'
            FROM 
                    (
                    SELECT F.*, IF(F.jam_kerja <> 0,'1','0') as status_masuk FROM 
                            (          
                            SELECT A.id_absen, B.id_pegawai, C.nip_pegawai, C.nama_pegawai, D.nama_golongan, E.nama_jabatan, TIMEDIFF(B.jam_keluar,B.jam_masuk) as jam_kerja, B.jam_lembur FROM absensi A 
                            left JOIN absensi_detl B ON B.id_absen=A.id_absen
                            LEFT JOIN pegawai C ON C.id_pegawai=B.id_pegawai
                            LEFT JOIN golongan D ON D.id_golongan=C.id_golongan
                            LEFT JOIN jabatan E ON E.id_jabatan=C.id_jabatan
                            WHERE MONTH(A.tgl_absen) = $bulan AND YEAR(A.tgl_absen) = $tahun
                            ) AS F
                    ) AS G
                    GROUP BY id_pegawai");

            $no=1;
            while($d=mysqli_fetch_array($sql)){
                echo "<tr>
                    <td>$no</td>
                    <td>$d[nip_pegawai]</td>
                    <td>$d[nama_pegawai]</td>
                    <td>$d[nama_jabatan]</td>
                    <td>$d[nama_golongan]</td>
                    <td align='right'>".buatHari($d['Tstatus_masuk'])."</td>
                    <td align='right'>".buatJam($d['Tjam_lembur'])."</td>
                    <td align='right'>".buatHari($d['mangkir'])."</td>
                </tr>";
                $no++;
            }
            ?>
            <tr>
                <td colspan="8"><a class="btn btn-success btn-sm" href="cetak_laporan_kehadiran.php?bulan=<?= $bulan;?>&tahun=<?= $tahun;?>" target="_blank">Cetak Laporan Kehadiran</a></td>
            </tr>
        </table>
        </div>
        </div>
    </div>
    
	<?php
	break;
}
mysqli_close($konek);
?>

</div>
</div>
      <!-- End of Main Content -->
<?php include "footer.php"; ?>
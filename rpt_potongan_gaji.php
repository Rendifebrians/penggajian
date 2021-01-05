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
            Cetak Laporan Potongan Gaji Pegawai
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
        <!-- <div class="table-responsive"> -->
        <div class="">
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>No.</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Golongan</th>
                <th>Gaji Kotor</th>
                <th>Potongan 1</th>
                <th>Potongan 2</th>
                <th>Total Potongan</th>
                <th>Total Gaji</th>
            </tr>
            <?php
            $sql = mysqli_query($konek, "SELECT G.*, SUM(jam_lembur) as Tjam_lembur, SUM(status_masuk) as Tstatus_masuk, COUNT(IF(status_masuk='0',1, NULL)) 'mangkir'
            FROM 
                    (
                    SELECT F.*, IF(F.jam_kerja <> 0,'1','0') as status_masuk FROM 
                            (          
                            SELECT A.id_absen, B.id_pegawai, C.nip_pegawai, C.nama_pegawai, D.nama_golongan, E.nama_jabatan, TIMEDIFF(B.jam_keluar,B.jam_masuk) as jam_kerja, B.jam_lembur, 
                            E.tunjangan_jabatan, E.gaji_pokok, D.tunjangan_suami_istri, D.tunjangan_anak, E.upah_harian, D.uang_makan, D.uang_lembur, F.nama_potongan as nampot1, G.nama_potongan as nampot2, F.nominal_potongan as nompot1,G.nominal_potongan as nompot2
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

            $no=1;
            while($d=mysqli_fetch_array($sql)){
                $Tupah = $d['Tstatus_masuk']*$d['upah_harian'];
                $Tmakan = $d['Tstatus_masuk']*$d['uang_makan'];
                $Tlembur = $d['Tjam_lembur']*$d['uang_lembur'];
                // $TPotongan = $d['askes'];
                $TgajiKotor = $d['gaji_pokok'] + $d['tunjangan_jabatan'] + $d['tunjangan_suami_istri'] + $d['tunjangan_anak'] + $Tupah + $Tmakan + $Tlembur ;
                $PotHari = $d['mangkir']*$d['nompot1'];
                $TPotongan = $PotHari+$d['nompot2'];
                $TotalGaji = $TgajiKotor - $TPotongan;
                // echo var_dump($upah);die;
                echo "<tr>
                    <td>$no</td>
                    <td>$d[nip_pegawai]</td>
                    <td>$d[nama_pegawai]</td>
                    <td>$d[nama_jabatan]</td>
                    <td>$d[nama_golongan]</td>
                    <td>$TgajiKotor</td>
                    <td>$d[nampot1] - $PotHari</td>
                    <td>$d[nampot2] - $d[nompot2]</td>
                    <td>".buatRp($TPotongan)."</td>
                    <td>".buatRp($TotalGaji)."</td>
                </tr>";
                $no++;
            }
            ?>
            <tr>
                <td colspan="14"><a class="btn btn-success btn-sm" href="cetak_laporan_potongan_gaji.php?bulan=<?= $bulan;?>&tahun=<?= $tahun;?>" target="_blank">Cetak Laporan Potongan Gaji Pegawai</a></td>
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
<?php

session_start();
include "koneksi.php";

if(!isset($_SESSION['login'])){
	header('location:login.php');
}

// jika ada get act
if(isset($_GET['act'])){

	//act insert
	if($_GET['act']=='insert'){
		$tgl_absen = $_POST['tgl_absen'];
		//sortir IF EXIST by tanggal absensi
		$qry1  = mysqli_query($konek, "SELECT * FROM absensi WHERE tgl_absen ='$tgl_absen'"); 
		$existabsen = mysqli_num_rows($qry1);
		// echo var_dump($existabsen);die;
		if($existabsen >=1 ){
			header('location:absensi.php?e=gagal');
		}else{		

		//proses menyimpan data
		//menyimpan kiriman form ke variabel
		

		if($tgl_absen==''){
            // header('location:data_golongan.php?view=tambah&e=bl');
            header('location:absensi.php?e=gagal');
		}else{
			//proses query simpan data
			$simpan = mysqli_query($konek, "INSERT INTO 
                absensi(tgl_absen) VALUES ('$tgl_absen')");
            $newid = mysqli_insert_id($konek);
            mysqli_query($konek, "INSERT INTO absensi_detl (id_absen, id_pegawai, jam_masuk, jam_keluar, jam_lembur)
                                        SELECT $newid, id_pegawai, 0,0,0 FROM pegawai WHERE is_active = 1 AND is_deleted = 0 ");
			if($simpan){
				header('location:absensi.php?e=sukses');
			}else{
				header('location:absensi.php?e=gagal');
            }
        }
		mysqli_close($konek);
		}
	}

	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel
		$tgl_absen = $_POST['tgl_absenedit'];
		$kode = $_POST['id_absen'];
		// echo var_dump($kode);die;

		//sortir IF EXIST by tanggal absensi
		$qry1  = mysqli_query($konek, "SELECT * FROM absensi WHERE tgl_absen ='$tgl_absen'"); 
		$existabsen = mysqli_num_rows($qry1);
		// echo var_dump($existabsen);die;
		if($existabsen >=1 ){
			header('location:absensi.php?e=gagal');
		}else{

			//  field tanggal absen tidak boleh kosong
			if($tgl_absen==''){
				header('location:absensi.php?e=gagal');
			}else{
				//proses query update data
				$update = mysqli_query($konek, "UPDATE absensi SET tgl_absen='$tgl_absen' WHERE id_absen='$kode'");

				if($update){
					header('location:absensi.php?e=sukses');
				}else{
					header('location:absensi.php?e=gagal');
				}
				mysqli_close($konek);
			}
		}
	}

	//jika act del
	elseif($_GET['act']=='del'){
        $id= $_GET['id'];
        $hapus=mysqli_query($konek, "DELETE FROM `absensi` WHERE `id_absen`=$id");
        $hapusdetl=mysqli_query($konek, "DELETE FROM `absensi_detl` WHERE `id_absen`=$id");
		if($hapus){
			header('location:absensi.php?e=sukses');
		}else{
			header('location:absensi.php?e=gagal');
        }
        mysqli_close($konek);
	}
	
}
?>

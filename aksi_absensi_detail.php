<?php

session_start();
include "koneksi.php";

if(!isset($_SESSION['login'])){
	header('location:login.php');
}

// jika ada get act
if(isset($_GET['act'])){

	//jika act u
	if($_GET['act']=='update'){
	//menyimpan kiriman form ke variabel

		$id_absen  = $_POST['id_absen'];
		$id_absen_detl  = $_POST['id_absen_detl'];
		$jam_masuk  = $_POST['jam_masuk'];
		$jam_keluar = $_POST['jam_keluar'];
		$jam_lembur = $_POST['jam_lembur'];

        $count = count($id_absen_detl);
        // echo var_dump($count);die;
        // echo var_dump($jam_masuk);die;
	
		for($i=0; $i < $count; $i++){
			$update=mysqli_query($konek, "UPDATE absensi_detl SET jam_masuk='$jam_masuk[$i]', jam_keluar='$jam_keluar[$i]', 
				jam_lembur='$jam_lembur[$i]'
				WHERE id_absen='$id_absen[$i]' AND id_absen_detl='$id_absen_detl[$i]'");
		}

		if($update){
			header('location:absensi.php?e=sukses');
		}else{
			header('location:absensi.php?e=gagal');
		}
	}
	
}
?> 
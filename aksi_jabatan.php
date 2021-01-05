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
		//proses menyimpan data
		//menyimpan kiriman form ke variabel
		$kode 	= $_POST['kodejabatan'];
		$nama 	= $_POST['namajabatan'];
		$gapok	= $_POST['gapok'];  
		$tunj	= $_POST['tunjanganjabatan'];
		$upah	= $_POST['upahharian'];

		if($kode=='' || $nama=='' || $gapok=='' || $tunj==''){
			header('location:data_jabatan.php?view=tambah&e=bl');
		}else{
			//proses query simpan data
			$simpan = mysqli_query($konek, "INSERT INTO 
				jabatan(kode_jabatan,nama_jabatan,gaji_pokok,tunjangan_jabatan,upah_harian) 
				VALUES ('$kode','$nama','$gapok','$tunj','$upah')");
			
			if($simpan){
				header('location:data_jabatan.php?e=sukses');
			}else{
				header('location:data_jabatan.php?e=gagal');
			}
		}
	}

	//jika act update
	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel

		// $idj 	= $_POST['id_jabatan'];
		$kode 	= $_POST['kodejabatan'];
		// echo var_dump($kode);die;
		$idj 	= $_POST['id'];
		// echo var_dump($idj);die;
		$nama 	= $_POST['namajabatan'];
		$gapok	= $_POST['gapok'];  
		$tunj	= $_POST['tunjanganjabatan'];
		$upah	= $_POST['upahharian'];

		if($kode=='' || $nama=='' || $gapok=='' || $tunj==''){
			header('location:data_jabatan.php?view=tambah&e=bl');
		}else{
			//proses query upadate data
			$update = mysqli_query($konek, "UPDATE jabatan SET nama_jabatan='$nama', gaji_pokok='$gapok', tunjangan_jabatan='$tunj', upah_harian='$upah' WHERE id_jabatan='$idj'");

			if($update){
				header('location:data_jabatan.php?e=sukses');
			}else{
				header('location:data_jabatan.php?e=gagal');
			}

		}
	}
	
	//jika act del
	elseif($_GET['act']=='del'){
		$hapus=mysqli_query($konek, "DELETE FROM jabatan WHERE id_jabatan='$_GET[id]'");

		if($hapus){
			header('location:data_jabatan.php?e=sukses');
		}else{
			header('location:data_jabatan.php?e=gagal');
		}
	}
	
}
?> 
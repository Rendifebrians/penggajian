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
		$nama 	= $_POST['namapotongan'];
		$nominal 	= $_POST['nominal'];
		$keterangan	= $_POST['keterangan'];
		// echo var_dump($_POST);die;
		if($keterangan=='' || $nama=='' || $nominal==''){
			header('location:data_potongan.php?view=tambah&e=bl');
		}else{
			//proses query simpan data
			// $simpan = mysqli_query($konek, "INSERT INTO potongan(nama_potongan,keterangan_potongan) VALUES ('$nama','$keterangan')");
			$qry="INSERT INTO potongan(nama_potongan,nominal_potongan,keterangan_potongan) VALUES ('$nama','$nominal','$keterangan')";
			// echo var_dump($qry);die;

			$simpan = mysqli_query($konek, $qry);
			if($simpan){
				header('location:data_potongan.php?e=sukses');
			}else{
				header('location:data_potongan.php?e=gagal');
			}
		}
	}

	//jika act update
	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel

		$nama 	= $_POST['namapotongan'];
		$nominal 	= $_POST['nominal'];
		$keterangan	= $_POST['keterangan'];
		$idp 	= $_POST['id'];
		// echo var_dump($idp);die;
		if($nama=='' || $keterangan==''){
			header('location:data_potongan.php?view=tambah&e=bl');
		}else{
			//proses query upadate data
			$update = mysqli_query($konek, "UPDATE potongan SET nama_potongan='$nama', nominal_potongan=$nominal, keterangan_potongan='$keterangan' WHERE id_potongan='$idp'");

			if($update){
				header('location:data_potongan.php?e=sukses');
			}else{
				header('location:data_potongan.php?e=gagal');
			}

		}
	}
	
	//jika act del
	elseif($_GET['act']=='del'){
		$hapus=mysqli_query($konek, "DELETE FROM potongan WHERE id_potongan='$_GET[id]'");

		if($hapus){
			header('location:data_potongan.php?e=sukses');
		}else{
			header('location:data_potongan.php?e=gagal');
		}
	}
	
}
?> 
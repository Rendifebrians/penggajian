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
		$kode 		= $_POST['kodegolongan'];
		$nama 		= $_POST['namagolongan'];
		$tunjsi		= $_POST['tunjangansi'];  
		$tunjanak	= $_POST['tunjangananak'];
		$uangmakan	= $_POST['uangmakan'];
		$uanglembur	= $_POST['uanglembur'];
		$potongan1	= $_POST['potongan1'];
		$potongan2	= $_POST['potongan2'];

		if($kode=='' || $nama=='' || $tunjsi=='' || $tunjanak=='' || $uangmakan=='' || $uanglembur=='' ){
			header('location:data_golongan.php?view=tambah&e=bl');
		}else{
			//proses query simpan data
			$sql = "INSERT INTO 
			golongan(kode_golongan,nama_golongan,tunjangan_suami_istri,tunjangan_anak,uang_makan,uang_lembur,potongan1,potongan2) 
			VALUES ('$kode','$nama','$tunjsi','$tunjanak','$uangmakan','$uanglembur','$potongan1','$potongan2')";
			// echo var_dump($sql);die;
			$simpan = mysqli_query($konek, $sql);
			if($simpan){
				header('location:data_golongan.php?e=sukses');
			}else{
				header('location:data_golongan.php?e=gagal');
			}
		}
	}

	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel
		$idg 		= $_POST['idgol'];
		$kode 		= $_POST['kodegolongan'];
		$nama 		= $_POST['namagolongan'];
		$tunjsi		= $_POST['tunjangansi'];  
		$tunjanak	= $_POST['tunjangananak'];
		$uangmakan	= $_POST['uangmakan'];
		$uanglembur	= $_POST['uanglembur'];
		$potongan1	= $_POST['potongan1'];
		$potongan2	= $_POST['potongan2'];

		// echo var_dump($potongan1);die;
		
		if($kode=='' || $nama=='' || $tunjsi=='' || $tunjanak=='' || $uangmakan=='' || $uanglembur=='' ){
			header('location:data_golongan.php?view=edit&e=bl');
		}else{
			//proses query update data
			$sql = "UPDATE golongan SET nama_golongan='$nama', tunjangan_suami_istri='$tunjsi', tunjangan_anak='$tunjanak', uang_makan='$uangmakan', uang_lembur='$uanglembur', potongan1=$potongan1,
			potongan2=$potongan2 WHERE kode_golongan='$kode'";
			// echo var_dump($sql);die;
			$update = mysqli_query($konek, $sql);

			if($update){
				header('location:data_golongan.php?e=sukses');
			}else{
				header('location:data_golongan.php?e=gagal');
			}
		}
	}

	//jika act del
	elseif($_GET['act']=='del'){
		$hapus=mysqli_query($konek, "DELETE FROM golongan WHERE id_golongan='$_GET[id]'");
		if($hapus){
			header('location:data_golongan.php?e=sukses');
		}else{
			header('location:data_golongan.php?e=gagal');
		}
	}
	
}
?>
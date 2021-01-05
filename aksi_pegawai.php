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
		$nip 		= $_POST['nip'];
		$nama 		= $_POST['namapegawai'];
		$jab		= $_POST['jabatan'];  
		$gol    	= $_POST['golongan'];
		$status 	= $_POST['status'];
		$anak   	= $_POST['jumlahanak'];
		$is_active  = (int)$_POST['is_active'];

		//sortir IF EXIST by NIP 
		$qry1  = mysqli_query($konek, "SELECT * FROM pegawai WHERE nip_pegawai ='$nip'"); 
		$existnip = mysqli_num_rows($qry1);
		// echo var_dump($existabsen);die;
			if($existnip >=1 ){
				header('location:data_pegawai.php?e=gagal');
			}else{
			if($nip=='' || $nama=='' || $jab=='' || $gol=='' || $status=='' || $anak==''){
				header('location:data_pegawai.php?view=tambah&e=bl');
			}else{
				//proses query simpan data
				// echo var_dump($nip,$nama,$jab,$gol,$status,$anak,$is_active);die;
				$simpan = mysqli_query($konek, "INSERT INTO pegawai(nip_pegawai,nama_pegawai,id_jabatan,id_golongan,status,jumlah_anak,is_active)
					VALUES ('$nip','$nama','$jab','$gol','$status','$anak',$is_active)");
				if($simpan){
					header('location:data_pegawai.php?e=sukses');
				}else{
					header('location:data_pegawai.php?e=gagal');
					}
				}
			}
	}
	//jika act u
	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel
		$id 		= $_POST['id_pegawai'];
		$nip 		= $_POST['nip'];
		$nama 		= $_POST['namapegawai'];
		$jab		= $_POST['jabatan'];  
		$gol    	= $_POST['golongan'];
		$status 	= $_POST['status'];
		$anak   	= $_POST['jumlahanak'];
		$is_active  = (int)$_POST['is_active'];

		// echo var_dump($nip,$nama,$jab,$gol,$status,$anak,$is_active);die;
		if($nip=='' || $nama=='' || $jab=='' || $gol=='' || $status=='' || $anak==''){
			header('location:data_pegawai.php?view=edit&e=bl');
		}else{
			//proses query update data
			$update = mysqli_query($konek, "UPDATE pegawai SET 
											nama_pegawai='$nama', 
											id_jabatan	='$jab',
											id_golongan	='$gol',
											status		='$status',
											jumlah_anak	='$anak',
											is_active  	= $is_active
											WHERE id_pegawai='$id'");
			if($update){
				header('location:data_pegawai.php?e=sukses');
			}else{
				header('location:data_pegawai.php?e=gagal');
			}
		}
	}

	//jika act del
	elseif($_GET['act']=='del'){
		$id	= $_GET['id'];
		// echo var_dump($id);die;
		// $hapus=mysqli_query($konek, "DELETE FROM pegawai WHERE id_pegawai='$id'");
		$hapus=mysqli_query($konek, "UPDATE pegawai SET is_deleted=1 WHERE id_pegawai='$id'");
		
		if($hapus){
			header('location:data_pegawai.php?e=sukses');
		}else{
			header('location:data_pegawai.php?e=gagal');
		}
	}
	
}
?> 
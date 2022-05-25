<?php

session_start();
include "koneksi.php";

if(!isset($_SESSION['login'])){
	header('location:login.php');
}

//jika ada get act
if(isset($_GET['act'])){

	//act insert
	if($_GET['act']=='insert'){
		//proses menyimpan data
		//menyimpan kiriman form ke variabel
		$nik         = $_POST['nik'];
		$nama        = $_POST['namaguru'];
   		$jab         = $_POST['jabatan'];
		$status      = $_POST['status'];

		if($nik=='' || $nama=='' || $jab=='' || $status=='')
		{
			header('location:data_guru.php?view=tambah&e=bl');
		}else{
			//proses query simpan data
			$simpan = mysqli_query($konek, "INSERT INTO guru(nik,nama_guru,kode_jabatan,status)
				VALUES('$nik','$nama','$jab','$status')");

			if($simpan){
				header('location:data_guru.php?e=sukses');
			}else{
				header('location:data_guru.php?e=gagal');
			}
		}

	}


	//jika act update
	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel
		$nik         = $_POST['nik'];
		$nama        = $_POST['namaguru'];
   		$jab        = $_POST['jabatan'];
		$status      = $_POST['status'];
		

		if($nik=='' || $nama=='' || $jab=='' || $status==''){
			header('location:data_guru.php?view=edit&e=bl');
		
		}else{
			//proses query update data
			$update = mysqli_query($konek, "UPDATE guru SET nama_guru='$nama', 
															   kode_jabatan='$jab',
															   status='$status'		
															   WHERE nik='$nik'");

			if($update){
				header('location:data_guru.php?e=sukses');
			}else{
				header('location:data_guru.php?e=gagal');
			}
		}
	}

	//jika act del
	elseif($_GET['act']=='del'){
		$hapus= mysqli_query($konek, "DELETE FROM guru WHERE nik='$_GET[id]'");

		if($hapus){
				header('location:data_guru.php?e=sukses');
			}else{
				header('location:data_guru.php?e=gagal');
			}
	    }
}

?>
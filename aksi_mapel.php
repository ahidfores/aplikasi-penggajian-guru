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
		$kode   = $_POST['kodepengajar'];
		$nama   = $_POST['namamapel'];
		
		

		if($kode=='' || $nama==''){
			header('location:data_mapel.php?view=tambah&e=bl');
		}else{
			//proses query simpan data
			$simpan = mysqli_query($konek, "INSERT INTO mapel(kode_pengajar,nama_mapel) VALUES ('$kode','$nama')");

			if($simpan){
				header('location:data_mapel.php?e=sukses');
			}else{
				header('location:data_mapel.php?e=gagal');
			}
		}

	}


	//jika act update
	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel
		$kode        = $_POST['kodepengajar'];
		$nama        = $_POST['namamapel'];
	
   		
		if($kode=='' || $nama==''){
			header('location:data_mapel.php?view=tambah&e=bl');
		}else{
			//proses query update data
			$update = mysqli_query($konek, "UPDATE mapel SET nama_mapel='$nama' WHERE kode_pengajar='$kode'");

			if($update){
				header('location:data_mapel.php?e=sukses');
			}else{
				header('location:data_mapel.php?e=gagal');
			}
		}
	}

	//jika act del
	elseif($_GET['act']=='del'){
		$hapus= mysqli_query($konek, "DELETE FROM mapel WHERE kode_pengajar='$_GET[id]'");

		if($hapus){
				header('location:data_mapel.php?e=sukses');
			}else{
				header('location:data_mapel.php?e=gagal');
			}
	}
}

?>
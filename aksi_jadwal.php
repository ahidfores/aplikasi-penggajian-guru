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
		$nik         	= $_POST['nik'];
		$nama        	= $_POST['nama_mapel'];
		$hari        	= $_POST['hari'];
		$jm          	= $_POST['jam_mulai'];
		$jb          	= $_POST['jam_berakhir'];
		$tahun_ajar  	= $_POST['tahun'];
		$bulan_mulai 	= $_POST['bulan_mulai'];
		$bulan_berakhir = $_POST['bulan_berakhir'];
		$semester    	= $_POST['semester'];

		if($nik=='' || $nama=='' || $hari=='' || $jm=='' || $jb=='' || $tahun_ajar=='' || $semester=='' || $bulan_mulai == $bulan_berakhir || $bulan_mulai == '' || $bulan_berakhir == '')
		{
			header('location:jadwal.php?view=tambah&e=bl');
		}else{
			//proses query simpan data
			$simpan = mysqli_query($konek, "INSERT INTO jadwal(nik,kode_pengajar,hari,jam_mulai,jam_berakhir, tahun_ajar, bulan_mulai, bulan_berakhir, semester)
				VALUES('$nik','$nama','$hari','$jm','$jb', '$tahun_ajar', '$bulan_mulai', '$bulan_berakhir', '$semester')");

			if($simpan){
				header('location:jadwal.php?e=sukses');
			}else{
				header('location:jadwal.php?e=gagal');
			}
		}

	}

	//jika act update
	elseif($_GET['act']=='update'){
		//menyimpan kiriman form ke variabel
		$id          = $_POST['id'];
		$nik         = $_POST['nik'];
		$nama        = $_POST['nama_mapel'];
		$hari        = $_POST['hari'];
		$jm          = $_POST['jam_mulai'];
		$jb          = $_POST['jam_berakhir'];
		$tahun_ajar  = $_POST['tahun'];
		$bulan_mulai 	= $_POST['bulan_mulai'];
		$bulan_berakhir = $_POST['bulan_berakhir'];
		$semester    = $_POST['semester'];
		if($nik=='' || $nama=='' || $hari=='' || $jm=='' || $jb=='' || $tahun_ajar=='' || $semester=='' || $bulan_mulai=='' || $bulan_berakhir=='')
		{
			// var_dump($_POST);
			// die;
			//header('location:jadwal.php?view=edit&e=bl&id=$id&nik=$nik');
			$redirect = 'location:jadwal.php?view=edit&e=bl&id='.$id.'&nik='.$nik;
				// echo $redirect;
			header($redirect);
		}else{
			// echo "<br> Line 66";
			// echo "<br>";
			// var_dump($_POST);
			// echo "<br>";
			// echo "<br>";
			//proses query update data
			$q = "UPDATE jadwal SET nik='$nik', 
									hari='$hari', 
									jam_mulai='$jm', 
									jam_berakhir='$jb', 
									tahun_ajar='$tahun_ajar', 
									bulan_mulai='$bulan_mulai', 
									bulan_berakhir='$bulan_berakhir', 
									semester='$semester' 
									WHERE id='".$id."'";
			// echo $q;
			// die;
			$update = mysqli_query($konek, $q);

			if($update){
				header('location:jadwal.php?e=sukses');
			}else{
				$redirect = '<br>location:jadwal.php?e=gagal';
				header($redirect);
			}
		}
	}

	elseif($_GET['act']=='del'){
		$hapus= mysqli_query($konek, "DELETE FROM jadwal WHERE id='$_GET[id]'");

		if($hapus){
				header('location:jadwal.php?e=sukses');
			}else{
				header('location:jadwal.php?e=gagal');
			}
	    }
}

?>
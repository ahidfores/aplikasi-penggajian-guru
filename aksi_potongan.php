
<?php
date_default_timezone_set("Asia/Jakarta");

// TANGKAP $_GET
$func = $_GET['f'];
if (isset($_GET['f'])) {	
	// Pemilihan apa fungsi yang di trigger
	if ($_GET['f'] == "insert") {
		$res_insert = insert();
		$res_upd = proses_mGaji();
		echo "insert = ". $res_insert . " Update mgaji = " . $res_upd;
		if($res_insert && $res_upd){
			echo "Data Pinjaman masuk";
			echo "Data M-Gaji masuk diupdate";
			header('location:data_penggajian.php?e=sukses');
		}else{
			echo "<br>GAGAL Data Pinjaman, M-Gaji tidak masuk ga diupdate<br>";
			header('location:data_penggajian.php?e=gagal');
		}
	}	
}

// FUNGSI KE 1 #0
function insert()
{
	include "koneksi.php";
	//proses menyimpan data
	//menyimpan kiriman form ke variabel
	$status 			= 0;
	$nik         		= $_POST['nik'];
	$keperluan   		= $_POST['keperluan'];
	$jumlah_potongan	= $_POST['jumlah_potongan'];	

	if($nik=='' || $keperluan=='' || $jumlah_potongan=='')
	{
		header('location:data_potongan.php?view=tambah&e=bl');
	}else{
		$simpan = mysqli_query($konek, "INSERT INTO potongan(nik,keperluan,jumlah_potongan)
		 	VALUES('$nik','$keperluan',$jumlah_potongan)");
		if($simpan){
			$status = 1;
		}else{
			$status = 0;
		}
	}
	return $status;
}

// FUNGSI KEDUA #2
function proses_mGaji()
{
	// Mengecek MGAJI
	include "koneksi.php";
	$nik 				= $_POST['nik'];
	$lastMasterGaji 	= last_MG($nik);
	$jumlah_potongan	= (int)$_POST['jumlah_potongan'];			
	$total_potongan     = $jumlah_potongan + $lastMasterGaji['total_potongan'];

	$th_bln 			= date("Y-m");
	$today 				= date("Y-m-d");
	$q_cek 				= "SELECT * FROM master_gaji WHERE tahun_bulan='$th_bln' AND nik='$nik'";
	$sqlcek_master 		= mysqli_query($konek, $q_cek);
	$q_mGaji;
	
	if (mysqli_num_rows($sqlcek_master) > 0) {			
		// Data mastergaji guru X bulan ini adam tinggal diupdate
		$q_Update_mastergaji = "";
		$q_Update_mastergaji = "UPDATE master_gaji SET total_potongan=$total_potongan, updated_at='$today' WHERE id=$lastMasterGaji[id]";
		$q_mGaji = mysqli_query($konek, $q_Update_mastergaji);
	}else{
			// Data belum ada, pelru bikin data baru
		$q_mastergaji = "INSERT INTO master_gaji (tahun_bulan, nik, absen, izin, alpa, jam_mengajar, total_potongan) VALUES (\"".$th_bln."\", \"".$nik."\", 0, 0, 0, 0, $jumlah_potongan)";
		$q_mGaji = mysqli_query($konek, $q_mastergaji);			
	}
		// Pengecekan hasil eksekusi query
	if($q_mGaji){
		echo "Data M-Gaji masuk diupdate";
		return 1;
		// header('location:data_penggajian.php?e=sukses');
	}else{
		return 0;
		echo "<br>GAGAL Data M-Gaji tidak masuk ga diupdate<br>";
		// header('location:data_penggajian.php?e=gagal');
	}

}

function last_MG($cekNik)
{
	include "koneksi.php";	
	$tahun = date('Y');
	$sql_cek = "SELECT * FROM master_gaji WHERE nik='$cekNik' AND YEAR(updated_at)='$tahun'";
	$sqlcek_terakhirMG = mysqli_query($konek, $sql_cek);
	$e = mysqli_fetch_array($sqlcek_terakhirMG);
	return $e;
}

function get_guru($nik)
{
	include "koneksi.php";	
	$sql = mysqli_query($konek, "SELECT * FROM guru WHERE nik=$nik");
	$e = mysqli_fetch_array($sql);	
	return $e;
}

function get_Hari_ini()
{
	$hari = date('d');
	if ($hari == 1) {
		return "Minggu";
	}else if($hari == 2){
		return "Senin";
	}else if($hari == 3){
		return "Selasa";
	}else if($hari == 4){
		return "Rabu";
	}else if($hari == 5){
		return "Kamis";
	}else if($hari == 6){
		return "Jumat";
	}else{
		return "Sabtu";
	}
}

// function tambah_izin($nik)
// {
// 	include "koneksi.php";
// 	$today = date("Y-m-d-H:i:s");
// 	$guru = get_guru($nik);
// 	$terakhir_absen = last_presence($nik);
// 	$new_izin = 0;
// 	$q_mastergaji = '';
// 	if ($terakhir_absen == null) {
// 		// BELUM ADA DATA MASTER GAJI Guru terkait, bikin baru!
// 		$th_bln = date("Y-m");
// 		$q_mastergaji = "INSERT INTO master_gaji (tahun_bulan, nik, absen, izin, alpa, jam_mengajar) VALUES (\"".$th_bln."\", \"".$nik."\", 0, 1, 0, 0)";
// 		// $q_mGaji = mysqli_query($konek, $q_mastergaji);
// 	}else{
// 		$new_izin = $terakhir_absen['izin'] + 1;
// 		$q_mastergaji = "UPDATE master_gaji SET izin=$new_izin, updated_at='$today' WHERE id=$terakhir_absen[id]";
// 	}

// 	// Menambah data dengan status perizinan IZIN di tabel absensi
// 	$q_simpanAbsen = "INSERT INTO absensi (nik, nama_guru, status, tanggal, jam_mengajar) VALUES ('".$guru['nik']."', '".$guru['nama_guru']."','Izin','$today',0)";
// 	// Mengupdate data MASTER GAJI
	
// 	// Debug sudah sampai gimana
// 	echo "<br><br><br>";
// 	echo $nik . "<br>";
// 	echo $q_Update_mastergaji . " Q Update master_gaji<br>";
// 	echo $q_simpanAbsen . " Q Simpan absen izin<br>";
// 	// Eksekusi query simpan dan update
// 	$simpan = mysqli_query($konek, $q_simpanAbsen);
// 	$q_mGaji = mysqli_query($konek, $q_mastergaji);
// 	// die;
// 	if($simpan && $q_mGaji){
// 		echo "Data ubah izin mGaji sudah masuk & diupdate";
// 		header('location:absen.php?message=Izin&nama_guru='.$_GET['nama_guru']);
// 		//header('location:index.php?e=sukses');
// 	}else{
// 		echo "Data ubah izin mGaji GAGAL diupdate";
// 		header('location:absen.php?message=Izin&e=gagal&nama_guru='.$_GET['nama_guru']);
// 		// header('location:index.php?e=gagal');
// 	}
// }
?>
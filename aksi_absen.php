
<?php
date_default_timezone_set("Asia/Jakarta");

// TANGKAP $_GET
$func = $_GET['f'];
if (isset($_GET['f'])) {
	// var_dump($_GET['f']);
	// die;
	// Pemilihan apa fungsi yang di trigger
	if ($_GET['f'] == "status_absensi_guru") {
		pilih_status_hadir();
	}

	if ($_GET['f'] == "generate_qr") {
		generate_QR_absensi();
	}

	if ($_GET['f'] == "after_scan") {
		after_scan();
	}
}

// FUNGSI KE 0 #0
function pilih_status_hadir()
{
	if(isset($_GET['view_hadir']) && $_GET['view_hadir'] =='true'){
		$nik = $_GET['nik'];
		header('location:absen.php?nik='.$nik.'&view=pilih_status_hadir&e=');
	}
}

// FUNGSI PERTAMA #1
// Digunakan untuk generate QR Code berisi link untuk absen / di scan oleh Guru
function generate_QR_absensi()
{
	if($_GET['status'] !=''){
		// Pengecekan status, kalau hadir maka menampilkan QR, kalau izin dan alpa langsung redirect ke halaman absensi lagi
		if ($_GET['status'] == "Izin") {
			tambah_izin($_GET['nik']);			
		}else if($_GET['status'] == "Alpa"){
			header('location:absen.php?message=Alpa&nama_guru='.$_GET['nama_guru']);
		}else{
			$nik=$_GET['nik'];
			include "koneksi.php";
			include "../apkpenggajianguru/assets/qrcode/qrlib.php";
			//QRcode::png('http://localhost/apppenggajianguru/contohqrcode/.nik.php');
			//QRCode::png('PHP QR Code:)');
			$tempdir = "temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
			if (!file_exists($tempdir)){#kalau folder belum ada, maka buat.
				mkdir($tempdir);
			}

			$nik 		= $_GET['nik'];
			ob_start("callback");
			$codeText 	= 'http://192.168.43.221/apkpenggajianguru/aksi_absen.php?f=after_scan&Absen=true&NIKAbsen='.$_GET ['nik'].'&status_absensi='.$_GET['status']."&tahun_ajar=".$_GET['tahun']."&semester=".$_GET['semester'];
			$namaFile = $_GET ['nik'].".png";
			$quality = "H";
			$ukuranPixel = 5;
			$ukuranFrame = 1;
			$debugLog = ob_get_contents();
			ob_clean();			
			QRcode::png($codeText, $tempdir.$namaFile, $quality, $ukuranPixel, $ukuranFrame);
			// echo $tempdir.$namaFile;
			$source = $tempdir.$namaFile;
			// echo $codeText; die;
			// include 'holder_QR.php?nik='.$_GET['nik'].'&nama='.$_GET['nama_guru'];
			// echo '<img src="'.$tempdir.$namaFile.'" />';
			// include 'holder_QR_foot.php';
			header('location:holder_QR.php?nik='.$_GET ['nik'].'&nama='.$_GET ['nama_guru'].'&src='.$source);		 
		}
	}else{
		header('location:absen.php?nik='.$_GET['nik'].'&view=pilih_status_hadir&e=status_error');	 
	}
	# code...
}

// FUNGSI KEDUA #2
function after_scan()
{
	// Disaat guru mengakses link yang berhasil di scan
	if($_GET['Absen'] == "true"){	
		include "koneksi.php";
		$nik = $_GET['NIKAbsen'];
		$ta  = $_GET['tahun_ajar'];
		$sem = $_GET['semester'];
		$hari_ini = get_Hari_ini();
			// SUB SISTEM FUNGSI KEDUA #2-1
			// Cek waktu absen, apa sudah masuk di saat jadwal mengajarnya
			// Mengambil data jadwal serta menjumlahkan jam mengajar
		$q = "SELECT id, nik, kode_pengajar, hari, HOUR(jam_mulai) as jam_mulai, HOUR(jam_berakhir) as jam_berakhir, semester FROM jadwal WHERE hari='$hari_ini' AND nik='$nik' AND tahun_ajar='$ta' AND semester='$sem'";
		$sql = mysqli_query($konek, $q);
		$count = 0;
		$jam_mengajar = 0;
		if (mysqli_num_rows($sql) > 0) {
			while($d=mysqli_fetch_assoc($sql)){
				if ((int)$d['jam_mulai']<=(int)date('H')&&(int)$d['jam_berakhir']>(int)date('H')) {
					/* 	If ini adalah pengecekan, apakah waktu saat ini adalah waktu disaat dia mengajar
					Semisal guru X jadwal nya 08.00 sampai 10.00 dan sekarang adalah jam 8.05
					Maka kita cek, 
					jam_mulai = 08.00 ---------> $d['jam_mulai'] <= date('H') -> 08.00 <= 08.05 -> jam mulai masih jam 8, sehingga 8 <= 8 == true, maka kondisi ini == TRUE 
					jam_selesai = 10.00 ---------> $d['jam_berakhir'] > date('H') -> 10.00 > 08.05 -> jam_berakhir = 10.00, sehingga 10 > 8 == TRUE, maka kondisi ini == TRUE 
					TRUE && TRUE maka perintah dibawah dijalankan
					*/
					// Kita masih berada di waktu untuk absen
					// Menghitung lama mengajar
					$lama_mengajar = $d['jam_berakhir'] - $d['jam_mulai'];
						// Menambah counter jam mengajar
					$jam_mengajar += $lama_mengajar;
					$count++;
				}
			}	
		}else{
			$count = 0;
		}
		
		if ($count != 0) {
			// SUB SISTEM FUNGSI KEDUA #2-2
			// Menambah data ke DB, tabel absensi
			// Jika ada jam mengajar di saat ini maka bagian ini dijalankan, absensi berhasil 
			$guru = get_guru($nik);#[];
			$today = date("Y-m-d-H:i:s");			
			$q_simpanAbsen = "INSERT INTO absensi (nik, nama_guru, status, tanggal, jam_mengajar) VALUES ('".$guru['nik']."', '".$guru['nama_guru']."','Hadir','$today',$jam_mengajar)";
			$simpan = mysqli_query($konek, $q_simpanAbsen);
			if($simpan){
				echo "Data di tbl absensi masuk";
				unlink('temp/'.$nik.'.png');
				// Mengarahkan guru ke home dan event sukses
				// header('location:index.php?e=sukses');
			}else{
				// Sebagai debug mengapa absensi gagal
				echo "Insert absensi gagal";
			// header('location:index.php?e=gagal');
			}

			// SUB SISTEM FUNGSI KEDUA #2-3
			// INSERT atau UPDATE data di tabel master_gaji
			// cek_apakah sudah ganti bulan
			$th_bln = date("Y-m");
			$today = date("Y-m-d");
			$q_cek = "SELECT * FROM master_gaji WHERE tahun_bulan='$th_bln' AND nik='$nik'";
			$sqlcek_master = mysqli_query($konek, $q_cek);
			$q_mGaji;
			if (mysqli_num_rows($sqlcek_master) > 0) {
				// Data rekapan absen dalam tabel master_gaji di bulan x sudah ada, maka tinggal update data saja
				// CEK APAKAH HARI SUDAH BERGANTI, DICEK DARI HARI KEMARIN
				$q_Update_mastergaji = "";
				$data_lastAbsen = last_presence($nik);
				// Coba cek fungsi last_presence()
				if ($data_lastAbsen['updated_at'] == $today) {
					// Jika terakhir absensi adalah $today (hari ini) maka kita cukup update jumlah jam mengajar
					$new_jam_mengajar = $data_lastAbsen['jam_mengajar'] + $jam_mengajar;
					$q_Update_mastergaji = "UPDATE master_gaji SET jam_mengajar=$new_jam_mengajar, updated_at='$today' WHERE id=$data_lastAbsen[id]";
				}else{
					// Jika terakhir absensi bukan $today (hari ini) maka kita harus menambah kehadiran dan mengubah jumlah jam mengajar
					$new_jumlahHadir = $data_lastAbsen['absen'] + 1;
					$new_jam_mengajar = $data_lastAbsen['jam_mengajar'] + $jam_mengajar;
					$q_Update_mastergaji = "UPDATE master_gaji SET absen='$new_jumlahHadir', jam_mengajar=$new_jam_mengajar, updated_at='$today' WHERE id=$data_lastAbsen[id]";
					# code...
				}
				$q_mGaji = mysqli_query($konek, $q_Update_mastergaji);
			}else{
				// Data belum ada, pelru bikin data baru
				$q_mastergaji = "INSERT INTO master_gaji (tahun_bulan, nik, absen, izin, alpa, jam_mengajar) VALUES (\"".$th_bln."\", \"".$nik."\", 1, 0, 0, $jam_mengajar)";
				$q_mGaji = mysqli_query($konek, $q_mastergaji);			
			}
			// Pengecekan hasil eksekusi query
			if($q_mGaji){
				echo "Data M-Gaji masuk diupdate";
				header('location:hasil_absen.php?e=sukses');
			}else{
				echo "<br>GAGAL Data M-Gaji tidak masuk ga diupdate<br>";
				header('location:hasil_absen.php?e=gagal');
			}
		}else{
			// Jika tidak ada jam mengajar di saat ini maka bagian ini dijalankan, absensi GAGAL
			unlink('temp/'.$nik.'.png');
			header('location:hasil_absen.php?e=out_of_time');
		}		
	}else{
		unlink('temp/'.$nik.'.png');
		header('location:hasil_absen.php?e=out_of_time');
	}	
	// die penutup if absen;
}

	function last_presence($cekNik)
	{
		include "koneksi.php";	
		$tahun = date('Y');
		$sql_cek = "SELECT * FROM master_gaji WHERE nik='$cekNik' AND YEAR(updated_at)='$tahun'";
		$sqlcek_terakhirAbsen = mysqli_query($konek, $sql_cek);
		$e = mysqli_fetch_array($sqlcek_terakhirAbsen);
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
		$hari = date('l');		
		if ($hari == "Sunday") {
			return "Minggu";
		}else if($hari == "Monday"){
			return "Senin";
		}else if($hari == "Tuesday"){
			return "Selasa";
		}else if($hari == "Wednesday"){
			return "Rabu";
		}else if($hari == "Thursday"){
			return "Kamis";
		}else if($hari == "Friday"){
			return "Jumat";
		}else{
			return "Sabtu";
		}
	}

	function tambah_izin($nik)
	{
		include "koneksi.php";
		$today = date("Y-m-d-H:i:s");
		$guru = get_guru($nik);
		$terakhir_absen = last_presence($nik);
		$new_izin = 0;
		$q_mastergaji = '';
		if ($terakhir_absen == null) {
		// BELUM ADA DATA MASTER GAJI Guru terkait, bikin baru!
			$th_bln = date("Y-m");
			$q_mastergaji = "INSERT INTO master_gaji (tahun_bulan, nik, absen, izin, alpa, jam_mengajar) VALUES (\"".$th_bln."\", \"".$nik."\", 0, 1, 0, 0)";
		// $q_mGaji = mysqli_query($konek, $q_mastergaji);
		}else{
			$new_izin = $terakhir_absen['izin'] + 1;
			$q_mastergaji = "UPDATE master_gaji SET izin=$new_izin, updated_at='$today' WHERE id=$terakhir_absen[id]";
		}

	// Menambah data dengan status perizinan IZIN di tabel absensi
		$q_simpanAbsen = "INSERT INTO absensi (nik, nama_guru, status, tanggal, jam_mengajar) VALUES ('".$guru['nik']."', '".$guru['nama_guru']."','Izin','$today',0)";
	// Mengupdate data MASTER GAJI

	// Debug sudah sampai gimana
		echo "<br><br><br>";
		echo $nik . "<br>";
		echo $q_Update_mastergaji . " Q Update master_gaji<br>";
		echo $q_simpanAbsen . " Q Simpan absen izin<br>";
	// Eksekusi query simpan dan update
		$simpan = mysqli_query($konek, $q_simpanAbsen);
		$q_mGaji = mysqli_query($konek, $q_mastergaji);
	// die;
		if($simpan && $q_mGaji){
			echo "Data ubah izin mGaji sudah masuk & diupdate";
			header('location:absen.php?message=Izin&nama_guru='.$_GET['nama_guru']);
		//header('location:index.php?e=sukses');
		}else{
			echo "Data ubah izin mGaji GAGAL diupdate";
			header('location:absen.php?message=Izin&e=gagal&nama_guru='.$_GET['nama_guru']);
		// header('location:index.php?e=gagal');
		}
	}
	?>
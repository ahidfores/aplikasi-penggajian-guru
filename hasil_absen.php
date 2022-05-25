<!DOCTYPE html>
<html>
<head>
	<title>Hasil Absensi</title>
</head>
<body>
<?php 
if (isset($_GET['e'])){ 
	if ($_GET['e'] == "sukses"){ 
		?>
		<h1> Selamat, absensi diterima ! </h1>
		<script type="text/javascript"> alert("Absensi diterima!");</script>
		<?php 
	}else if($_GET['e'] == "out_of_time"){ 
		?>
		<h1> Belum waktunya anda untuk absen atau anda terlambat! Absen ditolak! </h1>
		<script type="text/javascript"> alert("Belum waktunya anda untuk absen atau anda terlambat! Absen ditolak!");</script>    
		<?php 
	}else if($_GET['e'] == "gagal"){
		?>
		<h1> Absen ditolak! </h1>
		<script type="text/javascript"> alert("Absen ditolak!");</script>    
		<?php 
	}
}
?>     
</body>
</html>
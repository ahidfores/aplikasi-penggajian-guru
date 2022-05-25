<?php
session_start();
if(isset($_SESSION['login'])){
	include "koneksi.php";
	include "fungsi.php";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Data Guru</title>
	<style type="text/css">
		body{
			font-family: Arial;
		}
		table{
			border-collapse: collapse;
		}

		@media print{
			.no-print{
				display: none;
			}
		}
	</style>
</head>
<body>
<h3>SMK SIROJUL ULUM GONDANGLEGI</h3>
<hr>
<p>LAPORAN DATA GURU</p>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<th>No</th>
		<th>NIK</th>
		<th>Nama Guru</th>
		<th>Jabatan</th>
		<th>Status</th>
	</tr>
	<?php
	$sql=mysqli_query($konek, "SELECT guru.*, jabatan.nama_jabatan
								FROM guru
								INNER JOIN jabatan ON guru.kode_jabatan=jabatan.kode_jabatan
								ORDER BY jabatan.nama_jabatan DESC");
	$no = 1;
	while ($d=mysqli_fetch_array($sql)){
		echo "<tr>
		      <td align='center' width='40px'>$no</td>
		      <td align='center'>$d[nik]</td>
		      <td>$d[nama_guru]</td>
		      <td>$d[nama_jabatan]</td>
		      <td>$d[status]</td>

		</tr>";
		$no++;
	}

	if(mysqli_num_rows($sql) < 1){
		echo "<tr><td colspan='7'> Belum ada data...</td></tr>";
	}
	?>
</table>

<table width="100%">
	<tr>
		<td></td>
		<td width="200px">
			<p>
				<p>Sumber Jaya, <?php echo tglIndonesia(date("Y/m/d")); ?>
				<br>
				Administrator,	
			</p>
			<br>
			<br>
			<br>
			<p>_________________________________</p>
		</td>
	</tr>
</table>

<a href="#" class="no-print" onclick="window.print();">Cetak/Print</a>
	
</body>
</html>
<?php
}else{
	header('location:login.php');
}
?>
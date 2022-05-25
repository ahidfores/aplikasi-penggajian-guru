<?php
session_start();
if(isset($_SESSION['login'])){
	include "koneksi.php";
	include "fungsi.php";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Data Mapel</title>
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
<p>LAPORAN DATA MAPEL</p>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<th>No</th>
		<th>Kode Pengajar</th>
		<th>Nama Mapel</th>
	</tr>
	<?php
	$sql=mysqli_query($konek, "SELECT * FROM mapel ORDER BY kode_pengajar ASC");
	$no = 1;
	while ($d=mysqli_fetch_array($sql)){
		echo "<tr>
		      <td align='center' width='40px'>$no</td>
		      <td align='center'>$d[kode_pengajar]</td>
		      <td>$d[nama_mapel]</td>
		</tr>";
		$no++;
	}

	if(mysqli_num_rows($sql) < 1){
		echo "<tr><td colspan='8'> Belum ada data...</td></tr>";
	}
	?>
</table>

<table width="100%">
	<tr>
		<td></td>
		<td width="200px">
			<p>
				Sumber Jaya, <?php echo tglIndonesia(date("Y/m/d")); ?>
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
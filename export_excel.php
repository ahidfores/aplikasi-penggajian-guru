<!DOCTYPE html>
<html>
<head>
	<title>Export Data Ke Excel</title>
</head>
<body>

	<?php 

	function getPotongan($nik, $tahun_bulan)
	{
		include "koneksi.php";		
		$th_bln = date("Y-m");	
		$sql_cek = "SELECT nik, total_potongan FROM master_gaji WHERE nik='$nik' AND tahun_bulan='$tahun_bulan'";
		$sqlcek_terakhirMG = mysqli_query($konek, $sql_cek);
		$e = mysqli_fetch_array($sqlcek_terakhirMG);
		if ($e != null) {
			return $e['total_potongan'];
		}else{
			return 0;
		}
	// return $e['total_potongan'];
	}

	$bulan = date('m');
	$tahun = date('Y');
	$tahun_bulan = $tahun."-".$bulan;
	if((isset($_GET['bulan']) && $_GET['bulan']!='') && (isset($_GET['tahun']) && $_GET['tahun']!='')){
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$tahun_bulan = $tahun."-".$bulan;
	}

	function get_JmlHari($bulan)
	{
		$jumlah_hari = 0;
		$bulan_ini = $bulan;
		if ($bulan_ini == 1) {
			$jumlah_hari = 31;
		}else if ($bulan_ini == 2) {
			if (date('Y')%4 == 0) {
				$jumlah_hari = 29;
			}else{
				$jumlah_hari = 28;
			}
		}else if ($bulan_ini == 3) {
			$jumlah_hari = 31;
		}else if ($bulan_ini == 4) {
			$jumlah_hari = 30;
		}else if ($bulan_ini == 5) {
			$jumlah_hari = 31;
		}else if ($bulan_ini == 6) {
			$jumlah_hari = 30;
		}else if ($bulan_ini == 7) {
			$jumlah_hari = 31;
		}else if ($bulan_ini == 8) {
			$jumlah_hari = 31;
		}else if ($bulan_ini == 9) {
			$jumlah_hari = 30;
		}else if ($bulan_ini == 10) {
			$jumlah_hari = 31;
		}else if ($bulan_ini == 11) {
			$jumlah_hari = 30;
		}else if ($bulan_ini == 12) {
			$jumlah_hari = 31;
		}
		return $jumlah_hari;
	}

	function buatRp($angka){
		$rupiah = "Rp ". number_format($angka,0,',','.') . ",-";
		return $rupiah;
	}
	?>
	<style type="text/css">
		body{
			font-family: sans-serif;
		}
		table{
			margin: 20px auto;
			border-collapse: collapse;
		}
		table th,
		table td{
			border: 1px solid #3c3c3c;
			padding: 3px 8px;

		}
		a{
			background: blue;
			color: #fff;
			padding: 8px 10px;
			text-decoration: none;
			border-radius: 2px;
		}
	</style>

	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Penggajian Guru.xls");
	?>	

	<!--  -->

	<table border="1">	
		<tr>
			<td colspan="9" align="center"> <b>REKAP GAJI BULAN <?=$bulan . " TAHUN " . $tahun; ?></b> </td>
		</tr>
		<tr>
			<th>No.</th>
			<th>NIK</th>
			<th>Nama Guru</th>
			<th>Jabatan</th>
			<th>Gapok</th>
			<th>Tunjangan</th>
			<th>M x Rp7500</th>
			<th>Potongan</th>
			<th>Total Gaji</th>
		</tr>
		<?php
		include 'koneksi.php';
								// QUERY data dan grouping gaji
								// $sql = mysqli_query($konek, "
								// 	SELECT guru.nik,guru.nama_guru,jabatan.nama_jabatan,jabatan.gapok,jabatan.tunjangan,
								// 	(gapok + tunjangan ) + (jam_mengajar*7500) AS totalgaji
								// 	FROM guru 
								// 	INNER JOIN master_gaji ON master_gaji.nik=guru.nik
								// 	INNER JOIN jabatan ON jabatan.kode_jabatan=guru.kode_jabatan
								// 	WHERE master_gaji.bulan='$bulantahun'
								// 	ORDER BY guru.nik ASC");
		$sql = mysqli_query($konek, "SELECT gu.nik, gu.nama_guru, j.nama_jabatan, j.gapok, j.tunjangan, (j.gapok+j.tunjangan) as sum_pokok FROM guru gu JOIN jabatan j ON gu.kode_jabatan = j.kode_jabatan");

		$no=1;

		while($d=mysqli_fetch_array($sql)){
			$gapok = $d['gapok'];
			$tunjangan = $d['tunjangan'];
			$potongan = (int)getPotongan($d['nik'], $tahun_bulan);
			$jam_x_7500 = 0;								
			echo"<tr>
			<td width='40px' align='center'>$no</td>
			<td width='60px'>'$d[nik]</td>
			<td>$d[nama_guru]</td>
			<td>$d[nama_jabatan]</td>
			<td>".$d['gapok']."</td>
			<td>".$d['tunjangan']."</td>";
			?>

			<!--Bagian untuk query potongan-->

			<?php
			$query_jam = "SELECT nik, nama_guru, SUM(jam_mengajar) as total_jam
			FROM absensi a 
			WHERE MONTH(a.tanggal) LIKE '%'+$bulan+'%' AND YEAR(a.tanggal) LIKE '%'+$tahun+'%' GROUP BY nik";
			$sql_jam = mysqli_query($konek, $query_jam);
			if (mysqli_num_rows($sql_jam) > 0) {
				while($d_jam=mysqli_fetch_array($sql_jam)){
					if ($d['nik'] == $d_jam['nik']) {
						$jam_x_7500 = $d_jam['total_jam'] * 7500;
					}
				}
									// BATAS 7500xjampel
				echo "<td>".$jam_x_7500."</td>";
									// Cetak Potongan
				echo "<td>".$potongan."</td>";
									// <td>"."---Diproses---"."</td> Hitung total gaji disini
				echo "<td>".(($gapok + $tunjangan + $jam_x_7500)-$potongan)."</td>";			
			}else{
										// BATAS 7500xjampel
				echo "<td>---  ---</td>";
										// Null potongan
				echo "<td>---  ---</td>";
									// <td>"."---Diproses---"."</td> Hitung total gaji disini
				echo "<td>---  ---</td>";
			}
			echo "</tr>";
			$no++;
		}
		?>
	</table>
</body>
</html>
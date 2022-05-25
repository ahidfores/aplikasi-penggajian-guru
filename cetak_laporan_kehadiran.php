<?php
session_start();
if(isset($_SESSION['login'])){
	include "koneksi.php";
	include "fungsi.php";
	$bulan = date('m');
	$tahun = date('Y');
	if((isset($_GET['bulan']) && $_GET['bulan']!='') && (isset($_GET['tahun']) && $_GET['tahun']!='')){
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
	}else{
		$bulan = date('m');
		$tahun = date('Y');
	}
	$th_bln = $tahun.'-'.$bulan;

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

	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Laporan Data Kehadiran</title>
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
		<p>LAPORAN REKAP DATA KEHADIRAN BULAN <?= $bulan; ?> TAHUN <?= $tahun; ?></p>
		<table border="1" cellpadding="4" cellspacing="0" width="100%">
			<tr>
				<th>No.</th>
				<th>NIK</th>
				<th>Nama Guru</th>
				<th>Total Jumlah Jam</th>
				<th>Masuk</th>
				<th>Izin</th>
				<th>Alpha</th>
			</tr>
			<?php
			$sql_guru = mysqli_query($konek, "SELECT nik, nama_guru FROM guru");
			$no=1;
			while($dGuru=mysqli_fetch_array($sql_guru)){							
				$masuk = 0;
				$izin = 0;
				$jam_total = 0;
				echo "<tr>
				<td>$no</td>
				<td>$dGuru[nik]</td>
				<td>$dGuru[nama_guru]</td>";
				// New Query
				$q = "(SELECT absen, izin FROM master_gaji where tahun_bulan LIKE \"".$th_bln."\")";
				$query = "SELECT guru.nik, guru.nama_guru, mg.absen, mg.izin, mg.jam_mengajar FROM guru left JOIN (SELECT absen, izin, nik, jam_mengajar FROM master_gaji where tahun_bulan LIKE \"".$th_bln."\") mg ON mg.nik=guru.nik 
				ORDER BY guru.nama_guru ASC";
				// echo $query;
				// die;
				$sqlRekapAbsen = mysqli_query($konek, $query);
				if (mysqli_num_rows($sqlRekapAbsen) > 0) {
					while($d_absen=mysqli_fetch_array($sqlRekapAbsen)){
						if ($dGuru['nik'] == $d_absen['nik']) {
							if ($d_absen['jam_mengajar'] != NULL) {
								$jam_total = $d_absen['jam_mengajar'];
							}else{
								$jam_total = 0;
							}
							if ($d_absen['absen'] != NULL && $d_absen['izin'] != NULL) {
								$masuk = $d_absen['absen'];
								$izin = $d_absen['izin'];
							}
						}
					}
					echo "
					<td align='right'>$jam_total</td>
					<td align='right'>$masuk</td>
					<td align='right'>$izin</td>
					<td align='right'>".(get_JmlHari($bulan)-($masuk+$izin))."</td>";
				}else{
					echo "<td>--- ---</td>
					<td>--- ---</td>
					<td>--- ---</td>";;
				}
				echo "</tr>";
				$no++;
			}

					// }else{
					// 	echo "<tr>
					// 	<td colspan='8' text-align='center'>
					// 		Belum ada data pada bulan dan tahun yang anda pilih...!!!
					// 	</td>
					// </tr>";
					// }
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
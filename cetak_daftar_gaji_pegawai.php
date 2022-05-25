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
		<title>Cetak Laporan Data Penggajian</title>
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
		<p>LAPORAN DATA PENGGAJIAN <?=get_Bulan($bulan) . ' ' . $tahun;?></p>

		<!-- <hr style="height:3px;border-width:0;color:gray;background-color:gray"> -->		
		<table border="1" cellpadding="4" cellspacing="0" width="100%">
			<thead>
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
			</thead>
			<tbody>
				<?php
				$sql = mysqli_query($konek, "SELECT gu.nik, gu.nama_guru, j.nama_jabatan, j.gapok, j.tunjangan, (j.gapok+j.tunjangan) as sum_pokok FROM guru gu JOIN jabatan j ON gu.kode_jabatan = j.kode_jabatan");
				$no=1;
				while($d=mysqli_fetch_array($sql)){
					$gapok = $d['gapok'];
					$tunjangan = $d['tunjangan'];
					$potongan = (int)getPotongan($d['nik'], $th_bln);
					$jam_x_7500 = 0;								
					echo"<tr>
					<td width='40px' align='center'>$no</td>
					<td width='60px'>$d[nik]</td>
					<td>$d[nama_guru]</td>
					<td>$d[nama_jabatan]</td>
					<td align='right'>".buatRp($d['gapok'])."</td>
					<td align='right'>".buatRp($d['tunjangan'])."</td>";
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
						echo "<td align='right'>".buatRp($jam_x_7500)."</td>";
									// Cetak Potongan
						echo "<td align='right'>".buatRp($potongan)."</td>";
									// <td>"."---Diproses---"."</td> Hitung total gaji disini
						echo "<td align='right'>".buatRp(($gapok + $tunjangan + $jam_x_7500)-$potongan)."</td>";
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
			</tbody>
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

	function get_Bulan($bulan)
	{
		if ($bulan == '01') {
			return "JANUARI";
		}else if($bulan == '02'){
			return "FEBRUARI";
		}else if($bulan == '03'){
			return "MARET";
		}else if($bulan == '04'){
			return "APRIL";
		}else if($bulan == '05'){
			return "MEI";
		}else if($bulan == '06'){
			return "JUNI";
		}else if($bulan == '07'){
			return "JULI";
		}else if($bulan == '08'){
			return "AGUSTUS";
		}else if($bulan == '09'){
			return "SEPTEMBER";
		}else if($bulan == '10'){
			return "OKTOBER";
		}else if($bulan == '11'){
			return "NOVEMBER";
		}else if($bulan == '12'){
			return "DESEMBER";
		}
	}	

	?>
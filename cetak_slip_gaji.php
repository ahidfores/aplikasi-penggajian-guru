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
	$nik = $_GET['nik'];
	$this_guru = get_guru($nik);
	$potongan = getPotongan($nik, $th_bln);

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

	<?php
	include 'koneksi.php';
	$gapok = 0;
	$tunjangan = 0;
	$jamxupah = 0;
	$totalgaji = 0;
	$potongan = 0;									
	$gapok = $this_guru['gapok'];
	$tunjangan = $this_guru['tunjangan'];

	$query_jam = "SELECT SUM(jam_mengajar) as total_jam
	FROM absensi a 
	WHERE MONTH(a.tanggal) LIKE '%'+$bulan+'%' AND YEAR(a.tanggal) LIKE '%'+$tahun+'%' AND a.nik='".$_GET['nik']."'";
	$sql_jam = mysqli_query($konek, $query_jam);
	if (mysqli_num_rows($sql_jam) > 0) {
		$d_jam=mysqli_fetch_array($sql_jam);
		$jamxupah = $d_jam['total_jam'] * 7500;
	}

	$potongan = (int)getPotongan($_GET['nik'], $th_bln);

	$totalgaji = $gapok + $tunjangan + $jamxupah - $potongan;

	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title> Cetak Slip Gaji </title>
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
		<p style="text-align:center; bottom:0;">
			<b style="font-size:24px;">SMK SIROJUL ULUM GONDANGLEGI</b> <br><br>		
			<span style="font-size:18px;">Jl. Arjuna, No. 51 RT. 05 / RW. 02 Ds. Sumberjaya, Kec. Gondanglegi Malang</span>
		</p>
		<p style="text-align:center; bottom:0;"><b>----------------------------------------------------------------------------------------------------------------------------------------------------</b></p>
		<!-- <hr style="height:3px;border-width:0;color:gray;background-color:gray"> -->
		<table border="0" cellpadding="4" cellspacing="0" width="100%">
			<tr>
				<td colspan="2" align="center">
					<b style="font-size:24px; text-decoration:underline;">SLIP GAJI KARYAWAN</b> <br>
					<b>Periode <?= '1 '.get_Bulan($bulan).' ' .$tahun . ' - '. get_JmlHari($bulan) . ' ' . get_Bulan($bulan) . ' '. $tahun;?></b>
				</td>
			</tr>
			<tr>
				<td colspan="" width="75px;"><b>NIK</b></td>
				<td colspan="" align="left"><b>: <?=$nik;?></b></td>
			</tr>
			<tr>
				<td colspan="" width="75px;">Nama</td>
				<td colspan="" align="left"><b>: <?=$this_guru['nama_guru'];?></b></td>
			</tr>
			<tr>
				<td colspan="" width="75px;">Jabatan</td>
				<td colspan="" align="left"><b>: <?=$this_guru['nama_jabatan'];?></b></td>
			</tr>
		</table>
		<br>
		<table width="100%">
			<tr>
				<td colspan=""><b>PENGHASILAN</b></td>
				<td colspan=""></td>
				<td colspan=""><b>POTONGAN</b></td>
				<td colspan=""></td>
			</tr>
			<tr>
				<td colspan=""><b>Gaji Pokok</b></td>
				<td colspan="" align="right"><b><?=buatRP($gapok);?></b></td>
				<td colspan=""><b>Total Potongan</b></td>
				<td colspan="" align="right"><b><?=buatRP($potongan);?></b></td>
			</tr>
			<tr>
				<td colspan=""><b>Tj. Jabatan</b></td>
				<td colspan="" align="right"><b><?=buatRP($this_guru['tunjangan']);?></b></td>
				<td colspan="" align="right"></td>
				<td colspan=""></td>
			</tr>
			<tr>
				<td colspan=""><b>M x Rp. 7500</b></td>
				<td colspan="" align="right"><b><?=buatRP($jamxupah);?></b></td>
				<td colspan="" align="right"></td>
				<td colspan=""></td>
			</tr>
			<tr>
				<td colspan=""></td>
				<td colspan="" align="right"><b>-------------- +</b></td>
				<td colspan=""></td>
				<td colspan="" align="right"><b>-------------- +</b></td>
			</tr>
			<tr>
				<td colspan="" align="right"><b>Total (A)</b></td>
				<td colspan="" align="right"><b><?=buatRP($gapok+(int)$this_guru['tunjangan']+$jamxupah);?></b></td>
				<td colspan="" align="right"><b>Total (B)</b></td>
				<td colspan="" align="right"><b><?=buatRP($potongan);?></b></td>
			</tr>			
				<br>
			<tr>
				<td colspan="4" align="center"><br><b>PENERIMAAN BERSIH (A-B) = <?=buatRP($totalgaji);?></b></td>
			</tr>
			<tr>
				<td colspan="4" align="center"> <b>Terbilang : " <?=terbilang($totalgaji);?> "</b></td>
			</tr>
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

	function get_guru($nik)
	{
		include "koneksi.php";	
		$sql = mysqli_query($konek, "SELECT g.*, j.* FROM guru g JOIN jabatan j ON g.kode_jabatan = j.kode_jabatan WHERE nik=$nik");
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

	function get_Bulan($bulan)
	{
		if ($bulan == '01') {
			return "Januari";
		}else if($bulan == '02'){
			return "Februari";
		}else if($bulan == '03'){
			return "Maret";
		}else if($bulan == '04'){
			return "April";
		}else if($bulan == '05'){
			return "Mei";
		}else if($bulan == '06'){
			return "Juni";
		}else if($bulan == '07'){
			return "Juli";
		}else if($bulan == '08'){
			return "Agustus";
		}else if($bulan == '09'){
			return "September";
		}else if($bulan == '10'){
			return "Oktober";
		}else if($bulan == '11'){
			return "November";
		}else if($bulan == '12'){
			return "Desember";
		}
	}

	// FUNGSI UNTUK MELAKUKAN PENYEBUTAN NOMINAL GAJI
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil . " rupiah";
	}	

	?>
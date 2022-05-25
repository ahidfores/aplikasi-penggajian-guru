<?php include "header_user.php"; ?>
<div class="container">
	
	<?php
	$view = isset($_GET['view']) ? $_GET['view'] : null;
	$bulan = date('m');
	$tahun = date('Y');
	if((isset($_GET['bulan']) && $_GET['bulan']!='') && (isset($_GET['tahun']) && $_GET['tahun']!='')){
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
	}	
	$tahun_bulan = $tahun.'-'.$bulan;

	function buatRp($uang)
	{
		$formatted = "Rp. ". $uang . ",-";
		return $formatted;
	}

	switch($view){
		default

		?>

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">DATA GAJI GURU <strong><?php echo $_SESSION['namalengkap'];?></strong></h3>
				</div>
				<div class="panel-body">
					<form class="form-inline" method="get" action="">
						<div class="form-group">
							<label>Bulan</label>
							<select name="bulan" class="form-control">
								<option value="01" <?php echo $bulan==1 ? "selected" : ""; ?>>Januari</option>
								<option value="02" <?php echo $bulan==2 ? "selected" : ""; ?>>Februari</option>
								<option value="03" <?php echo $bulan==3 ? "selected" : ""; ?>>Maret</option>
								<option value="04" <?php echo $bulan==4 ? "selected" : ""; ?>>April</option>
								<option value="05" <?php echo $bulan==5 ? "selected" : ""; ?>>Mei</option>
								<option value="06" <?php echo $bulan==6 ? "selected" : ""; ?>>Juni</option>
								<option value="07" <?php echo $bulan==7 ? "selected" : ""; ?>>Juli</option>
								<option value="08" <?php echo $bulan==8 ? "selected" : ""; ?>>Agustus</option>
								<option value="09" <?php echo $bulan==9 ? "selected" : ""; ?>>September</option>
								<option value="10" <?php echo $bulan==10 ? "selected" : ""; ?>>Oktober</option>
								<option value="11" <?php echo $bulan==11 ? "selected" : ""; ?>>November</option>
								<option value="12" <?php echo $bulan==12 ? "selected" : ""; ?>>Desember</option>

							</select>
						</div>
						<div class="form-group">
							<label>Tahun</label>
							<select name="tahun" class="form-control">
								<option value="">- Pilih -</option>
								<?php
								$y = date('Y');
								for ($i=2021;$i<=$y+2;$i++){
									if ($i == $y) {
										echo "<option value='$i' selected>$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								}
								?>

							</select>
						</div>
						<button type="submit" class="btn btn-primary">Tampilkan Data</button>
					</form>
					<br>
					
					<div class="alert alert-info">
						<strong>Bulan : <?php echo $bulan; ?>, Tahun : <?php echo $tahun; ?></strong>
					</div> 

					<div class="table-responsive">

						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th width="45%">Penerimaan</th>
									<th width="50%">Jumlah (Rp.)</th>
								</tr>
							</thead>
							<tbody>
								<?php
								include '../koneksi.php';
								$gapok = 0;
								$tunjangan = 0;
								$jamxupah = 0;
								$totalgaji = 0;
								$potongan = 0;
								// QUERY data dan grouping gaji
								// $sql = mysqli_query($konek, "
								// 	SELECT guru.nik,guru.nama_guru,jabatan.nama_jabatan,jabatan.gapok,jabatan.tunjangan,
								// 	(gapok + tunjangan ) + (jam_mengajar*7500) AS totalgaji
								// 	FROM guru 
								// 	INNER JOIN master_gaji ON master_gaji.nik=guru.nik
								// 	INNER JOIN jabatan ON jabatan.kode_jabatan=guru.kode_jabatan
								// 	WHERE master_gaji.bulan='$bulantahun'
								// 	ORDER BY guru.nik ASC");
								$q_gaji_guru = "SELECT gu.nik, gu.nama_guru, j.nama_jabatan, j.gapok, j.tunjangan FROM guru gu JOIN jabatan j ON gu.kode_jabatan = j.kode_jabatan WHERE gu.nik='".$_SESSION['nik']."'";
								$sql = mysqli_query($konek, $q_gaji_guru);
								$d_jabatan=mysqli_fetch_array($sql);
								$gapok = $d_jabatan['gapok'];
								$tunjangan = $d_jabatan['tunjangan'];

								$query_jam = "SELECT SUM(jam_mengajar) as total_jam
								FROM absensi a 
								WHERE MONTH(a.tanggal) LIKE '%'+$bulan+'%' AND YEAR(a.tanggal) LIKE '%'+$tahun+'%' AND a.nik='".$_SESSION['nik']."'";
								$sql_jam = mysqli_query($konek, $query_jam);
								if (mysqli_num_rows($sql_jam) > 0) {
									$d_jam=mysqli_fetch_array($sql_jam);
									$jamxupah = $d_jam['total_jam'] * 7500;
								}

								$potongan = (int)getPotongan($_SESSION['nik'], $tahun_bulan);

								$totalgaji = $gapok + $tunjangan + $jamxupah - $potongan;
								
								?>
								<tr>
									<td align="center">1</td>
									<td> Gaji Pokok </td>
									<td align="right"><?= buatRp($gapok); ?></td>
								</tr>
								<tr>
									<td align="center">2</td>
									<td> Tunjangan </td>
									<td align="right"><?= buatRp($tunjangan); ?></td>
								</tr>
								<tr>
									<td align="center">3</td>
									<td> Jam Mengajar x Rp. 7.500,- </td>
									<td align="right"><?= buatRp($jamxupah); ?></td>
								</tr>
								<tr>
									<td align="center">4</td>
									<td> Potongan </td>
									<td align="right"><?= buatRp($potongan); ?></td>
								</tr>
								<tr>
									<td colspan="2" align="right"><strong>Total (Rp.)</strong></td>
									<td align="right"><?= buatRp($totalgaji); ?></td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
				<div class="panel-footer"></div>				
			</div>

			<?php

			break;

		}
		?>

	</div> 
	</div> 
	<?php 
		function getPotongan($nik, $tahun_bulan)
		{
			include "../koneksi.php";		
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

		include "footer_user.php"; 
	?>
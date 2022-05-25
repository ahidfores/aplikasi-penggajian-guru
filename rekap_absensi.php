<?php include "header.php"; ?>
<div class="container">
	
	<?php
	$view = isset($_GET['view']) ? $_GET['view'] : null;

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
	switch($view){
		default
		?>

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Data Kehadiran Guru</h3>
				</div>			
				<div class="panel-body">			
					<form class="form-inline" method="get" action="">
						<div class="form-group">
							<label>Bulan</label>
							<select name="bulan" class="form-control">
								<option value="">- Pilih -</option>
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

					<table class="table table-bordered table-striped">
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
							// GET DATA REKAP ABSEN
							
							// Old Query, ga ambil master_gaji
							// $query = "SELECT nik, nama_guru, count(*) as masuk
							// FROM absensi a 
							// WHERE MONTH(a.tanggal) LIKE '%'+$bulan+'%' AND YEAR(a.tanggal) LIKE '%'+$tahun+'%' GROUP BY nik";

							// New Query
							$q = "(SELECT absen, izin FROM master_gaji where tahun_bulan LIKE \"".$th_bln."\")";
							$query = "SELECT guru.nik, guru.nama_guru, mg.absen, mg.izin, mg.jam_mengajar FROM guru left JOIN (SELECT absen, izin, nik, jam_mengajar FROM master_gaji where tahun_bulan LIKE \"".$th_bln."\") mg ON mg.nik=guru.nik 
							ORDER BY guru.nama_guru ASC

							";
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
								<td class='text-right'>$jam_total</td>
								<td class='text-right'>$masuk</td>
								<td class='text-right'>$izin</td>
								<td class='text-right'>".(get_JmlHari($bulan)-($masuk+$izin))."</td>";
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
				</div>
				<?php
				$q = "(SELECT absen, izin FROM master_gaji where tahun_bulan LIKE \"".$th_bln."\")";
				$query = "SELECT absen, izin, nik, jam_mengajar FROM master_gaji where tahun_bulan LIKE \"".$th_bln."\"";
							// echo $query;
							// die;
				$sqlRekapAbsen = mysqli_query($konek, $query);
				if (mysqli_num_rows($sqlRekapAbsen) > 0){
					echo "
					<center>
						<a class='btn btn-success' href='cetak_laporan_kehadiran.php?bulan=$bulan&tahun=$tahun' target='_blank'><span class='glypicon glypicon-print'></span>Cetak Rekap Kehadiran Guru</a>						
					</center><br>
					";
				}else{
					echo "<h2 align='center'> Belum ada data untuk dicetak ! </h2><br>";
				}
				?>
			</div>
		</div>


		<?php

		break;
	}
	?>

</div> 
<?php include "footer.php"; ?>
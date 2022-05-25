<?php include "header.php"; ?>
<div class="container">
	
	<?php
	$view = isset($_GET['view']) ? $_GET['view'] : null;
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

	switch($view){
		default

		?>

		<?php
		if(isset($_GET['e']) && $_GET['e']=='sukses'){
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Selamat!</strong> Proses Berhasil!
					</div>
				</div>
			</div>
			<?php
		}elseif(isset($_GET['e']) && $_GET['e']=='gagal'){
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong> Proses gagal dilakukan.
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Gaji Guru</h3>
				</div>
				<div class="panel-body">
					<form class="form-inline" method="get" action="">
						<div class="row">
							<div class="col-lg-6">
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
							</div>
							<div class="col-lg-6" align="right">
								<a href="data_potongan.php?view=tambah" class="btn btn-info float-right">Tambah Data Potongan</a>
							</div>
						</div>
					</form>
				</div>

				<div class="alert alert-info">
					<strong>Bulan : <?php echo $bulan; ?>, Tahun : <?php echo $tahun; ?></strong>
				</div> 

				<div class="table-responsive">

					<table class="table table-bordered table-striped">
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
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
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
								<td width='60px'>$d[nik]</td>
								<td>$d[nama_guru]</td>
								<td>$d[nama_jabatan]</td>
								<td>".buatRp($d['gapok'])."</td>
								<td>".buatRp($d['tunjangan'])."</td>";
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
									echo "<td>".buatRp($jam_x_7500)."</td>";
									// Cetak Potongan
									echo "<td>".buatRp($potongan)."</td>";
									// <td>"."---Diproses---"."</td> Hitung total gaji disini
									echo "<td>".buatRp(($gapok + $tunjangan + $jam_x_7500)-$potongan)."</td>";

								?>
									<td width="50px">
										<a href="data_potongan.php?nik=<?php echo $d['nik'];?>&tahun=<?php echo $tahun;?>&bulan=<?php echo $bulan;?>" class="btn btn-primary" style="width:100%;">Cek Potongan</a><br>										
										<a href='cetak_slip_gaji.php?bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>&nik=<?php echo $d['nik'];?>' target='_blank' class="btn btn-warning" style="width:100%;">Cetak Slip</a>
									</td>								
								<?php
								}else{
										// BATAS 7500xjampel
									echo "<td>---  ---</td>";
										// Null potongan
									echo "<td>---  ---</td>";
									// <td>"."---Diproses---"."</td> Hitung total gaji disini
									echo "<td>---  ---</td>";
								?>
									<td width="50px">
										<a href="#" class="btn" style="width:100%; background:grey; color:white; border-color:white;">Cek Potongan</a><br>
										<a href="#" class="btn" style="width:100%; background:grey; color:white; border-color:white;">Cetak Slip</a>
									</td>	
								<?php
								}
								echo "</tr>";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>

			</div>
			<?php
			if (mysqli_num_rows($sql_jam) > 0){
				echo "
				<center>
					<a class='btn btn-success' href='cetak_daftar_gaji_pegawai.php?bulan=$bulan&tahun=$tahun' target='_blank'><span class='glypicon glypicon-print'></span>Cetak Daftar Gaji Guru</a>					
					<a class='btn btn-warning' href='export_excel.php?bulan=$bulan&tahun=$tahun' target='_blank'>Export ke Excel</a>
				</center><br>
				";
			}
			?>

		</div>

		<?php

		break;

	}
	?>

</div> 
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

include "footer.php"; 
?>
<?php include "header_user.php"; ?>
<div class="container">

	<?php
	$nik = $_SESSION['nik'];
	$this_guru = get_guru($nik);
	?>	
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body" align="center">
								<img src="../assets/img/logokaryawan.png" style="width:50%;">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="card">
							<h3>Profil Guru</h3>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">Nama - <b><?=$this_guru['nama_guru']; ?></b></li>
								<li class="list-group-item">NIK - <b><?=$this_guru['nik']; ?></b></li>
								<li class="list-group-item">Jabatan - <b><?=$this_guru['nama_jabatan']; ?></b></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-heading">
				<h3 class="panel-title">
					Jadwal Mengajar Guru <strong><?= $this_guru['nama_guru'];?></strong>
				</h3>
			</div>

			<div class="panel-body">
				<form action="" method="get" class="form-inline">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Tahun Pelajaran </label>
								<select name="tahun" class="form-control">
									<option value="">- Pilih -</option>
									<?php
									$y = date('Y');
									for ($i=2021;$i<=$y+2;$i++){
										if ($i == $y) {
											echo "<option value='$i-".($i+1)."' selected>$i - ".($i+1)."</option>";
										}else{
											echo "<option value='$i-".($i+1)."'>$i - ".($i+1)."</option>";
										}
									}
									?>

								</select>
							</div>
							<div class="form-group">
								<select name="semester" class="form-control">
									<option value="ganjil">Ganjil</option>
									<option value="genap">Genap</option>
								</select>
							</div>
							<button type="submit" class='btn btn-primary btn-sm'>Cari</button>
						</div>
					</div>
				</form>
				<br>
				<?php
				if(isset($_GET['tahun']) && $_GET['tahun'] != ''){
					echo "Hasil Pencarian Jadwal <b>Periode ".$_GET['tahun']."</b> Semester <b>". CekSemester($_GET['semester'])."</b>";
				}
				?>
				<table class="table table-bordered table-striped">
					<tr>
						<th>No</th>
						<th>Nama Guru</th>
						<th>Nama Mapel</th>
						<th>Hari</th>
						<th>Jam Mulai</th>
						<th>Jam Berakhir</th>
						<th>Tahun Ajaran / Semester</th>
					</tr>

					<?php
					if(isset($_GET['tahun']) && $_GET['tahun'] != ''){
						$tahun_ajar = $_GET['tahun'];
						$semester = $_GET['semester'];
						$q = "SELECT jadwal.*, guru.nama_guru,mapel.nama_mapel FROM jadwal 
						INNER JOIN guru ON jadwal.nik=guru.nik
						INNER JOIN mapel ON jadwal.kode_pengajar=mapel.kode_pengajar 
						WHERE tahun_ajar='$tahun_ajar' AND semester='$semester' AND guru.nik='$nik'";
						$sql = mysqli_query($konek, $q);
					}else {
						$sql = mysqli_query($konek, "SELECT jadwal.*, guru.nama_guru,mapel.nama_mapel FROM jadwal 
							INNER JOIN guru ON jadwal.nik=guru.nik
							INNER JOIN mapel ON jadwal.kode_pengajar=mapel.kode_pengajar 
							WHERE guru.nik='$nik'
							ORDER BY guru.nama_guru ASC");
					}
					$no=1;
					if (mysqli_num_rows($sql) > 0) {
						# code...
						while($d=mysqli_fetch_array($sql)){
							echo "<tr>
							<td width='40px' align='center'>$no</td>
							<td width='200px'>$d[nama_guru]</td>
							<td>$d[nama_mapel]</td>
							<td>$d[hari]</td>
							<td>$d[jam_mulai]</td>
							<td>$d[jam_berakhir]</td>
							<td>$d[tahun_ajar] / $d[semester]</td>						
						</tr>";
						$no++;
					}
				}else{
					echo "<h2>Tidak Ada Data Ditemukan !</h2>";
				}

				?>
			</table>
		</div>
	</div>
</div>

</div>
<?php 
function CekSemester($sem)
{
	if ($sem="ganjil") {
		return "Ganjil";
	}else{
		return "Genap";
	}
}

function get_guru($nik)
{
	include "../koneksi.php";	
	$sql = mysqli_query($konek, "SELECT g.*, j.* FROM guru g JOIN jabatan j ON g.kode_jabatan = j.kode_jabatan WHERE nik=$nik");
	$e = mysqli_fetch_array($sql);	
	return $e;
}
include "footer_user.php"; 
?>
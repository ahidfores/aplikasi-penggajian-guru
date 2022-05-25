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

	function buatRp($angka){
		$rupiah = "Rp ". number_format($angka,0,',','.') . ",-";
		return $rupiah;
	}

	switch($view){
		case "tambah":
		?>
		<?php
		if(isset($_GET['e']) && $_GET['e']=='bl'){
			?>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Peringatan!</strong>Form Anda Belum Lengkap, Silahkan Dilengkapi!
					</div>
				</div>
			</div>
			<?php
		}
		?> 

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						Input Potongan Baru
					</h3>
				</div>

				<div class="panel-body">

					<form method="post" action="aksi_potongan.php?f=insert">
						<table class="table">
							<tr>
								<td>Nama Guru</td>
								<td>
									<select name="nik" class="form-control">
										<option value="">- Pilih Guru / Karyawan -</option>
										<?php
										$sql=mysqli_query($konek, "SELECT * FROM guru ORDER BY nik ASC");
										while($g=mysqli_fetch_array($sql)){
											echo "<option value='$g[nik]'>- $g[nama_guru]</option>";
										} 
										?>
									</select> 
								</td>
							</tr>

							<tr>
								<td>Keperluan</td>
								<td>
									<textarea name="keperluan" rows="3" placeholder="Keperluan pinjaman..." class="form-control"></textarea>
								</td>
							</tr>

							<tr>
								<td>Jumlah Pinjaman (Rp.)</td>
								<td>
									<input type="number" name="jumlah_potongan" class="form-control" placeholder="Rp...">
								</td>
							</tr> 		
							<tr>
								<td>Tanggal</td>
								<td>
									<input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
								</td>
							</tr> 
							<tr>
								<td></td>
								<td align="right">
									<input type="submit" class="btn btn-primary" value="simpan">
									<a class="btn btn-danger" href="data_penggajian.php">Kembali</a>
								</td>
							</tr>		      
						</table>
					</form>


				</div>
			</div>
		</div>
		<?php
		break;
		default:
		$this_guru = get_guru($_GET['nik']);

		?>
		<!-- menampilkan pesan -->		

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Detail Data Potongan Gaji</h3>
				</div>				
				<div class="alert alert-info">
					Data Potongan Guru <strong><?php echo $this_guru['nama_guru'];?></strong> Bulan : <strong><?php echo $bulan; ?></strong>, Tahun : <strong><?php echo $tahun; ?></strong>
				</div> 

				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Tanggal</th>
								<th>Keperluan</th>
								<th>Jumlah (Rp.) </th>
							</tr>
						</thead>
						<tbody>
							<?php						
							$q = "SELECT * FROM potongan WHERE nik='$this_guru[nik]' AND tanggal LIKE '%$tahun_bulan%'";
							$sql = mysqli_query($konek, $q);
							$no=1;
							if (mysqli_num_rows($sql) > 0) {
								while($d=mysqli_fetch_array($sql)){									
									echo"<tr>
									<td width='40px' align='center'>$no</td>
									<td>$d[tanggal]</td>
									<td>$d[keperluan]</td>
									<td>".buatRp($d['jumlah_potongan'])."</td>";
									?>
									<?php
									echo "</tr>";
									$no++;
								}
							}else{
								echo "<h3 align='center'> Tidak Ditemukan Data ! </h3>";
							}

							?>
							<tr>
								<td colspan="3"></td>								
								<td align="right">
									<a href="cetak_slip_potongan.php?nik=<?php echo $this_guru['nik'];?>&tahun=<?php echo $tahun;?>&bulan=<?php echo $bulan;?>" class="btn btn-success" target="_blank">Cetak Potongan</a>
									<a class="btn btn-danger" href="data_penggajian.php">Kembali</a>
								</td>
							</tr>	
						</tbody>						
					</table>
				</div>
			</div>
		</div>

		<?php

		break;

	}
	?>

</div> 
<?php 
function get_guru($nik)
{
	include "koneksi.php";	
	$sql = mysqli_query($konek, "SELECT * FROM guru WHERE nik=$nik");
	$e = mysqli_fetch_array($sql);	
	return $e;
}
include "footer.php"; 
?>
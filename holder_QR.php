<?php include 'header.php'; ?>
<div class="container">

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					Scan QR Ini Untuk Absensi
				</h3>
			</div>
			<div class="alert alert-info">  
				<?php
				echo date('l, d-m-Y');
				?>
			</div>   
			<!-- Holder IMAGE nya -->
			<div align="center">
				<h4><?= $_GET['nik'] . " - ". $_GET['nama'];?> </h4>
				<img src="<?= $_GET['src'];?>"/><br>
				<a href="absen.php" class="btn btn-info"> Kembali ke Absensi </a>
				<br>
				<br>
			</div>
		</div>
	</div>
</div>




</div>
</div>
</div>

</div>
<?php include "footer.php"; ?>


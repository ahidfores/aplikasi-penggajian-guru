<?php include "header.php"; ?>
<div class="container">

<?php
$view = isset($_GET['view']) ? $_GET['view'] : null;

switch($view){
	default:
	?>
        <!-- menampilkan pesan -->
        <?php
        if(isset($_GET['e']) && $_GET['e']=='sukses'){
        ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
           		<div class="alert alert-success alert-dismissible" role="alert">
           			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				    <strong>Selamat!</strong>Proses Berhasil!
				</div>
           	</div>
        </div>
        <?php
        }elseif(isset($_GET['e']) && $_GET['e']=='gagal'){
        ?>
        <div class="row">
           	<div class="col-md-8 col-md-offset-2">
           		<div class="alert alert-danger alert-dismissible" role="alert">
           			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong>Proses gagal dilakukan.
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
						Data Mapel
					</h3>
				</div>

				<div class="panel-body">
					<a href="data_mapel.php?view=tambah" style="margin-bottom: 10px" class="btn btn-primary">Tambah Data</a>
					<table class="table table-bordered table-striped">
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th>Nama Mapel</th>
							<th>Aksi</th>
						</tr>
						<?php
                        $sql = mysqli_query($konek, "SELECT * FROM mapel ORDER BY kode_pengajar ASC");
                        $no=1;

                        while($d=mysqli_fetch_array($sql)){
                        	echo "<tr>
                                <td width='40px' align='center'>$no</td>
                                <td>$d[kode_pengajar]</td>
                                <td>$d[nama_mapel]</td>
                                <td width='160px' align='center'>
                                    <a class='btn btn-warning btn-sm' href='data_mapel.php?view=edit&id=$d[kode_pengajar]'>Edit</a>
                                    <a class='btn btn-danger btn-sm' href='aksi_mapel.php?act=del&id=$d[kode_pengajar]'>Hapus</a>
                                </td>
                        	</tr>";
                        	$no++;
                        }
						?>
					</table>
				</div>
        <?php
          if (mysqli_num_rows($sql) > 0){
            echo "
            <center>
              <a class='btn btn-success' href='cetak_laporan_mapel.php' target='_blank'><span class='glypicon glypicon-print'></span>Cetak Data Mata Pelajaran</a>           
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
		case "tambah":
		    //membuat kode jabatan otomatis
		    $simbol = "KP";
		    $query  = mysqli_query($konek, "SELECT max(kode_pengajar) AS last FROM mapel WHERE kode_pengajar LIKE '$simbol%'");
		    $data   = mysqli_fetch_array($query);

		    $kodeterakhir = $data['last'];
		    $nomorterakhir = substr($kodeterakhir, 2,3);
		    $nextNomor = $nomorterakhir + 1;
		    $nextkode  = $simbol.sprintf('%02s',$nextNomor);
		    
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
						Tambah Data Mapel
					</h3>
				</div>

				<div class="panel-body">
				    
                   <form method="post" action="aksi_mapel.php?act=insert">
                   	    <table class="table">
                   		   <tr>
                   			<td width="160px">Kode</td>
                   			<td>
                   				<input class="form-control" type="text" name="kodepengajar" value="<?php echo $nextkode; ?>" readonly>
                   			</td>
                   		</tr>
                   		<tr>
                   			<td>Nama Mapel</td>
                   			<td>
                   				<input class="form-control" type="text" name="namamapel" required>
                   			</td>
                   		</tr>
                      <tr>
                   			<td></td>
                   			<td>
                   				<input type="submit" class="btn btn-primary" value="simpan">
                   				<a class="btn btn-danger" href="data_mapel.php">Kembali</a>
                   			</td>
                   		</tr>
                   	</table>
                </form>

			</div>	
		</div>
	</div>

<?php
break;
case "edit":
    //kode
    $sqlEdit = mysqli_query($konek, "SELECT * FROM mapel WHERE kode_pengajar='$_GET[id]'");
    $e = mysqli_fetch_array($sqlEdit);
?>

<div class="row">
   <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Data Mapel</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="aksi_mapel.php?act=update">
            	<table class="table">
            		<tr>
            		    <td width="160">Kode Pengajar</td>
            			<td>
            			    <input type="text" name="kodepengajar" class="form-control" value="<?php echo $e['kode_pengajar']; ?>" readonly />
            			</td>
            		</tr>
            		<tr>
            			<td>Nama Mapel</td>
            			<td>
            				<input type="text" name="namamapel" class="form-control" value="<?php echo $e['nama_mapel']; ?>" required />
            			</td>
            		</tr>
            		<tr>
            			<td></td>
            			<td>
            				<input type="submit" value="Update Data" class="btn btn-primary"/>
            				<a href="data_mapel.php" class="btn btn-danger">Kembali</a>
            			</td>
            		</tr>
            	</table>        				
            </form>    
        </div>
    </div>
    </div>

<?php
break;
}
?>

</div>
<?php include "footer.php"; ?>
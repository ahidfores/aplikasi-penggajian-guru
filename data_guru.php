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
						Data Guru
					</h3>
				</div>
         
				<div class="panel-body">
					<a href="data_guru.php?view=tambah" style="margin-bottom: 10px" class="btn btn-primary">Tambah Data</a>
					<table class="table table-bordered table-striped">
						<tr>
							<th>No</th>
							<th>NIK</th>
							<th>Nama Guru</th>
							<th>Nama Jabatan</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
						<?php
                        $sql = mysqli_query($konek, "SELECT guru.*,jabatan.nama_jabatan FROM guru 
									                        	INNER JOIN jabatan ON guru.kode_jabatan=jabatan.kode_jabatan 
									                        	ORDER BY guru.nama_guru ASC");
	                    $no=1;

                        while($d=mysqli_fetch_array($sql)){
                        	echo "<tr>
                                <td width='40px' align='center'>$no</td>
                                <td>$d[nik]</td>
                                <td>$d[nama_guru]</td>
                                <td>$d[nama_jabatan]</td>
                                <td>$d[status]</td>
                                <td width='160px' align='center'>
                                    <a class='btn btn-warning btn-sm' href='data_guru.php?view=edit&id=$d[nik]'>Edit</a>
                                    <a class='btn btn-danger btn-sm' href='aksi_guru.php?act=del&id=$d[nik]'>Hapus</a>
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
              <a class='btn btn-success' href='cetak_laporan_guru.php' target='_blank'><span class='glypicon glypicon-print'></span>Cetak Data Guru</a>           
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
						Tambah Data Guru
					</h3>
				</div>

				<div class="panel-body">
				    
                   <form method="post" action="aksi_guru.php?act=insert">
                   	    <table class="table">
                   		<tr>
                   			<td width="160px">NIK</td>
                   			<td>
                   				<input class="form-control" type="text" name="nik" required>
                   			</td>
                   		</tr>
                   		<tr>
                   			<td>Nama Guru</td>
                   			<td>
                   				<input class="form-control" type="text" name="namaguru" required>
                   			</td>
                   		</tr>
                   		<tr>
                   			<td>Nama Jabatan</td>
                   			<td>
                   			    <select name="jabatan" class="form-control">
                   					<option value="">- pilih -</option>
                   					<?php
                   					$sqlJabatan=mysqli_query($konek, "SELECT * FROM jabatan ORDER BY kode_jabatan ASC");
                   					while($j=mysqli_fetch_array($sqlJabatan)){
                   						echo "<option value='$j[kode_jabatan]'>$j[kode_jabatan] - $j[nama_jabatan]</option>";
                   					} 
                   					?>
                   				</select>	
                   			</td>
                   		</tr>
                   		<tr>
                   			<td>Status</td>
                   			<td>
                   				<select name="status" id="status" class="form-control" onChange="autoAnak()">
                   					<option value="">- Pilih -</option>
                   					<option value="Menikah">Menikah</option>
                   					<option value="Belum Menikah">Belum Menikah</option>
                   				</select>
                   			</td>
                   		</tr> 
                   		<!-- <tr>
                   			<td>Jumlah Anak</td>
                   			<td>
                   				<input type="number" id="jumlahanak" name="jumlahanak" class="form-control">
                   			</td>
                   		</tr>    -->              		
                   		<tr>
                   			<td></td>
                   			<td>
                   				<input type="submit" class="btn btn-primary" value="simpan">
                   				<a class="btn btn-danger" href="data_guru.php">Kembali</a>
                   			</td>
                   		</tr>
                   	</table>
                </form>
                  
                 <!--  <script type="text/javascript">
                  	function autoAnak(){
                  		var status = $('@status').val();
                  		if(status=='Belum Menikah'){
                  			$('@jumlahanak').val('0');
                  			$('@jumlahanak').prop('readonly',true);
                  		}else{
                  			$('@jumlahanak').val('');
                  			$('@jumlahanak').prop('readonly', false);
                  		}
                  	}
                  </script> -->


			</div>	
		</div>
	</div>

<?php
break;
case "edit":
    //kode
    $sqlEdit = mysqli_query($konek, "SELECT * FROM guru WHERE nik='$_GET[id]'");
    $e = mysqli_fetch_array($sqlEdit);
?>

<div class="row">
   <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Data Guru</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="aksi_guru.php?act=update">
            	<table class="table">
            		<tr>
                   		<td width="160px">NIK</td>
                   		<td>
                   			<input class="form-control" type="text" name="nik" value="<?php echo $e['nik']; ?>" readonly>
                   		</td>
                   	</tr>
                   	<tr>
                   		<td>Nama Guru</td>
                   		<td>
                   			<input class="form-control" type="text" name="namaguru" value="<?php echo $e['nama_guru']; ?>" required>
                   		</td>
                   	</tr>
                   	<tr>
                   		<td>Nama Jabatan</td>
                   		<td>
                   			<select name="jabatan" class="form-control">
                   			<option value="">- pilih -</option>
                   			<?php
                   			$sqlJabatan=mysqli_query($konek, "SELECT * FROM jabatan ORDER BY kode_jabatan ASC");
                   			while($j=mysqli_fetch_array($sqlJabatan)){

                   			 $selected = ($j['kode_jabatan'] == $e['kode_jabatan']) ? 'selected="selected"' : "";

                   			echo "<option value='$j[kode_jabatan]' $selected>$j[kode_jabatan] - $j[nama_jabatan]</option>";
                   			} 
                   			?>
                   		    </select>	
                   		</td>
                   	</tr>
                   	<tr>
                   		<td>Status</td>
                   		<td>
                   		    <select name="status" class="form-control">
                   			<option value="<?php echo $e['status']; ?>" selected><?php echo $e['status']; ?></option>
                   			<option value="Menikah">Menikah</option>
                   			<option value="Belum Menikah">Belum Menikah</option>
                   		    </select>
                   		</td>
                   	</tr> 
            		<tr>
            			<td></td>
            			<td>
            				<input type="submit" value="Update Data" class="btn btn-primary"/>
            				<a href="data_guru.php" class="btn btn-danger">Kembali</a>
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
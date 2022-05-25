<?php include "header.php"; ?>
<div class="container">

  <?php
  $view = isset($_GET['view']) ? $_GET['view'] : null;
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

  switch($view){
   default:
   ?>
   <!-- menampilkan pesan -->
   <?php
   if(isset($_GET['e']) && $_GET['e']=='sukses'){
    ?>
    <div class="row">
      <div class="col-md-12">
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
    Jadwal Mengajar
  </h3>
</div>

<div class="panel-body">
  <form action="jadwal.php" method="get" class="form-inline">
    <div class="row">
      <div class="col-lg-9">
        <div class="form-group">
          <label>Cari </label>
          <input type="text" name="cari" class="form-control" placeholder="Nama guru...">
        </div>
        <div class="form-group">
          <label>Tahun Pelajaran </label>
          <select name="tahun" class="form-control">
            <option value="">- Pilih -</option>
            <?php
            $y = date('Y');
            for ($i=2020;$i<=$y+2;$i++){
              if ($i == $y) {
                echo "<option value='$i-".($i+1)."' selected>$i - ".($i+1)."</option>";
              }else{
                echo "<option value=''$i-".($i+1)."'>$i - ".($i+1)."</option>";
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
      <div class="col-lg-3" align="right">
        <a href="jadwal.php?view=tambah" style="margin-bottom: 10px" class="btn btn-primary">Tambah Data</a>
      </div>
    </div>
  </form>
  <?php
  if(isset($_GET['cari']) && $_GET['cari'] != ''){
    $cari = $_GET['cari'];
    echo "<b>Hasil pencarian : ".$cari."</b>";
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
      <th>Perode Tahun Ajaran / Semester</th>
      <th>Aksi</th>
    </tr>

    <?php
    if(isset($_GET['cari'])){
      $cari = $_GET['cari'];
      $tahun_ajar = $_GET['tahun'];
      $semester = $_GET['semester'];
      $q = "SELECT jadwal.*, guru.nama_guru,mapel.nama_mapel FROM jadwal 
      INNER JOIN guru ON jadwal.nik=guru.nik
      INNER JOIN mapel ON jadwal.kode_pengajar=mapel.kode_pengajar 
      WHERE nama_guru like '%".$cari."%' AND tahun_ajar='$tahun_ajar' AND semester='$semester'";
      $sql = mysqli_query($konek, $q);
    }else {
      $sql = mysqli_query($konek, "SELECT jadwal.*, guru.nama_guru,mapel.nama_mapel FROM jadwal 
        INNER JOIN guru ON jadwal.nik=guru.nik
        INNER JOIN mapel ON jadwal.kode_pengajar=mapel.kode_pengajar 
        ORDER BY guru.nama_guru ASC");
    }
    $no=1;

    while($d=mysqli_fetch_array($sql)){
      echo "<tr>
      <td width='40px' align='center'>$no</td>
      <td width='200px'>$d[nama_guru]</td>
      <td>$d[nama_mapel]</td>
      <td>$d[hari]</td>
      <td>$d[jam_mulai]</td>
      <td>$d[jam_berakhir]</td>
      <td>$d[bulan_mulai] s/d $d[bulan_berakhir] $d[tahun_ajar] / $d[semester]</td>
      <td width='160px' align='center'>
        <a class='btn btn-warning btn-sm' href='jadwal.php?view=edit&id=$d[id]&nik=$d[nik]'>Edit</a>
        <a class='btn btn-danger btn-sm' href='aksi_jadwal.php?act=del&id=$d[id]'>Hapus</a>
      </td>
    </tr>";
    $no++;
  }
  ?>
</table>
</div>
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
    <div class="col-md-12">
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Peringatan!</strong>Form Anda belum lengkap atau ada data yang kurang tepat. Silahkan dilengkapi dan diperbaiki! 
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
        Input Jadwal
      </h3>
    </div>

    <div class="panel-body">

     <form method="post" action="aksi_jadwal.php?act=insert">
      <table class="table">
       <tr>
        <td width="250px">Nama Guru</td>
        <td colspan="2">
          <select name="nik" class="form-control">
            <option value="">- pilih -</option>
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
        <td>Nama Mapel</td>
        <td colspan="2">
          <select name="nama_mapel" class="form-control">
            <option value="">- pilih -</option>
            <?php
            $sql=mysqli_query($konek, "SELECT * FROM mapel ORDER BY kode_pengajar ASC");
            while($m=mysqli_fetch_array($sql)){
              echo "<option value='$m[kode_pengajar]'>- $m[nama_mapel]</option>";
            } 
            ?>
          </select> 
        </td>
      </tr>

      <tr>
        <td>
          Tahun Ajaran / Semester
        </td>
        <td>
          <select name="tahun" class="form-control">
            <option value="">- Pilih -</option>
            <?php
            $y = date('Y');
            for ($i=2021;$i<=$y+2;$i++){
              if ($i == $y) {
                echo "<option value='$i-".($i+1)."' selected>$i - ".($i+1)."</option>";
              }else{
                echo "<option value=''$i-".($i+1)."'>$i - ".($i+1)."</option>";
              }
            }
            ?>
          </select>
        </td>
        <td>
          <select name="semester" class="form-control">
            <option value="ganjil">Ganjil</option>
            <option value="genap">Genap</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          Berlaku Untuk Bulan
        </td>
        <td>
          <select name="bulan_mulai" class="form-control">
            <option value="">- Pilih -</option>            
            <option value="Januari">Januari</option>
            <option value="Februari">Februari</option>
            <option value="Maret">Maret</option>
            <option value="April">April</option>
            <option value="Mei">Mei</option>
            <option value="Juni">Juni</option>
            <option value="Juli">Juli</option>
            <option value="Agustus">Agustus</option>
            <option value="September">September</option>
            <option value="Oktober">Oktober</option>
            <option value="November">November</option>
            <option value="Desember">Desember</option>
          </select>
        </td>
        <td>
          <select name="bulan_berakhir" class="form-control">
            <option value="">- Pilih -</option>            
            <option value="Januari">Januari</option>
            <option value="Februari">Februari</option>
            <option value="Maret">Maret</option>
            <option value="April">April</option>
            <option value="Mei">Mei</option>
            <option value="Juni">Juni</option>
            <option value="Juli">Juli</option>
            <option value="Agustus">Agustus</option>
            <option value="September">September</option>
            <option value="Oktober">Oktober</option>
            <option value="November">November</option>
            <option value="Desember">Desember</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>Hari</td>
        <td colspan="2">
          <select name="hari" id="hari" class="form-control" onChange="autoAnak()">
            <option value="">- Pilih -</option>
            <option value="Senin">- Senin</option>
            <option value="Selasa">- Selasa</option>
            <option value="Rabu">- Rabu</option>
            <option value="Kamis">- Kamis</option>
            <option value="Jumat">- Jumat</option>
            <option value="Sabtu">- Sabtu</option>
            <option value="Minggu">- Minggu</option>
          </select>
        </td>
      </tr> 

      <tr>
        <td>Jam Mulai</td>
        <td colspan="2">
          <input class="form-control" type="time" name="jam_mulai" required>    
        </td>
      </tr>
      <tr>
        <td>Jam Berakhir</td>
        <td colspan="2">
          <input class="form-control" type="time" name="jam_berakhir" required="">    
        </td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2" align="right">
          <input type="submit" class="btn btn-primary" value="simpan">
          <a class="btn btn-danger" href="jadwal.php">Kembali</a>
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
$sqlEdit = mysqli_query($konek, "SELECT * FROM jadwal WHERE id='$_GET[id]'");
$e = mysqli_fetch_array($sqlEdit);
?>
<?php
if(isset($_GET['e']) && $_GET['e']=='bl'){
  ?>
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Peringatan!</strong>Form anda belum lengkap atau ada data yang kurang tepat! Silahkan diperbaiki!
      </div>
    </div>
  </div>
  <?php
}
?> 

<div class="row">
 <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Data Jadwal</h3>
  </div>
  <div class="panel-body">
    <form method="post" action="aksi_jadwal.php?act=update">
      <input type="hidden" value="<?php echo $_GET['id'];?>" name="id">
      <table class="table">
        <tr>
          <td width="250px">NIK</td>
          <td colspan="2">
            <select name="nik" class="form-control">
              <option value="">- pilih -</option>
              <?php
              $sql=mysqli_query($konek, "SELECT * FROM guru ORDER BY nik ASC");
              while($g=mysqli_fetch_array($sql)){
                $selected = ($g['nik'] == $e['nik']) ? "selected" : "";
                echo "<option value='$g[nik]' $selected>$g[nik] - $g[nama_guru]</option>";
              } 
              ?>
            </select> 
          </td>
        </tr>
        <tr>
          <td width="250px">Nama Mapel</td>
          <td colspan="2">
           <select name="nama_mapel" class="form-control">
            <option value="">- pilih -</option>
            <?php
            $sql=mysqli_query($konek, "SELECT * FROM mapel ORDER BY kode_pengajar ASC");
            while($m=mysqli_fetch_array($sql)){
             $selected = ($m['kode_pengajar'] == $e['kode_pengajar']) ? 'selected="selected"' : "";
             echo "<option value='$m[kode_pengajar]' $selected>- $m[nama_mapel]</option>";
           } 
           ?>
         </select> 
       </td>
     </tr>
     <tr>
      <td width="250px">
        Tahun Ajaran / Semester
      </td>
      <td>
        <select name="tahun" class="form-control">
          <option value="">- Pilih -</option>
          <?php
          $y = date('Y');
          for ($i=2021;$i<=$y+2;$i++){            
            if ("$i-".($i+1) == $e['tahun_ajar']) {
              echo "<option value='$i-".($i+1)."' selected>$i - ".($i+1)."</option>";
            }else{
              echo "<option value='$i-".($i+1)."'>$i - ".($i+1)."</option>";
            }
          }
          ?>
        </select>
      </td>
      <td>
        <select name="semester" class="form-control">
          <option value="">- Pilih -</option>
          <option value="ganjil" <?php echo $e['semester']=="ganjil"?"selected" : "";?>>Ganjil</option>
          <option value="genap" <?php echo $e['semester']=="genap"?"selected" : "";?>>Genap</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Berlaku Untuk Bulan
      </td>
      <td>
        <select name="bulan_mulai" class="form-control">
          <option value="">- Pilih -</option>            
          <option value="Januari" <?php echo $e['bulan_mulai'] == "Januari" ? "selected" : ""; ?>>Januari</option>
          <option value="Februari" <?php echo $e['bulan_mulai'] == "Februari" ? "selected" : ""; ?>>Februari</option>
          <option value="Maret" <?php echo $e['bulan_mulai'] == "Maret" ? "selected" : ""; ?>>Maret</option>
          <option value="April" <?php echo $e['bulan_mulai'] == "April" ? "selected" : ""; ?>>April</option>
          <option value="Mei" <?php echo $e['bulan_mulai'] == "Mei" ? "selected" : ""; ?>>Mei</option>
          <option value="Juni" <?php echo $e['bulan_mulai'] == "Juni" ? "selected" : ""; ?>>Juni</option>
          <option value="Juli" <?php echo $e['bulan_mulai'] == "Juli" ? "selected" : ""; ?>>Juli</option>
          <option value="Agustus" <?php echo $e['bulan_mulai'] == "Agustus" ? "selected" : ""; ?>>Agustus</option>
          <option value="September" <?php echo $e['bulan_mulai'] == "September" ? "selected" : ""; ?>>September</option>
          <option value="Oktober" <?php echo $e['bulan_mulai'] == "Oktober" ? "selected" : ""; ?>>Oktober</option>
          <option value="November" <?php echo $e['bulan_mulai'] == "November" ? "selected" : ""; ?>>November</option>
          <option value="Desember" <?php echo $e['bulan_mulai'] == "Desember" ? "selected" : ""; ?>>Desember</option>
        </select>
      </td>
      <td>
        <select name="bulan_berakhir" class="form-control">
          <option value="">- Pilih -</option>            
          <option value="Januari" <?php echo $e['bulan_berakhir'] == "Januari" ? "selected" : ""; ?>>Januari</option>
          <option value="Februari" <?php echo $e['bulan_berakhir'] == "Februari" ? "selected" : ""; ?>>Februari</option>
          <option value="Maret" <?php echo $e['bulan_berakhir'] == "Maret" ? "selected" : ""; ?>>Maret</option>
          <option value="April" <?php echo $e['bulan_berakhir'] == "April" ? "selected" : ""; ?>>April</option>
          <option value="Mei" <?php echo $e['bulan_berakhir'] == "Mei" ? "selected" : ""; ?>>Mei</option>
          <option value="Juni" <?php echo $e['bulan_berakhir'] == "Juni" ? "selected" : ""; ?>>Juni</option>
          <option value="Juli" <?php echo $e['bulan_berakhir'] == "Juli" ? "selected" : ""; ?>>Juli</option>
          <option value="Agustus" <?php echo $e['bulan_berakhir'] == "Agustus" ? "selected" : ""; ?>>Agustus</option>
          <option value="September" <?php echo $e['bulan_berakhir'] == "September" ? "selected" : ""; ?>>September</option>
          <option value="Oktober" <?php echo $e['bulan_berakhir'] == "Oktober" ? "selected" : ""; ?>>Oktober</option>
          <option value="November" <?php echo $e['bulan_berakhir'] == "November" ? "selected" : ""; ?>>November</option>
          <option value="Desember" <?php echo $e['bulan_berakhir'] == "Desember" ? "selected" : ""; ?>>Desember</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="250px">Hari</td>
      <td colspan="2">
       <select name="hari" class="form-control">
         <option value="">- pilih - </option>
         <option value="Senin" <?php echo $e['hari'] == "Senin" ? "selected" : ""; ?>>- Senin</option>
         <option value="Selasa" <?php echo $e['hari'] == "Selasa" ? "selected" : ""; ?>>- Selasa</option>
         <option value="Rabu" <?php echo $e['hari'] == "Rabu" ? "selected" : ""; ?>>- Rabu</option>
         <option value="Kamis" <?php echo $e['hari'] == "Kamis" ? "selected" : ""; ?>>- Kamis</option>
         <option value="Jumat" <?php echo $e['hari'] == "Jumat" ? "selected" : ""; ?>>- Jumat</option>
         <option value="Sabtu" <?php echo $e['hari'] == "Sabtu" ? "selected" : ""; ?>>- Sabtu</option>
         <option value="Minggu" <?php echo $e['hari'] == "Minggu" ? "selected" : ""; ?>>- Minggu</option>
       </select>
     </td>
   </tr>
   <tr>
    <td width="250px">Jam mulai</td>
    <td colspan="2">
      <input class="form-control" type="time" name="jam_mulai" value="<?php echo $e['jam_mulai']; ?>" required>
    </td>
  </tr> 
  <tr>
    <td width="250px">Jam Berakhir</td>
    <td colspan="2">
      <input class="form-control" type="time" name="jam_berakhir" value="<?php echo $e['jam_berakhir']; ?>" required>
    </td>
  </tr> 
  <tr>
    <td></td>
    <td colspan="2" align="right">
      <input type="submit" value="Update Data" class="btn btn-primary"/>
      <a href="jadwal.php" class="btn btn-danger">Kembali</a>
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
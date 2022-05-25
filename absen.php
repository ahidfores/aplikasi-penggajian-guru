<?php 
include "header.php"; 
date_default_timezone_set("Asia/Jakarta");
?>
<div class="container">

  <?php
  $view = isset($_GET['view']) ? $_GET['view'] : null;

  switch($view){
    case 'pilih_status_hadir':
    $nik = $_GET['nik'];
    $sql_cek = "SELECT * FROM guru WHERE nik='$nik'";
    $thisGuru = mysqli_query($konek, $sql_cek);
    $e = mysqli_fetch_array($thisGuru);    
    ?>
    <!--Ini Buat Pemilihan Status Kehadiran
    <a class='btn btn-danger btn-sm' name='simpan' href='aksi_absen.php?nik=$d[nik]&nomor=$e[nama_guru]'>Absen</a><br>
  -->  

  <!-- PENGECEKAN APAKAH STATUS SUDAH DIISI -->
  <?php
  if(isset($_GET['e']) && $_GET['e']=='status_error'){
    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Peringatan!</strong>Status kehadiran belum dipilih, Silahkan Dilengkapi!
        </div>
      </div>
    </div>
    <?php
  }
  ?>
  <!--  -->
  <div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">
          Status Absensi Guru
        </h3>
      </div>

      <div class="panel-body">

       <form method="get" action="aksi_absen.php">
         <input type="hidden" name="f" value="generate_qr">
         <input type="hidden" name="nomor" value="<?=$e['nama_guru'];?>">
         <table class="table">
          <tr>
            <td width="160px">NIK</td>
            <td colspan="2">
              <input class="form-control" type="text" name="nik" readonly value="<?php echo $e['nik'];?>">
            </td>
          </tr>
          <tr>
            <td>Nama Guru</td>
            <td colspan="2">
              <input class="form-control" type="text" name="nama_guru" readonly value="<?php echo $e['nama_guru'];?>" required>
            </td>
          </tr>
          <tr>
            <td>Waktu Absensi</td>
            <td colspan="2">
              <input class="form-control" type="time" name="waktu_absen" value="<?php echo date('H:i:s');?>" required>
            </td>
          </tr>                      
          <tr>
            <td>Status Kehadiran</td>
            <td colspan="2">
              <select name="status" id="status" class="form-control">
                <option value="">- Pilih -</option>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Alpa">Alpa</option>
              </select>
            </td>
          </tr>                    
          <tr>
            <td></td>
            <td colspan="2" align="right">
              <?php
              $y = date('Y');
              $m = date('m');
              ?>
              <input class="form-control" type="hidden" name="tahun" readonly value="<?php echo $y."-".($y+1);?>">                            
              <input class="form-control" type="hidden" name="semester" readonly value="<?= (int)$m > 6 ? "ganjil" : "genap" ;?>">               
              <input type="submit" class="btn btn-primary" value="simpan">
              <a class="btn btn-danger" href="absen.php">Kembali</a>
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
            default:
            ?>
            <!-- menampilkan pesan -->
            <!-- PENGECEKAN APAKAH STATUS ABSEN ADALAH IZIN atau ALPA-->
            <?php
            if(isset($_GET['message'])){
              ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-info alert-dismissible" role="alert">
                    <?php
                    if(isset($_GET['e']) && $_GET['e'] == "gagal"){
                      ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Status Izin <strong>GAGAL</strong> diberikan!</strong>
                      <?php
                    }else{
                      ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Status kehadiran telah dipilih. Status kehadiran <strong><?php echo $_GET['nama_guru'];?></strong> adalah <strong><?php echo $_GET['message'];?></strong>
                      <?php
                    }
                    ?>
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
                Data Absensi
              </h3>
            </div>
            <div class="alert alert-info">  
              <?php
              echo date('l, d-m-Y');
              ?>
            </div>   
            <table class="table table-bordered table-striped">
              <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Guru</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>

              <?php
              $sql = mysqli_query($konek, "SELECT guru.nik,guru.nama_guru, absenhariini.status, absenhariini.tanggal FROM guru left JOIN 
                (SELECT * FROM absensi where tanggal LIKE CONCAT(CURDATE(), '%')) absenhariini 
                ON absenhariini.nik=guru.nik GROUP BY guru.nik
                ORDER BY guru.nama_guru ASC");
              $no=1;
                        // var_dump($sql);              
              while($d=mysqli_fetch_array($sql)){
                echo "<tr>
                <td width='40px' align='center'>$no</td>
                <td>$d[nik]</td>
                <td>$d[nama_guru]</td>";
                
                // if ($d['status'] == NULL) {
                //   echo "<td>Tidak Hadir</td>";
                // }else if($d['status'] == "Izin"){
                //   echo "<td>Izin</td>";
                // }else{
                //   echo "<td>Hadir</td>";                  
                // }
                echo "<td>";
                $this_Jadwal = CekJadwal($d['nik']);
                   // var_dump($this_Jadwal);
                if (mysqli_num_rows($this_Jadwal) > 0) {
                  echo "<b>Jadwal Hari Ini : </b><ol>";
                  foreach ($this_Jadwal as $tj) {
                    // var_dump($tj);
                    echo "<li>".$tj['jam_mulai']. " / ". isHadir($d['nik'], $tj['jam_mulai'], $tj['jam_berakhir']) ."</li>";
                  }
                  echo "</ol>";
                }else{
                  echo "Tidak Hadir";
                }
                echo "</td>";

                echo "<td width='160px' align='center'>
                <a class='btn btn-danger btn-sm' name='simpan' href='aksi_absen.php?f=status_absensi_guru&view_hadir=true&nik=$d[nik]'>Absen</a>
              </td>
            </tr>";

            $no++;
          }
          ?>
        </table>
      </div>
    </div>
  </div>




</div>
</div>
</div>

<?php
break;
}
?>

</div>
<?php 

// isHadir('3596192007980002');

function CekJadwal($nik)
{
  include 'koneksi.php';
  $query = "SELECT * FROM jadwal WHERE nik ='".$nik."' AND hari ='".get_Hari_ini()."' ORDER BY jam_mulai ASC";
  // echo $query;
  $sql = mysqli_query($konek, $query);
  $result = $sql;
  // var_dump($result);
  return $result;
}

function isHadir($nik, $jammulai, $jamberakhir)
{
  include 'koneksi.php';
  $jam_mulai = strtotime($jammulai);
  $jammulai = date('H', $jam_mulai);
  // 
  $jam_berakhir = strtotime($jamberakhir);
  $jamberakhir = date('H', $jam_berakhir);

  // echo $jammulai . " - " . $jamberakhir;
  $tanggal = date('Y-m-d');
  $query = "SELECT * FROM absensi WHERE nik ='".$nik."' AND tanggal LIKE '".$tanggal."%' AND HOUR(tanggal) BETWEEN ".$jammulai." AND ".$jamberakhir;
  // echo "<br>".$query."<br>";
  $sql = mysqli_query($konek, $query);
  $ishadir = mysqli_num_rows($sql);
  $status = "";
  if ($ishadir > 0) {
    $status = "Hadir";
  }else{
    $status = "Tidak Hadir";    
  }
  // var_dump($result); die;
  return $status;
  // return "Tidak Hadir";
}

function get_Hari_ini()
{
  $hari = date('l');    
  if ($hari == "Sunday") {
    return "Minggu";
  }else if($hari == "Monday"){
    return "Senin";
  }else if($hari == "Tuesday"){
    return "Selasa";
  }else if($hari == "Wednesday"){
    return "Rabu";
  }else if($hari == "Thursday"){
    return "Kamis";
  }else if($hari == "Friday"){
    return "Jumat";
  }else{
    return "Sabtu";
  }
}
include "footer.php"; 
?>
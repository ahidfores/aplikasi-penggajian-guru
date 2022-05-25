<?php include "header_user.php"; ?>

    <!-- Begin page content -->

    <div class="container">
     
     <div class="panel panel-primary"> 
      <div class="panel-heading">
        <h3 class="panel-title">Halaman Utama Aplikasi Penggajian Guru</h3>
      </div>
      <div class="panel-body">
        <img src="../assets/img/latar_belakang_fotoku.png" alt="Gambar" class="img-thumbnail">
      </div>
      </div>
     </div>
    </div>
<?php if (isset($_GET['e'])): ?>
  <?php if ($_GET['e'] == "sukses"): ?>
    <script type="text/javascript"> alert("Absensi diterima!");</script>
  <?php elseif($_GET['e'] == "out_of_time"): ?>
    <script type="text/javascript"> alert("Belum waktunya anda untuk absen atau anda terlambat !<br>Absen ditolak !");</script>    
  <?php 
  endif;
  endif;
?>     

   
<?php include "footer_user.php"; ?>
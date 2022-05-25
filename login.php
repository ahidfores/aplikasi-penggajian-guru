<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>LOGIN APLIKASI PENGGAJIAN GURU SMK SIROJUL ULUM</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <style>
      html{
        position: relative;
        min-height: 100%
      }
      body{
        background: url(assets/img/latar_belakang.jpg) no-repeat center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
      body > .container{
        margin-top: 60px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> LOGIN APLIKASI PENGGAJIAN GURU</h3>
          </div>
          <div class="panel-body">
            <center>
              <img src="assets/img/logoku.png" class="img-circle" alt="logo" width="150px">
            </center>
            <hr>

            <?php
            if($_SERVER["REQUEST_METHOD"]== "POST"){
              $user = $_POST["username"];
              $pass = $_POST["password"];
              $p    = md5($pass);

              if($user =="" || $pass==""){
                ?>
                <div class="alert alert-warning"><b>warning!</b> form anda belum lengkap!</div>
                <?php
              }else {
                 include "koneksi.php";
                 $sqlLogin = mysqli_query($konek,"SELECT * FROM users where username='$user' AND password='$p'");

                 $jml = mysqli_num_rows($sqlLogin);
                 $d= mysqli_fetch_array($sqlLogin);

                 if($jml > 0 and $d['role'] == 0){
                  session_start();
                  $_SESSION['login']        = TRUE;
                  $_SESSION['id']           =$d['iduser'];
                  $_SESSION['username']     =$d['username'];
                  $_SESSION['namalengkap']  =$d['namalengkap'];
                  $_SESSION['alamat']       =$d['alamat'];
                  $_SESSION['status']       =$d['status'];
                  $_SESSION['role']         =$d['role'];
                  

                  header('location:./index.php');

           
                 }
                 else if($jml > 0 and $d['role'] == 1){
                  $g = getGuruByName($d['namalengkap']);
                  session_start();
                  $_SESSION['login']        = TRUE;
                  $_SESSION['id']           =$d['iduser'];
                  $_SESSION['username']     =$d['username'];
                  $_SESSION['namalengkap']  =$d['namalengkap'];
                  $_SESSION['nik']          =$g['nik'];
                  $_SESSION['alamat']       =$d['alamat'];
                  $_SESSION['status']       =$d['status'];
                  $_SESSION['role']         =$d['role'];

                  header('location: http://localhost/apkpenggajianguru/user/halaman_user.php');
                 }
                 else{
                  ?>
                  <div class="alert alert-danger"><b>ERROR</b> Username dan Password Anda Salah!</div> 
                  <?php
                 }

               }

            }

            function getGuruByName($namalengkap)
            {
              include "koneksi.php";  
              $sql = mysqli_query($konek, "SELECT * FROM guru WHERE nama_guru='$namalengkap'");
              $e = mysqli_fetch_array($sql);  
              return $e;
            }
            ?>


            <form action="" method="post" role="form">
              <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="username"> 
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="password"> 
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="login"> 
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

<?php include "header.php"; ?>

  <!-- Begin page content -->
  <div class="container">
     
     <?php
     $view = isset($_GET['view']) ? $_GET['view'] : null;
     switch ($view) {
     default:
     //untuk pesan berhasil atau gagal proses
     if (isset($_GET['e']) && $_GET['e']=="sukses") {
       ?>
       <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Selamat!</strong> Proses Berhasil.
        </div>

       <?php
     }elseif (isset($_GET['e']) && $_GET['e']=="gagal") {
      ?>
       <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> Proses Gagal.
        </div>

       <?php
     }
 ?>
   <div class="panel panel-primary">  
      <div class="panel-heading">
        <h3 class="panel-title">Data User</h3>
      </div>
      <div class="panel-body">
        <a href="data_user.php?view=tambah" class="btn btn-primary" style="margin-bottom: 10px;">Tambah Data</a>

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Nama Lengkap</th>
              <th>Alamat</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no =1;
            $sqlAdmin = mysqli_query($konek, "SELECT * FROM users ORDER BY username ASC");
             $jml = mysqli_num_rows($sqlAdmin);
            while($data= mysqli_fetch_array($sqlAdmin))
             if($jml > 0 and $data['role'] == 0){
              echo  "<tr>
              <td class='text-center'>$no</td>
              <td>$data[username]</td>
              <td>$data[namalengkap]</td>
              <td>$data[alamat]</td>
              <td>$data[status]</td>          
              <td class='text-center'>
              <a href='data_user.php?view=edit&id=$data[iduser]' class='btn btn-warning btn-sm'>Edit</a>
              <a href='aksi_user.php?act=delete&id=$data[iduser]' class='btn btn-danger btn-sm'>Hapus</a>
              </td>
              </tr>";
              $no++;
             
            }  
            else if($jml > 0 and $data['role'] == 1){
              echo  "<tr>
              <td class='text-center'>$no</td>
              <td>$data[username]</td>
              <td>$data[namalengkap]</td>
              <td>$data[alamat]</td>
              <td>$data[status]</td>           
              <td class='text-center'>
              <a href='data_user.php?view=edit&id=$data[iduser]' class='btn btn-warning btn-sm'>Edit</a>
              <a href='aksi_user.php?act=delete&id=$data[iduser]' class='btn btn-danger btn-sm'>Hapus</a>
              </td>
              </tr>";
              $no++;
             
            }  
            ?>
          </tbody>
        </table>

      </div>
      </div>
    </div>
 <?php
     break;
     case "tambah":
     $all_guru = get_All_guru();
 ?>
   <div class="panel panel-primary"> 
      <div class="panel-heading">
        <h3 class="panel-title">Tambah Data User</h3>
      </div>
      <div class="panel-body">

        <form class="form-horizontal" method="POST" action="aksi_user.php?act=insert">
          <div class="form-group">
            <label class="col-md-2">Username</label>
            <div class="col-md-4">
              <input type="text" name="username" class="form-control" placeholder="username" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Password</label>
            <div class="col-md-4">
              <input type="password" name="password" class="form-control" placeholder="password" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Nama Lengkap</label>
            <div class="col-md-6">
              <input type="text" name="namalengkap" class="form-control" placeholder="Nama Lengkap" required> 
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Alamat</label>
            <div class="col-md-6">
              <input type="text" name="alamat" class="form-control" placeholder="alamat" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Status</label>
            <div class="col-md-6">
              <input type="text" name="status" class="form-control" placeholder="status" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Role</label>
            <div class="col-md-6">
              <input type="text" name="role" class="form-control" placeholder="role" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Username</label>
            <div class="col-md-4">
              <input type="submit" class="btn btn-primary" value="Simpan">
              <a href="data_user.php" class="btn btn-danger">Batal</a>
            </div>
          </div>
        </form>

      </div>
      </div>
    </div>

 <?php
     break;
     case "edit";

     $sqlEdit = mysqli_query($konek, "SELECT * FROM users where iduser='$_GET[id]'");
     $e = mysqli_fetch_array($sqlEdit);
  ?>
     <div class="panel panel-primary"> 
      <div class="panel-heading">
        <h3 class="panel-title">Edit Data User</h3>
      </div>
      <div class="panel-body">

        <form class="form-horizontal" method="POST" action="aksi_user.php?act=update">
          <input type="hidden" name="iduser" value="<?php echo $e['iduser']; ?>">
          <div class="form-group">
            <label class="col-md-2">Username</label>
            <div class="col-md-4">
              <input type="text" name="username" class="form-control" value="<?php echo $e['username']; ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Password</label>
            <div class="col-md-4">
              <input type="password" name="password" class="form-control" placeholder="Kosongkan Jika Tidak Diganti" >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Nama Lengkap</label>
            <div class="col-md-6">
              <input type="text" name="namalengkap" class="form-control" value="<?php echo $e['namalengkap']; ?>" required>
            </div>
          </div>

           <div class="form-group">
            <label class="col-md-2">Alamat</label>
            <div class="col-md-6">
              <input type="text" name="alamat" class="form-control" value="<?php echo $e['alamat']; ?>" required>
            </div>
          </div>

           <div class="form-group">
            <label class="col-md-2">Status</label>
            <div class="col-md-6">
              <input type="text" name="status" class="form-control" value="<?php echo $e['status']; ?>" required>
            </div>
          </div>


           <div class="form-group">
            <label class="col-md-2">Role</label>
            <div class="col-md-6">
              <input type="text" name="role" class="form-control" value="<?php echo $e['role']; ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2">Username</label>
            <div class="col-md-4">
              <input type="submit" class="btn btn-primary" value="Update Data">
              <a href="data_user.php" class="btn btn-danger">Batal</a>
            </div>
          </div>
      </div>
      </div>
    </div>
<?php
     break;
  }
  ?>
    
<?php 

  function get_All_guru()
  {
    include "koneksi.php";  
    $sql = mysqli_query($konek, "SELECT * FROM guru");
    $e = mysqli_fetch_array($sql);  
    return $e;
  }
include "footer.php"; 
?>
<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['login'])){
	header('location:login.php');
}

//jika ada get act
if (isset($_GET['act'])){

	//jika act = inset
	if($_GET['act']=='insert'){
		//simpan inputan form ke variabel
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$namalengkap = $_POST['namalengkap'];
		$alamat = $_POST['alamat'];
		$status = $_POST['status'];
		$role = $_POST['role'];

		//apabila form belum lengkap
		if($username=='' || $_POST['password']=='' || $namalengkap=='' || $alamat=='' || $status=='' || $role==''){
			//header('location:data_admin.php?view=tambah&e=bl');
			echo "Form anda Belum Lengkap...!";
		}else{
			//proses simpan data
			$simpan = mysqli_query($konek,"INSERT INTO users(username,password,namalengkap,alamat,status,role)VALUES('$username','$password','$namalengkap','$alamat','$status','$role')");
			if ($simpan) {
				header('location:data_user.php?e=sukses');
			}else{
			    header('location:data_user.php?e=gagal');	
			}
		}
	
    }elseif ($_GET['act']=='update') {  //jika act = update
	   $iduser  = $_POST['iduser'];
	   $username = $_POST['username'];
       $password = md5($_POST['password']);
       $namalengkap = $_POST['namalengkap'];
       $alamat = $_POST['alamat'];
       $status = $_POST['status'];
       $role = $_POST['role'];

        //apabila form belum lengkap
		if($username=='' ||  $namalengkap=='' ||  $alamat=='' ||  $status=='' ||  $role==''){
			//header('location:data_admin.php?view=tambah&e=bl');
			echo "Form anda Belum Lengkap...!";
		}else{

			if($_POST['password']==''){
				$update  = mysqli_query($konek, "UPDATE users SET username='$username',
					                                             namalengkap='$namalengkap',
					                                             alamat='$alamat',
					                                             status='$status',
					                                             role='$role'
					                                             WHERE iduser='$iduser'");

			}else{
                $update  = mysqli_query($konek, "UPDATE users SET username='$username',
                	                                             password='$password',
					                                             namalengkap='$namalengkap',
					                                             alamat='$alamat',
					                                             status='$status',
					                                             role='$role'
					                                             WHERE iduser='$iduser'");
			}

			if ($update){
				header('location:data_user.php?e=sukses');
			}else{
			    header('location:data_user.php?e=gagal');
			}

		}

  }elseif($_GET['act']=='delete'){ //jika act = delete
	     $hapus = mysqli_query($konek, "DELETE FROM users WHERE iduser='$_GET[id]' AND iduser!='1'");

	     if($hapus) {
		   header('location:data_user.php?e=sukses');
	     }else{
		   header('location:data_user.php?e=gagal');
		}

   }else{ //jika act bukan insert, update atau delete
   	header('location:data_user.php');
   }

}else{ //jika tidak ada get act
	header('location:data_user.php');
 }
?>
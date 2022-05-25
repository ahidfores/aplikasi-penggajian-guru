<?php
include "koneksi.php";

$select_guru =mysqli_query($konek, "SELECT * FROM guru WHERE nik= '$_POST[nik]'");

$d=mysqli_fetch_array($select_guru);
if(mysqli_num_rows($select_guru) < 1){
	echo "Data tidak ada";
}else{
	$nik = $d['nik'];
	$nama = $d['nama_guru'];
	$status = "masuk";
	$tgl = $d['tanggal'];
	$jm = $d['jam_mengajar'];

	$simpan = mysqli_query($konek, "INSERT INTO absensi(id,nik,nama_guru,status,tanggal,jam_mengajar) 
							VALUES (id, '$nik','$nama','$status','$tgl','jm')");

	if($simpan){
		$select_absen =mysqli_query($konek, "SELECT * FROM absensi");
		$e =mysqli_fetch_array($select_absen);
		if(mysqli_num_rows($select_absen) < 1){
			echo "Data tidak ada";
		}else{
			$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

			$mulai = strtotime('20:00');
			$akhir = strtotime('21:00');
			$sekarang = $date->format('H:i:s');
			$selisih = ($akhir - $mulai) / (60 *60);

			echo $d['nama_guru']."<hr>";
			echo $date->format('H:i')."<hr>";
			echo $selisih. " jam "  ;


			if($sekarang > $mulai && $sekarang < $akhir){
				echo $status = 'absen';
			}else{
				echo $status = 'masuk';
			}
		}
	}
}
?>
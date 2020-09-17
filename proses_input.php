<?php
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
}
include "koneksi.php";

// jika ada get act
if(isset($_GET['act'])){

	//proses simpan data
	if($_GET['act']=='insert'){
		//variabel dari elemen form
		$namaBarang 	= $_POST['nama_barang'];
		$noSerial 	= $_POST['no_serial'];
		$gudang  = $_POST['gudang'];
		$status	= $_POST['status'];
		
		if($namaBarang=='' || $noSerial=='' || $gudang=='' || $status==''){
			header('location:index.php?view=tambah#intro');
		}else{			
			//proses simpan data admin
			$simpan = mysqli_query($konek, "INSERT INTO masuk(nama_barang, no_serial, gudang_id_gudang, status_id_status ) 
							VALUES ('$namaBarang','$noSerial','$gudang','$status')");
			
			if($simpan){
				// BUAT QRCODE
				// tampung data kiriman
				$nomor = $noSerial;
			
				// include file qrlib.php
				include "phpqrcode/qrlib.php";
			
				//Nama Folder file QR Code kita nantinya akan disimpan
				$tempdir = "temp/";
			
				//jika folder belum ada, buat folder 
				if (!file_exists($tempdir)){
					mkdir($tempdir);
				}
			
				#parameter inputan
				$isi_teks = $nomor;
				$namafile = $pkjd.".png";
				$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
				$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
				$padding = 2;
			
				QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);

				header('location:index.php#intro');
			}else{
				header('location:index.php#intro');
			}
		}
	} // akhir proses simpan data

	else{
		header('location:index.php#intro');
	}

} // akhir get act

else{
	header('location:index.php#intro');
}
?>
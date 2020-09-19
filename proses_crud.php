<?php
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
}
include "koneksi.php";
date_default_timezone_set('Asia/Jakarta');
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
	} else if($_GET['act'] == 'edit'){
		$id = $_POST['id_barang'];
		$nama = $_POST['nama_barang'];
		$serial = $_POST['no_serial'];
		$gudang = $_POST['gudang'];
		$status = $_POST['status'];

		mysqli_query($konek, "UPDATE masuk SET nama_barang='$nama', no_serial='$serial', gudang_id_gudang='$gudang', status_id_status='$status' WHERE id_barang='$id'");

		header('location:index.php#intro');
	} else if($_GET['act'] == 'delete'){
		$id = $_GET['id'];
		mysqli_query($konek, "DELETE FROM masuk WHERE id_barang='$id'") ;
		header ('location:index.php');
	} else if($_GET['act']=='insert_keluar'){
		//variabel dari elemen form
		$nama = $_POST['nama_barang'];
		$serial = $_POST['no_serial'];
		$gudang = $_POST['gudang'];
		$status = $_POST['status'];
		$client  = $_POST['nama_client'];
		$dateOut = date('Y-m-d H:i:s');
		$idbarang = $_POST['id_barang'];
				
			//proses simpan data admin
		mysqli_query($konek, "INSERT INTO keluar (nama_client, tanggal_pengambilan, tanggal_kembali, masuk_id ) 
							VALUES ('$client','$dateOut',NULL,'$idbarang')"); 

		//proses edit status
		mysqli_query($konek,"UPDATE masuk SET nama_barang='$nama', no_serial='$serial', gudang_id_gudang='$gudang', status_id_status='2' WHERE id_barang='$idbarang'");
		header('location:index.php#report');

	}else if($_GET['act'] == 'edit_keluar'){
		//GET untuk tabel keluar
		$id = $_GET['id'];
		$nama = $_GET['nama'];
		$ambil = $_GET['ambil'];
		$masuk = $_GET['masuk'];
		$dateIn = date('Y-m-d H:i:s');

		//POST untuk tabel masuk
		$idbarang = $_GET['id_barang'];
		$namabarang = $_GET['nama_barang'];
		$serial = $_GET['no_serial'];
		$gudang = $_GET['gudang'];
		$status = $_GET['status'];

		mysqli_query($konek, "UPDATE keluar SET nama_client='$nama', tanggal_pengambilan='$ambil', tanggal_kembali='$dateIn', masuk_id='$masuk' WHERE id_keluar='$id'");

		mysqli_query($konek, "UPDATE masuk SET nama_barang='$namabarang', no_serial='$serial', gudang_id_gudang='$gudang', status_id_status='1' WHERE id_barang='$idbarang'");
		header('location:index.php#report');
	}else{
		header('location:index.php#intro');
	}// akhir proses simpan data

} // akhir get act

else{
	header('location:index.php#intro');
}
?>
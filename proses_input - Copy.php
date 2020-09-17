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
		
		echo "id nya adalah $gudang";
}
}
?>
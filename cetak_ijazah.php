<?php 
session_start();
if(isset($_SESSION['login'])){
	include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ijazah</title>
	<link rel="icon" href="./assets/img/logo.png">
	<style type="text/css">
		body{
			font-family: Arial;
		}

		@media print{
			.no-print{
				display: none;
			}
		}

		table{
			border-collapse: collapse;
		}
	</style>
</head>
<body>
<table border="6" cellpadding="80" cellspacing="0" width="100%">
<tr>
	<td>
	<table width="100%">
		<?php
		$sql=mysqli_query($konek, "SELECT * FROM masuk WHERE id_barang='$_GET[id]'");
		$d=mysqli_fetch_array($sql);
		?>
		<tr>
			<td colspan="3">
				<center>
				<img src="assets/img/logo.png" width="90px">
				<h1>UNIVERSITAS LURUILMU.COM</h1>
				<p>Jl. Pulau Beringin Blok. B Pondok Kelapa Bengkulu Tengah</p>
				<hr>
				<br>
				<p>Ijazah ini diberikan sebagai contoh saja, ya.. sekedar untuk ngetes pembuatan QR Code dan Contoh Validasinya.</p>
				<p>Oke langsung saja, menerangkan bahwa: </p>

				<h1><u><?php echo $d['nama_barang']; ?></u></h1>

				<p>Berhak menjadi Contoh dalam Ijazah ini. Dan dapat dilakukan tes lebih lanjut untuk mencoba mencetak ijazah ini dan memvalidasi dengan QR Code yang tersedia.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</center>
			</td>
		</tr>
		<tr>
			<td><img src="temp/<?php echo $d['nama_barang'].".png"; ?>"</td>
			<td></td>
			<td width="300px">
				<p>Pulau Beringin, <?php echo tglIndonesia(date('Y-m-d')); ?><br/>
				Pengesah Ijazah,</p>
				<br/>
				<br/>
				<br/>
				<p><b>LURUILMU.COM</b></p>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
<br>
<center><a href="#" class="no-print" onclick="window.print();">Cetak/Print</a></center>
</body>
</html>

<?php
}else{
	header('location:index.php');
}
?>
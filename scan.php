	<?php
	//ob_start();
	session_start();
	if(!isset($_SESSION['login'])){
		header('location:login.php');
	}

	include "koneksi.php";
	?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>E-Warehouse PKJD</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/style.css" />
		<!-- Tambahan -->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>

	<body class="is-preload">

		<!-- Wrapper -->
		<div id="wrapper"> 
				<!-- Main -->
		<div id="main">

			
			<!-- ======================================================================================================================================================== -->
			<!-- SCAN -->
				<article id="work">
					<?php
						$view = isset($_GET['view']) ? $_GET['view'] : null;

						switch($view)
						{
						default:
					?>

					<h2 class="major">Scan QR Code</h2>
					<span class="image main"></span>
					<div class="panel-body text-center" >
						<div id="reader"> </div>
					</div>

				
					<?php
						break;
						case "hasil":
					?>
					
						<h2 class="major">Scan Berhasil!</h2>
						<span class="image main"></span>
						<?php
							$sql=mysqli_query($konek, "SELECT * FROM (masuk msk left JOIN status sts on msk.status_id_status = sts.id_status) WHERE msk.no_serial='$_GET[serial]'");
							$d=mysqli_fetch_array($sql);
							if(mysqli_num_rows($sql) < 1){
						?>

					<!-- HASIL SCAN TIDAK DITEMUKAN -->
						<div class="alert alert-danger">
							<center>
								<strong>Maaf, Data tidak ditemukan..!</strong><br>
								<i>Silahkan menghubungi Perguruan Tinggi terkait untuk menanyakan masalah ini</i>
							</center>
						</div>
					
					<!-- HASIL SCAN DITEMUKAN -->
						<?php
							}else{
						?>
						<form method="post" action="proses_crud.php?act=insert_keluar">
							<div class="fields">
								<div class="field half">
									<input type="hidden" name="id_barang" value="<?php echo $d['id_barang']; ?>">
									<input type="hidden" name="gudang" value="<?php echo $d['gudang_id_gudang']; ?>">
									<input type="hidden" name="status" value="<?php echo $d['status_id_status'] ;?>">
									<input type="hidden" name="tanggal" value="">

									<label for='nama_barang' style='padding-top:10px; font-weight:bold;'>&nbsp;Nama Barang  </label>
									<input id='nama_barang' readonly class='form-content' type='text' name='nama_barang' autocomplete='on' value="<?php echo $d['nama_barang'];?>" />
									
									<label for='no_serial' style='padding-top:10px; font-weight:bold; '>&nbsp;Nomor Serial  </label>
									<input id='no_serial' readonly class='form-content' type='text' name='no_serial' autocomplete='on' value="<?php echo $d['no_serial'];?>"/>
									
									<label for='status' style='padding-top:10px; font-weight:bold;'>&nbsp;Status </label>
									<input id='status' readonly type='text' name='status' autocomplete='on' value="<?php echo $d['status'];?>" />						
										<?php
											if ($d['status_id_status'] == 2) {
										?>
														
										<?php
											} else {
										?>
									<label for='nama_client' style='padding-top:10px; font-weight:bold;'>&nbsp;Nama PIC </label>
									<input id='nama_client' class='form-content' type='text' name='nama_client' autocomplete='on' placeholder="Masukkan Nama Pengambil Barang" required="" />
										<?php
											}
										?>
								</div>
							</div>

							<ul class="actions" style="padding-top:0px;">
								<?php
									if ($d['status_id_status'] == 2) {
								?>
									<li><input type="submit" style="position: right; display:none;" value="SIMPAN" class="primary" /></li>
								<?php
									} else {
								?>
									<li style="padding-top:0px;"><input type="submit" style="position: right;" value="SIMPAN" class="button small" /></li>
								<?php
									}
								?>
									<li style="padding-top:0px;"> <a class="button small" href="scan.php#work"> Kembali </a> </li>

							</ul>
						</form>
			
					<?php 	} 
					?>

					<?php
							break;
							}
					?>
				</article>

		</div>

				<!-- Footer -->
			<footer id="footer">
			<!-- <p class="copyright">&copy; Untitled. Design: <a href="https://html5up.net">HTML5 UP</a>.</p> -->
			</footer>
		</div>

		<!-- BG -->
		<div id="bg"></div>
		<!-- Scripts -->
		<script src="assets/js/jquery-3.3.1.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>
			<script src="js/html5-qrcode.min.js"></script>
		<!-- SCAN CODE -->
		<script type="text/javascript">				
			function onScanSuccess(qrMessage) {
				console.log(`QR matched = ${qrMessage}`);
				window.location = 'scan.php?view=hasil&serial='+qrMessage+'#work' ;
				html5QrcodeScanner.clear();
			}

			// function onScanFailure(error) {
			// 	// handle scan failure, usually better to ignore and keep scanning
			// 	console.warn(`QR error = ${error}`);
			// }

			let html5QrcodeScanner = new Html5QrcodeScanner(
			"reader", { fps: 10, qrbox: 200 }, /* verbose= */ true);
			html5QrcodeScanner.render(onScanSuccess); // jika function onScanFailure di pakek tambahkan fungsinya di sebelah onScansuccess (onScanSuccess, onScanFailure)

			Html5Qrcode.getCameras().then(devices => {
				/**
				 * devices would be an array of objects of type:
				 * { id: "id", label: "label" }
				 */
				if (devices && devices.length) {
					var cameraId = devices[0].id;
					// .. use this to start scanning.
				}
			}).catch(err => {
				// handle err
			});

			// const html5QrCode = new Html5Qrcode("#reader");
			// const qrCodeSuccessCallback = message => { /* handle success */ }
			// const config = { fps: 10, qrbox: 250 };

			// // If you want to prefer front camera
			// html5QrCode.start({ facingMode: "user" }, config, qrCodeSuccessCallback);

			// // If you want to prefer back camera
			// html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);


			// const html5QrCode = new Html5Qrcode(/* element id */ "reader");
			// html5QrCode.start(
			// 	cameraId, 
			// 	{
			// 		fps: 10,    // Optional frame per seconds for qr code scanning
			// 		qrbox: 250  // Optional if you want bounded box UI
			// 	},
			// 	qrCodeMessage => {
			// 		// do something when code is read
			// 		html5QrcodeScanner.clear();
			// 	},
			// 	errorMessage => {
			// 		// parse error, ignore it.
			// 	})
			// .catch(err => {
			// 	// Start failed, handle it.
			// });

			// html5QrCode.stop().then(ignore => {
			// 	// QR Code scanning is stopped.
			// }).catch(err => {
			// 	// Stop failed, handle it.
			// });

		</script>
	</body>
</html>

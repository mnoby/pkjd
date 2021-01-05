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
			<!-- <a href="./validasi-ijazah"> Scan Now</a> -->
				<canvas></canvas>
				<hr>
				<select></select>
	    	</div>

			
			
<?php
	break;
	case "hasil":
?>

			<h2 class="major">Scan Berhasil!</h2>
			<span class="image main"></span>
<?php
        $sql=mysqli_query($konek, "SELECT * FROM (masuk msk left JOIN status sts on msk.status_id_status = sts.id_status) WHERE msk.no_serial='$_POST[serial]'");
        $d=mysqli_fetch_array($sql);
        if(mysqli_num_rows($sql) < 1){
?>

			<div class="alert alert-danger">
                <center>
                <strong>Maaf, Data tidak ditemukan..!</strong><br>
                <i>Silahkan menghubungi Perguruan Tinggi terkait untuk menanyakan masalah ini</i>
                </center>
            </div>

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

				<input id='nama_barang' readonly class='form-content' type='text' name='nama_barang' autocomplete='on' value="<?php echo $d['nama_barang'];?>" />
				<label for='nama_barang' style='padding-top:0px;'>&nbsp;Nama Barang  </label>
	
				<input id='no_serial' readonly class='form-content' type='text' name='no_serial' autocomplete='on' value="<?php echo $d['no_serial'];?>"/>
				<label for='no_serial' style='padding-top:0px'>&nbsp;Nomor Serial  </label>
	
				<input id='status' readonly type='text' name='status' autocomplete='on' value="<?php echo $d['status'];?>" />
				<label for='status' style='padding-top:0px'>&nbsp;Status </label>
				

<?php
	if ($d['status_id_status'] == 2) {
?>
				
<?php
	} else {
?>
				
			 	<input id='nama_client' class='form-content' type='text' name='nama_client' autocomplete='on' placeholder="Masukkan Nama Pengambil Barang" required="" />
			 	<label for='nama_client' style='padding-top:0px; ;'>&nbsp;Nama PIC </label>
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
					<li style="padding-top:0px;">
					<a class="button small" href="scan.php#work"> Kembali </a></li>

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
		<script type="text/javascript" src="js/jquery.js"></script>
			<script type="text/javascript" src="js/jquery.redirect.js"></script>
			<script type="text/javascript" src="js/qrcodelib.js"></script>
			<script type="text/javascript" src="js/webcodecamjquery.js"></script>

		<!-- SCAN CODE -->
			<script type="text/javascript">
			    var arg = 
			    {
			        resultFunction: function(result) 
			        {
			            //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
			           // $.post("../cek.php", { noijazah: result.code} );
			            var redirect = 'scan.php?view=hasil#work';
			           $.redirectPost(redirect, {serial: result.code});
			        }

			    };
			   // var url = window.location.href();
			   //const queryString = window.location.search;
			    //var url2 = 0;
			    var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
			    decoder.buildSelectMenu("select");

			   // while(url2){
			   // if (queryString == "#work") {
			    	decoder.play();
			     //Without visible select menu
			       // decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
			    
				//} else {
					//decoder.stop();

				//}
		//	}
			    $('select').on('change', function()
			    {
			        decoder.stop().play();
			    });

			    // jquery extend function
			    $.extend(
			    {
			        redirectPost: function(location, args)
			        {
			            var form = '';
			            $.each( args, function( key, value ) {
			                form += '<input type="hidden" name="'+key+'" value="'+value+'">';
			            });
			            $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
			        }
			    });
			</script>


	</body>
</html>

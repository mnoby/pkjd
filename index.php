<?php
ob_start();
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

		<!-- Tambahan -->
<!-- <link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/bootstrap.min.css"> -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="logo">
							<span class="icon fa-gem"></span>
						</div>
						<div class="content">
							<div class="inner">
								<h1>E-Warehouse</h1>
								<p>Selamat Datang di aplikasi E-Warehouse <br />
								PT. PUTRI JAYA KHARISMA PUTRI</p>
								<a href="logout.php">Logout</a>
							</div>
						</div>
						<nav>
							<ul>
								<li><a href="#intro">Items</a></li>
								<li><a href="#work">Scan</a></li>
								<li><a href="#about">Manual</a></li>
								<li><a href="#contact">Report</a></li>
								<!--<li><a href="#elements">Elements</a></li>-->
							</ul>
						</nav>
					</header>

				<!-- Main -->
					<div id="main">

						<!-- Intro -->
							<article id="intro">
								<h2 class="major">List of Items</h2>

								<!--Table List Brang-->
								<?php
$view = isset($_GET['view']) ? $_GET['view'] : null;

switch($view){
	default:
	?>
								<a class="primary" style="background-color: #FFF;
									border-radius: 4px;
									border: 0;
									box-shadow: inset 0 0 0 1px #ffffff;
									color: #1b1f22 !important;
									cursor: pointer;
									display: inline-block;
									font-size: 0.8rem;
									font-weight: 600;
									height: 2.75rem;
									letter-spacing: 0.2rem;
									line-height: 2.75rem;
									outline: 0;
									padding: 0 1.25rem 0 1.35rem;
									text-align: center;
									text-decoration: none;
									text-transform: uppercase;
									white-space: nowrap;" 
									href="index.php?view=tambah#intro">Tambah Data</a>
									<? php
									if(isset($_GET['pesan'])){
										$pesan = $_GET['pesan'];
										if($pesan == "input"){
											echo "Data berhasil di input.";
										}else if($pesan == "update"){
											echo "Data berhasil di update.";
										}else if($pesan == "hapus"){
											echo "Data berhasil di hapus.";
										}
									}?>

								<table style="width:100%; margin-top: 10px; " >
									<tr>
									<th style="text-align: center; " >Action</th>
									<th>Nama Barang</th>
									<th>Nomor Serial</th>
									<th>Lokasi Gudang</th>
									<th>Status</th>
									</tr>
									<?php
													$sql=mysqli_query($konek, "SELECT msk.id_barang, msk.nama_barang, msk.no_serial, gdg.Lokasi_gudang, sts.status FROM (masuk msk left JOIN gudang gdg on msk.gudang_id_gudang = gdg.id_gudang) left JOIN status sts on msk.status_id_status = sts.id_status ORDER by  status_id_status ASC");
													$no=1;
													while($d=mysqli_fetch_array($sql)){
														echo "
									<tr > 
									<td align='center' > 
									<ul class='actions'>
									<li> <a href='hapus.php?id=$d[id_barang]'> <img src='https://img.icons8.com/color/20/000000/delete-forever.png'> </a> </li>

									<li> <a href='index.php?view=tambah?id=$d[id_barang]#intro'> <img src='https://img.icons8.com/color/20/000000/approve-and-update.png'> </a> </li>

									<li> <a href='Create_QRCode.php?namaBarang=$d[nama_barang]&nomor=$d[no_serial]'> <img src='https://img.icons8.com/flat_round/20/000000/downloading-updates--v1.png'> </a> </li>

									<li> <a href='cetak_ijazah.php?id=$d[id_barang]'> <img src='https://img.icons8.com/offices/20/000000/jpg.png'> </a> </li>

									</ul></td>
									
								   	<td>$d[nama_barang]</td>
									<td>$d[no_serial]</td>
									<td>$d[Lokasi_gudang]</td>
									<td>$d[status]</td>";
								   $no++;
													}
													?>
									
									</tr>
								</table>
									<?php
	break;
	case "tambah":

?>


																	<!-- Form Input Barang -->
								<form method="post" class="form" action="proses_input.php?act=insert"> 

								<label for="username" style="padding-top:0px">&nbsp;Nama Barang</label>
								  <input
								   id="username"
								   class="form-content"
								   type="text"
								   name="nama_barang"
								   autocomplete="on"
								   required />
								  <!-- <div class="form-border"></div> -->
								<label for="user-password" style="padding-top:22px">&nbsp;Nomor Serial</label>
								  <input
								   id="user-password"
								   class="form-content"
								   type="text"
								   name="no_serial"
								   required />

								   <label for="lokasiGudang" style="padding-top:22px">&nbsp;Lokasi Gudang</label>
								  <select
								   id="lokasiGudang"
								   class="form-content"
								   type="text"
								   name="gudang"
								   required >
									<?php
													$sql=mysqli_query($konek, "SELECT * FROM gudang ORDER BY id_gudang ASC");
													$no=1;
													while($d=mysqli_fetch_array($sql)){
														echo "

								   <option value='$d[id_gudang]'> $d[Lokasi_gudang]</option>";
								   $no++;
													}
													?>
								   </select>

								   <label for="statusBarang" style="padding-top:22px">&nbsp;Status</label>
								  <select
								   id="statusBarang"
								   class="form-content"
								   name="status"
								   required>
								   <?php
													$sql=mysqli_query($konek, "SELECT * FROM status ORDER BY id_status ASC");
													$no=1;
													while($d=mysqli_fetch_array($sql)){
														echo "
								   <option value='$d[id_status]'> $d[status]</option>";
								   $no++;
													}
													?>
								   </select>

	<!-- 						   }
								   ?>  -->
								   <br>
								   <div class="col-md-6">
								<input class="primary" type="submit" value="Simpan" />
								<a class="primary" style="background-color: #FFF; border-radius: 4px; border: 0; box-shadow: inset 0 0 0 1px #ffffff; color: #1b1f22 !important; cursor: pointer; display: inline-block; font-size: 0.8rem; font-weight: 600; height: 2.75rem; letter-spacing: 0.2rem; line-height: 2.75rem; outline: 0; padding: 0 1.25rem 0 1.35rem; text-align: center; text-decoration: none; text-transform: uppercase; white-space: nowrap;" href="index.php#intro"> Kembali </a>
								</div>
								   </form>
								<?php
								break;
								}

								?>
								
							</article>

						<!-- Work -->
							<article id="work">
								<h2 class="major">Scan QR Code</h2>
								<span class="image main"></span>
								<a href="./validasi-ijazah"> Scan Now</a>
								<div class="panel-body text-center" >
						        <canvas></canvas>
						        <hr>
						        <select></select>
						    	</div>
								<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/qrcodelib.js"></script>
								<script type="text/javascript" src="js/webcodecamjquery.js"></script>
								<script type="text/javascript">
								    var arg = {
								        resultFunction: function(result) {
								            //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
								           // $.post("../cek.php", { noijazah: result.code} );
								            var redirect = "cek.php";
								            $.redirectPost(redirect, {noijazah: result.code});
								        }
								    };
								    
								    var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
								    decoder.buildSelectMenu("select")data;
								    decoder.play();
								    /*  Without visible select menu
								        decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
								    */
								    $('select').on('change', function(){
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
								
							</article>

						<!-- About -->
							<article id="about">
								<h2 class="major">Search by Serial Number</h2>
								<form method="post" action="#">
									<div class="fields">
										<div class="field half">
											<label for="name" >Serial Number</label>
											<input type="text" name="name" id="name" placeholder="Masukkan Nomor Serial disini" />
										</div>
										</div>
									<ul class="actions">
										<li><input type="submit" style="position: right;" value="Search" class="primary" /></li>
									</ul>
								</form>
								
							</article>

						<!-- Contact -->
							<article id="contact">
								<h2 class="major">Report</h2>
								<table style="width:100%">
									<tr>
									<th style="text-align: center;" >Action</th>
									<th>Nama Barang</th>
									<th>Nomor Serial</th>
									<th>Lokasi Gudang</th>
									<th>Nama Pengambil</th>
									<th>Tanggal Keluar</th>
									<th>Tanggal Kembali</th>
									</tr>

									<tr> 
									<td style="padding: 0px" align="center"> 
									<ul class="actions" >
										
										<li><input type="submit" value="Return" class="primary" style="padding: 0 10px 0 10px; margin-bottom: 20px; height: 60%" /> </li>
									</ul>
									
									</td>
									<td>55577854</td>
									<td>55577855</td>
									<td>123456</td>
									<td>12355</td>
									</tr>
								</table>
								
								<ul class="icons">
									<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
								</ul>
							</article>

						<!-- Elements -->
							<article id="elements">
								<h2 class="major">Elements</h2>

								<section>
									<h3 class="major">Text</h3>
									<p>This is <b>bold</b> and this is <strong>strong</strong>. This is <i>italic</i> and this is <em>emphasized</em>.
									This is <sup>superscript</sup> text and this is <sub>subscript</sub> text.
									This is <u>underlined</u> and this is code: <code>for (;;) { ... }</code>. Finally, <a href="#">this is a link</a>.</p>
									<hr />
									<h2>Heading Level 2</h2>
									<h3>Heading Level 3</h3>
									<h4>Heading Level 4</h4>
									<h5>Heading Level 5</h5>
									<h6>Heading Level 6</h6>
									<hr />
									<h4>Blockquote</h4>
									<blockquote>Fringilla nisl. Donec accumsan interdum nisi, quis tincidunt felis sagittis eget tempus euismod. Vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan faucibus. Vestibulum ante ipsum primis in faucibus lorem ipsum dolor sit amet nullam adipiscing eu felis.</blockquote>
									<h4>Preformatted</h4>
									<pre><code>i = 0;

while (!deck.isInOrder()) {
    print 'Iteration ' + i;
    deck.shuffle();
    i++;
}

print 'It took ' + i + ' iterations to sort the deck.';</code></pre>
								</section>

								<section>
									<h3 class="major">Lists</h3>

									<h4>Unordered</h4>
									<ul>
										<li>Dolor pulvinar etiam.</li>
										<li>Sagittis adipiscing.</li>
										<li>Felis enim feugiat.</li>
									</ul>

									<h4>Alternate</h4>
									<ul class="alt">
										<li>Dolor pulvinar etiam.</li>
										<li>Sagittis adipiscing.</li>
										<li>Felis enim feugiat.</li>
									</ul>

									<h4>Ordered</h4>
									<ol>
										<li>Dolor pulvinar etiam.</li>
										<li>Etiam vel felis viverra.</li>
										<li>Felis enim feugiat.</li>
										<li>Dolor pulvinar etiam.</li>
										<li>Etiam vel felis lorem.</li>
										<li>Felis enim et feugiat.</li>
									</ol>
									<h4>Icons</h4>
									<ul class="icons">
										<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon brands fa-github"><span class="label">Github</span></a></li>
									</ul>

									<h4>Actions</h4>
									<ul class="actions">
										<li><a href="#" class="button primary">Default</a></li>
										<li><a href="#" class="button">Default</a></li>
									</ul>
									<ul class="actions stacked">
										<li><a href="#" class="button primary">Default</a></li>
										<li><a href="#" class="button">Default</a></li>
									</ul>
								</section>

								<section>
									<h3 class="major">Table</h3>
									<h4>Default</h4>
									<div class="table-wrapper">
										<table>
											<thead>
												<tr>
													<th>Name</th>
													<th>Description</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Item One</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Two</td>
													<td>Vis ac commodo adipiscing arcu aliquet.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Three</td>
													<td> Morbi faucibus arcu accumsan lorem.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Four</td>
													<td>Vitae integer tempus condimentum.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Five</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"></td>
													<td>100.00</td>
												</tr>
											</tfoot>
										</table>
									</div>

									<h4>Alternate</h4>
									<div class="table-wrapper">
										<table class="alt">
											<thead>
												<tr>
													<th>Name</th>
													<th>Description</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Item One</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Two</td>
													<td>Vis ac commodo adipiscing arcu aliquet.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Three</td>
													<td> Morbi faucibus arcu accumsan lorem.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Four</td>
													<td>Vitae integer tempus condimentum.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Five</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"></td>
													<td>100.00</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</section>

								<section>
									<h3 class="major">Buttons</h3>
									<ul class="actions">
										<li><a href="#" class="button primary">Primary</a></li>
										<li><a href="#" class="button">Default</a></li>
									</ul>
									<ul class="actions">
										<li><a href="#" class="button">Default</a></li>
										<li><a href="#" class="button small">Small</a></li>
									</ul>
									<ul class="actions">
										<li><a href="#" class="button primary icon solid fa-download">Icon</a></li>
										<li><a href="#" class="button icon solid fa-download">Icon</a></li>
									</ul>
									<ul class="actions">
										<li><span class="button primary disabled">Disabled</span></li>
										<li><span class="button disabled">Disabled</span></li>
									</ul>
								</section>

								<section>
									<h3 class="major">Form</h3>
									<form method="post" action="#">
										<div class="fields">
											<div class="field half">
												<label for="demo-name">Name</label>
												<input type="text" name="demo-name" id="demo-name" value="" placeholder="Jane Doe" />
											</div>
											<div class="field half">
												<label for="demo-email">Email</label>
												<input type="email" name="demo-email" id="demo-email" value="" placeholder="jane@untitled.tld" />
											</div>
											<div class="field">
												<label for="demo-category">Category</label>
												<select name="demo-category" id="demo-category">
													<option value="">-</option>
													<option value="1">Manufacturing</option>
													<option value="1">Shipping</option>
													<option value="1">Administration</option>
													<option value="1">Human Resources</option>
												</select>
											</div>
											<div class="field half">
												<input type="radio" id="demo-priority-low" name="demo-priority" checked>
												<label for="demo-priority-low">Low</label>
											</div>
											<div class="field half">
												<input type="radio" id="demo-priority-high" name="demo-priority">
												<label for="demo-priority-high">High</label>
											</div>
											<div class="field half">
												<input type="checkbox" id="demo-copy" name="demo-copy">
												<label for="demo-copy">Email me a copy</label>
											</div>
											<div class="field half">
												<input type="checkbox" id="demo-human" name="demo-human" checked>
												<label for="demo-human">Not a robot</label>
											</div>
											<div class="field">
												<label for="demo-message">Message</label>
												<textarea name="demo-message" id="demo-message" placeholder="Enter your message" rows="6"></textarea>
											</div>
										</div>
										<ul class="actions">
											<li><input type="submit" value="Send Message" class="primary" /></li>
											<li><input type="reset" value="Reset" /></li>
										</ul>
									</form>
								</section>

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
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>

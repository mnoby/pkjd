	<?php
	//ob_start();
	session_start();
	if(!isset($_SESSION['Nama'])){
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
						<li><a href="scan.php#work">Scan</a></li>
						<li><a href="#about">Manual</a></li>
						<li><a href="#report">Report</a></li>
						<!--<li><a href="#elements">Elements</a></li>-->
					</ul>
				</nav>
			</header>

<!-- Main -->
	<div id="main">

<!-- Intro -->
	<article id="intro">
		<!--Table List Brang-->
			<?php
				$view = isset($_GET['view']) ? $_GET['view'] : null;
				switch($view)
				{
				default:
			?>

			<h2 class="major">List of Items</h2>
			<a class="button small" href="index.php?view=tambah#intro">Tambah Data</a>
			<table  class="table-container res" style="width:100%; margin-top: 10px; " > 
				<th style="text-align: center; " >Action</th>
				<th>Nama Barang</th>
				<th>Nomor Serial</th>
				<th>Lokasi Gudang</th>
				<th>Status</th>
				
				<?php
					$sql=mysqli_query($konek, "SELECT msk.id_barang, msk.nama_barang, msk.no_serial, gdg.id_gudang, gdg.Lokasi_gudang, sts.id_status, sts.status FROM (masuk msk left JOIN gudang gdg on msk.gudang_id_gudang = gdg.id_gudang) left JOIN status sts on msk.status_id_status = sts.id_status ORDER by  status_id_status ASC");
					$no=1;
					while($d=mysqli_fetch_array($sql)){
						echo "
							<tr> 
								<th scope='row' align='center' > 
									<ul class='alt'>
										<li> <a href='#' class='mores'> <i class='fa fa-chevron-down'> </i> </a>	</li>
										<li class='hidden' > <a href='proses_crud.php?act=delete&id=$d[id_barang]&namaBarang=$d[nama_barang]'> Delete </a>  </li>
										<li class='hidden'> <a href='index.php?view=edit&id=$d[id_barang]&id2=$d[id_gudang]&id3=$d[id_status]#intro'> Edit </a>  </li>
										<li class='hidden'> <a href='index.php?view=preview&id=$d[id_barang]&nb=$d[nama_barang]#intro'> View QR </a> </li>
									</ul>
								</th>
								
								<td>$d[nama_barang]</td>
								<td>$d[no_serial]</td>
								<td>$d[Lokasi_gudang]</td>
								<td>$d[status]</td>";
								$no++;
								}
					?>
									
							</tr>
			</table>

		<!--Form Tambah Item-->
			<?php
				break;
				case "tambah":

			?>
			<h2 class="major">TAMBAH ITEM</h2>
			<form method="post" class="form" action="proses_crud.php?act=insert"> 

				<label for="username" style="padding-top:0px">&nbsp;Nama Barang</label>
			  	<input id="username" class="form-content" type="text" name="nama_barang" autocomplete="on" required />

				<label for="user-password" style="padding-top:22px">&nbsp;Nomor Serial</label>
			  	<input id="user-password" class="form-content" type="text" name="no_serial" required />

				<label for="lokasiGudang" style="padding-top:22px">&nbsp;Lokasi Gudang</label>
			  	<select id="lokasiGudang" class="form-content" type="text" name="gudang" required >
					<option value="null"> - Pilih Lokasi Gudang - </option>
					<?php
						$sql=mysqli_query($konek, "SELECT * FROM gudang ORDER BY id_gudang ASC");
						$no=1;
						while($d=mysqli_fetch_array($sql))
						{
							echo "<option value='$d[id_gudang]'> $d[Lokasi_gudang]</option>";
							$no++;
							
						}
					?>
			   	</select>

				<label for="statusBarang" style="padding-top:22px">&nbsp;Status</label>
				<select id="statusBarang" class="form-content" name="status" required>
					<option value="null"> - Pilih Status Barang - </option>
					<?php
						$sql=mysqli_query($konek, "SELECT * FROM status ORDER BY id_status ASC");
						$no=1;
						while($d=mysqli_fetch_array($sql))
						{
							echo "<option value='$d[id_status]'> $d[status]</option>";
							$no++;
						}
					?>
				</select>
				<br>

				<div class="col-md-6">
					<ul style="float : right" class="actions">
						<li> <input class="button small" type="submit" value="SIMPAN" /> </li>
						<li> <a class="button small"  href="index.php#intro"> Kembali </a> </li>
					</ul>
				</div>
				
			</form> 

		
		<!-- Preview QRCode -->
			<?php
				break;
				case "preview":

			?>

			<h2 class="major">QRCode Preview</h2>
			<?php 
				if  (isset($_GET['id'])){
					$Id = $_GET['id'];
					$nb = $_GET['nb'];
					$sql=mysqli_query($konek, "SELECT nama_barang, no_serial FROM masuk WHERE id_barang = $Id");
					$d = mysqli_fetch_assoc($sql);
				}		
			?>
			<div style ="align-items: center; text-align: center;">
				<?php
					$path = "temp/";
					$filename = $path . $nb . '.png';
					//jika file di folder temp ada, maka hapus 
					if (file_exists($filename)) {
						echo "<img src='$filename' width='200' height='200' />";
					}
				?>

				<label for='nama_barang' style='padding-top:0px;'>&nbsp;<?php echo $d['nama_barang'] ?></label>	
				<label for='nama_barang' style='padding-top:0px'> <?php echo $d['no_serial'] ?></label>
				
				<div  style ="align-items: center;" >
					<ul  class="actions">
						<li > <a class="button small"  href="proses_crud.php?act=download&nb=<?php echo $d['nama_barang'] ?>"> Download </a> </li>
						<li > <a class="button small"  href="index.php#intro"> Kembali </a> </li>
					</ul>
				</div>
			</div>
		
				
			<br>

		<!-- Form Edit Barang -->
			<?php
				break;
				case "edit":
			?>
			<h2 class="major">Update Item</h2>
			<form method='post' class='form' action='proses_crud.php?act=edit'>
				<?php 
					if  (isset($_GET['id'])){
						$Id = $_GET['id'];
					#	$sql=mysqli_query($konek, "SELECT * FROM (masuk msk left JOIN gudang gdg on msk.gudang_id_gudang = gdg.id_gudang) left JOIN status sts on msk.status_id_status = sts.id_status");
						$sql=mysqli_query($konek, "SELECT * FROM (masuk msk left JOIN gudang gdg on msk.gudang_id_gudang = gdg.id_gudang) left JOIN status sts on msk.status_id_status = sts.id_status WHERE msk.id_barang = $Id");
						$d = mysqli_fetch_assoc($sql);
					}		
				?>
				<input type="hidden" name="id_barang" value="<?php echo $d['id_barang'] ?>">
				<label for='nama_barang' style='padding-top:0px'>&nbsp;Nama Barang</label>			
				<input id='nama_barang' class='form-content' type='text' name='nama_barang' autocomplete='on' value ="<?php echo $d['nama_barang']; ?>" required />
				<input id='nama_barang' class='form-content' type='hidden' name='oldName' autocomplete='on' value ="<?php echo $d['nama_barang']; ?>"/>

				<label for='nomor_serial' style='padding-top:22px'>&nbsp;Nomor Serial</label>
				<input id='nomor_serial' class='form-content' type='text' name='no_serial' value ="<?php echo $d['no_serial']; ?>" required />


					<!-- DROPDOWN LOKASI GUDANG -->
						<label for='lokasiGudang' style='padding-top:22px'>&nbsp;Lokasi Gudang</label>
						<select id='lokasiGudang' class='form-content' type='text' name='gudang' required />
							<option value="null"> - Pilih Lokasi Gudang - </option>

							<?php
								$sql=mysqli_query($konek,"SELECT * FROM gudang ");
								$no=1;
								while ($d = mysqli_fetch_array($sql)) {
									$no++;

									$ket="";
									if (isset($_GET['id2'])) {
										$Id2 = trim($_GET['id2']);

										if ($Id2==$d['id_gudang'])
										{
											$ket="selected";
										}
									}
							?>
							<option <?php echo $ket; ?> value="<?php echo $d['id_gudang'];?>"> <?php echo $d['Lokasi_gudang'];?> </option>
							<?php
								}
							?>
						</select>		

					<!-- DROPDOWN STATUS -->
						<label for='statusBarang' style='padding-top:22px'>&nbsp;Status</label>
						<select id='statusBarang' class='form-content' name='status' required/>
							<option value="null"> - Pilih Status Barang - </option>
							<?php
								$sql=mysqli_query($konek,"SELECT * FROM status");
								$no=1;
								while ($d = mysqli_fetch_array($sql)) {
									$no++;

									$ket="";
									if (isset($_GET['id3'])) {
										$Id3 = trim($_GET['id3']);

										if ($Id3==$d['id_status'])
										{
											$ket="selected";
										}
									}
							?>
							<option <?php echo $ket; ?> value="<?php echo $d['id_status'];?>"> <?php echo $d['status'];?> </option>
							<?php
								}
							?>
						</select>

						<br>

				<div class="col-md-6">
					<ul style="float:right" class="actions">
						<li> <input class="button small" type="submit" value="UPDATE" /> </li>
						<li> <a class="button small"  href="index.php#intro"> Kembali </a> </li>
					</ul>
				</div>
				
			</form>
			<?php
				break;
				}
			?>

	</article>


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
				<li style="padding-top:0px;"><input type="submit" style="position: right;" value="SIMPAN" class="primary" /></li>
				<?php
					}
				?>
				<li style="padding-top:0px;"><a class="primary" style="background-color: #FFF; border-radius: 4px; border: 0; box-shadow: inset 0 0 0 1px #ffffff; color: #1b1f22 !important; cursor: pointer; display: inline-block; font-size: 0.8rem; font-weight: 600; height: 2.75rem; letter-spacing: 0.2rem; line-height: 2.75rem; outline: 0; padding: 0 1.25rem 0 1.35rem; text-align: center; text-decoration: none; text-transform: uppercase; white-space: nowrap;" href="index.php#work"> Kembali </a></li>

			</ul>

        </form>
           
		<?php 	} 
		?>

		<?php
			break;
			}
		?>
	</article>


<!-- SEARCH MANUAL -->
	<article id="about">
		<?php
			$view = isset($_GET['view']) ? $_GET['view'] : null;
			switch ($view) {
				default:
		?>			
		<h2 class="major">Manual Searching</h2>
		<form method="post" action="index.php?view=hasilManual#about">
			<div class="fields">
				<div class="field half">
					<label for="no_serial" >Serial Number</label>
					<input type="text" name="nomor_serial" id="no_serial" placeholder="Masukkan Nomor Serial disini" />
				</div>
			</div>
			<ul class="actions">
				<li><input type="submit"  value="Search" class="button small" /></li>
			</ul>
		</form>

		<?php
			break;
			case "hasilManual":

			$sql=mysqli_query($konek, "SELECT * FROM (masuk msk left JOIN status sts on msk.status_id_status = sts.id_status) WHERE msk.no_serial='$_POST[nomor_serial]'");
			$d=mysqli_fetch_array($sql);
			if(mysqli_num_rows($sql) < 1){
		?>
		<div class="alert alert-danger">
			<center>
				<strong>Maaf, Data tidak ditemukan..!</strong><br>
				<i>Silahkan menghubungi Perguruan Tinggi terkait untuk menanyakan masalah ini</i>
				<br>
				<br>
				<a class="button small" href="index.php#about"> Kembali </a>
			</center>
		</div>

		<?php
				}else{
		?>
		<h2 class="major">Nomor Serial Ditemukan!</h2>
		<span class="image main"></span>
		<form method="post" action="proses_crud.php?act=insert_keluar">
			<div class="fields">
				<div class="field half">
					<input type="hidden" name="id_barang" value="<?php echo $d['id_barang']; ?>">
					<input type="hidden" name="gudang" value="<?php echo $d['gudang_id_gudang']; ?>">
					<input type="hidden" name="status" value="<?php echo $d['status_id_status'] ;?>">
					<input type="hidden" name="tanggal" value="">

					
					<input id='nama_barang' readonly class='form-content' type='text' name='nama_barang' autocomplete='on' value="<?php echo $d['nama_barang'];?>" />
					<label for='nama_barang' style='padding-top:0px; font-weight: 600;'>&nbsp;Nama Barang  </label>

					<input id='no_serial' readonly class='form-content' type='text' name='no_serial' autocomplete='on' value="<?php echo $d['no_serial'];?>" />
					<label for='no_serial' style='padding-top:0px; font-weight: 600;'>&nbsp;Nomor Serial  </label>

					<input id='status' readonly class='form-content' type='text' name='status' autocomplete='on' value="<?php echo $d['status'];?>" />
					<label for='status' style='padding-top:0px; font-weight: 600;'>&nbsp;Status </label>

					<?php
						if ($d['status_id_status'] != 2) {
					?>
					<input id='nama_client' class='form-content' type='text' name='nama_client' autocomplete='on' placeholder="Masukkan Nama Pengambil Barang" required />
					<label for='nama_client' style='padding-top:0px; font-weight: 600;'>&nbsp;Nama PIC </label>
					<?php
						}
					?>
				</div>
			</div>

			<ul class="actions">
				<?php
					if ($d['status_id_status'] == 2) {
				?>
				<li><input type="submit" style="position: right; display:none;" value="SIMPAN" class="primary" /></li>
				<?php
					} else {
				?>
				<li><input type="submit" value="SIMPAN" class="button small" /></li>
				<?php
					}
				?>
				<li><a class="button small" href="index.php#about"> Kembali </a></li>

			</ul>

        </form>
		<?php 	} 
		?>

		<?php 
			break;
			}
		?>
			
	</article>

<!-- REPORT -->
	<article id="report">
		<h2 class="major">Report</h2>
		<table class="demo-table res3" style="width:100%;  ">
			<thead>
				<tr>
					<th scope = "col" class="column-primary" >Nama Barang</th>
					<th scope = "col">No. Serial</th>
					<th scope = "col">Lok. Gudang</th>
					<th scope = "col">Nama PIC</th>
					<th scope = "col">Tgl Keluar</th>
					<th scope = "col">Tgl Kembali</th>
					<th scope = "col" class="column-primary" >Action</th>
				</tr>
			</thead>

			<?php
			$sql = mysqli_query($konek,"SELECT * FROM (keluar klr left JOIN masuk msk on klr.masuk_id = msk.id_barang)left JOIN gudang gdg on msk.gudang_id_gudang = gdg.id_gudang");
			$no=1;
			while ($d=mysqli_fetch_array($sql)) {
			?>
			<tbody>
				<tr> 
					<td data-header="Nama Barang"><?php echo $d['nama_barang']; ?>
						<a href="#" class="more"> <i class="fa fa-chevron-down"> </i> </a>
					</td>
					<td data-header="No. Serial"><?php echo $d['no_serial']; ?></td>
					<td data-header="Lok. Gudang"><?php echo $d['Lokasi_gudang']; ?></td>
					<td data-header="Nama PIC"><?php echo $d['nama_client']; ?></td>
					<td data-header="Tgl Keluar"><?php echo $d['tanggal_pengambilan']; ?></td>
					<td data-header="Tgl Kembali"><?php echo $d['tanggal_kembali']; ?></td>
					<th scope="row">
							<ul class="actions" >
							<?php
							if ($d['tanggal_kembali'] == NULL){
							?>
							<li>
								<br>
								<a class="button primary"  href="proses_crud.php?act=edit_keluar&id=<?php echo $d['id_keluar']?>&nama=<?php echo $d['nama_client']?>&ambil=<?php echo $d['tanggal_pengambilan']?>&masuk=<?php echo $d['masuk_id']?>&id_barang=<?php echo $d['id_barang']?>&nama_barang=<?php echo $d['nama_barang']?>&no_serial=<?php echo $d['no_serial']?>&gudang=<?php echo $d['gudang_id_gudang']?>&status=<?php echo $d['status_id_status']?>">
								RETURN </a>
							</li>
							<?php
								} else{
							?>
								<br>
							<li><a class="button" :disabled style="text-decoration: line-through"> RETURN </a> </li>

							<?php
								}
							?>
							</ul>
					</th>
				</tr>
			</tbody>
			<?php
			$no++;
			}
			?>
		</table>
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
		
		<script src="assets/js/jquery-3.3.1.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>
		

<script>
$(document).ready(function() {
	$('a.more').click(function() {
	
		// Toggle Class
		$tr = $(this).parent().parent();
		$tr.toggleClass('expanded');
	
		// Tampilkan - sembunyikan baris
		$i = $(this).children('i');
		$i.removeClass('fa-chevron-up', 'fa-chevron-down');
		var arrow = $tr.hasClass('expanded') ? 'fa-chevron-up' : 'fa-chevron-down';
		$i.addClass(arrow);
		return false;
	});
})
</script>

<script>
$(document).ready(function() {
	$('a.mores').click(function() {
	
		// Toggle Class
		$ul = $(this).parent().parent();
		$ul.toggleClass('expanded');
		
		// Tampilkan - sembunyikan baris
		$i = $(this).children('i');
		$i.removeClass('fa-chevron-up', 'fa-chevron-down');
		var arrow = $ul.hasClass('expanded') ? 'fa-chevron-up' : 'fa-chevron-down';
		$i.addClass(arrow);
		return false;
	});
})
</script>

	</body>
</html>

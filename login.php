<!DOCTYPE HTML>

<html>
	<head>
		<title>E-Warehouse PKJD</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style type="text/css"> 
		label {
		    font-family: "Raleway", sans-serif;
		    font-size: 11pt;
		}
		#forgot-pass {
		    color: #2dbd6e;
		    font-family: "Raleway", sans-serif;
		    font-size: 10pt;
		    margin-top: 3px;
		    text-align: right;
		}
		.form {
		    align-items: left;
		    display: flex;
		    flex-direction: column;
		}
		.form-border {
		    background: -webkit-linear-gradient(right, #a6f77b, #2ec06f);
		    height: 1px;
		    width: 100%;
		}
		.form-content {
		    background: #fbfbfb;
		    border: none;
		    outline: none;
		    padding-top: 14px;
		}
		</style>
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
								<p>Silahkan Login Terlebih dahulu.</p>
<?php 
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$user	= $_POST['Username'];
					$pass	= $_POST['Password'];
					$p		= md5($pass);
					if($user=='' || $pass==''){
						?>
						<div class="alert alert-warning alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <?php
						  echo "<strong>Error!</strong> Form Belum Lengkap!!";
						  ?>
						</div>
						<?php
					}else{
						include "koneksi.php";
						$sqlLogin = mysqli_query($konek, "SELECT * FROM user WHERE Username='$user' AND Password='$p'");
						$jml=mysqli_num_rows($sqlLogin);
						$d=mysqli_fetch_array($sqlLogin);
						if($jml > 0){
							session_start();
							$_SESSION['login']		= TRUE;
							$_SESSION['id']			= $d['id'];
							$_SESSION['Username']	= $d['Username'];
							$_SESSION['Nama']		= $d['Nama'];	
							
							header('Location:./index.php');
						}else{
						?>
							<div class="alert alert-danger alert-dismissible" role="alert">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							  <?php
							  echo "<strong>Error!</strong> Username dan Password anda Salah!!!";
							  ?>
							</div>
						<?php
						}
						
					}
				}
				?>
<form method="post" class="form"> 

<label for="user-email" style="padding-top:0px">&nbsp;Username</label>
  <input
   id="user-email"
   class="form-content"
   type="text"
   name="Username"
   autocomplete="on"
   required />
  <!-- <div class="form-border"></div> -->
<label for="user-password" style="padding-top:22px">&nbsp;Password</label>
  <input
   id="user-password"
   class="form-content"
   type="password"
   name="Password"
   required />
   <br>
   <input type="submit" class="primary" value="Login" />
   </form>
  <!-- <div class="form-border"></div> -->
								
							</div>
						</div>
						<nav>
							<!-- <ul>
								<li><a href="#intro">Items</a></li>
								<li><a href="#work">Scan</a></li>
								<li><a href="#about">Manual</a></li>
								<li><a href="#contact">Report</a></li>
							</ul>
						</nav> -->
					</header>

				<!-- Main -->
					

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

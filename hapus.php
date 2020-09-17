<?php
include "koneksi.php";


$id = $_GET['id'];
mysqli_query($konek, "DELETE FROM masuk WHERE id_barang='$id'") ;

header ('location:index.php');


?>
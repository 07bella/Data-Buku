<?php
include "koneksi.php";
$id = $_POST['id'];
mysqli_query($koneksi, "delete from  tb_buku where id='$id'");
?>

<?php
include 'koneksi.php';

$judul = $_POST['judul'];

mysqli_query($koneksi, "insert into tb_buku values ('','$judul');");
?>
<?php
include 'koneksi.php';
$result=mysqli_query($koneksi, "select*from tb_buku");
if (mysqli_num_rows($result) > 0 ){
    while($row=$result->fetch_assoc()){
        $json[]=$row;
    };
    $total=mysqli_num_rows($result);

    $data['data']=$json;
    $data['total']=$total;
} else {
    $data['total']=0;
}
echo json_encode($data,JSON_PRETTY_PRINT);
?>
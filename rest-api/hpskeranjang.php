<?php
include("connection.php");

$konek = mysqli_connect("localhost", "root", "", "hasilbumi");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $product_id = $_POST["product_id"];
    
    $perintah = "DELETE FROM cart WHERE product_id = '$product_id'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek      = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = true;
        $response["pesan"] = "Data Berhasil Dihapus";
    }
    else{
        $response["kode"] = false;
        $response["pesan"] = "Gagal Menghapus Data";
    }
}
else{
    $response["kode"] = false;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);
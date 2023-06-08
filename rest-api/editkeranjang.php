<?php
include 'connection.php';

$konek = mysqli_connect("localhost", "root", "", "hasilbumi");

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $product_id     = $_POST['product_id'];
    $user_id        = $_POST['user_id'];
    $product_name   = $_POST['product_name'];
    $qty            = $_POST['qty'];
    $harga          = $_POST['harga'];
    $satuan         = $_POST['satuan'];
    $berat          = $_POST['berat'];
    $harga_awal     = $_POST['harga_awal'];
    $stok           = $_POST['stok'];

    
    $perintah = "UPDATE cart SET product_id = '$product_id',
                                 user_id    = '$user_id', 
                                 product_name = '$product_name', 
                                 qty = '$qty',
                                 harga = '$harga',
                                 satuan = '$satuan',
                                 berat = '$berat',
                                 harga_awal = '$harga_awal',
                                 stok = '$stok'  WHERE product_id = '$product_id'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek      = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["status"] = true;
        $response["message"] = "Data Keranjang Berhasil Dirubah";
    }
    else{
        $response["status"] = false;
        $response["message"] = "Data Gagal Dirubah";
    }
}
else{
    $response["status"] = false;
    $response["message"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);
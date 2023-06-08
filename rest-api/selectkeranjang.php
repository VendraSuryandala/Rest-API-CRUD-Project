<?php
include 'connection.php';

$konek = mysqli_connect("localhost", "root", "", "hasilbumi");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $product_id   = $_POST['product_id'];
    
    $perintah = "SELECT * FROM cart WHERE product_id = '$product_id'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek      = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["status"] = true;
        $response["message"] = "Silahkan Edit keranjang";
        $response["data"] = array();

        while($ambil = mysqli_fetch_object($eksekusi)){
            $F["user_id"] = $ambil->user_id;
            $F["product_id"] = $ambil->product_id;
            $F["product_name"] = $ambil->product_name;
            $F["qty"] = $ambil->qty;
            $F["harga"] = $ambil->harga;
            $F["satuan"] = $ambil->satuan;
            $F["berat"] = $ambil->berat;
            $F["harga_awal"] = $ambil->harga_awal;
            $F["stok"] = $ambil->stok;
            
            array_push($response["data"], $F);
        }
    }
    else{
        $response["status"] = false;
        $response["message"] = "Tidak dapat edit keranjang";
    }
}
else{
    $response["status"] = false;
    $response["message"] = "Tidak ada data keranjang";
}

echo json_encode($response);
mysqli_close($konek);

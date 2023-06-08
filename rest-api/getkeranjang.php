<?php
include 'connection.php';

$konek = mysqli_connect("localhost", "root", "", "hasilbumi");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id   = $_POST['user_id'];
    
    $perintah = "SELECT * FROM cart WHERE user_id = '$user_id'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek      = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["status"] = true;
        $response["message"] = "Data Keranjang Tersedia";
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
        $response["message"] = "Data keranjang tidak Tersedia";
    }
}
else{
    $response["status"] = false;
    $response["message"] = "Tidak ada data keranjang";
}

echo json_encode($response);
mysqli_close($konek);

<?php
include 'connection.php';

$konek = mysqli_connect("localhost", "root", "", "hasilbumi");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id   = $_POST['user_id'];
    
    $perintah = "SELECT * FROM pesanan WHERE user_id = '$user_id'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek      = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["status"] = true;
        $response["message"] = "Data pemesanan tersedia";
        $response["data"] = array();

        while($ambil = mysqli_fetch_object($eksekusi)){
            $F["user_id"] = $ambil->user_id;
            $F["idorder"] = $ambil->idorder;
            $F["datetime"] = $ambil->datetime;
            $F["total_harga"] = $ambil->total_harga;
            $F["order_kurir"] = $ambil->order_kurir;
            $F["order_layanan"] = $ambil->order_layanan;
            $F["status"] = $ambil->status;
            array_push($response["data"], $F);
        }
    }
    else{
        $response["status"] = false;
        $response["message"] = "Data pemesanan tidak Tersedia";
    }
}
else{
    $response["status"] = false;
    $response["message"] = "Tidak ada data pemesanan";
}

echo json_encode($response);
mysqli_close($konek);

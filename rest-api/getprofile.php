<?php
include 'connection.php';

$konek = mysqli_connect("localhost", "root", "", "hasilbumi");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $idusers   = $_POST['idusers'];
    
    $perintah = "SELECT * FROM users WHERE idusers = '$idusers'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek      = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["status"] = true;
        $response["message"] = "Data profil tersedia";
        $response["data"] = array();

        while($ambil = mysqli_fetch_object($eksekusi)){
            $F["idusers"] = $ambil->idusers;
            $F["user_fullname"] = $ambil->user_fullname;
            $F["user_telp"] = $ambil->user_telp;
            $F["user_name"] = $ambil->user_name;
        
            array_push($response["data"], $F);
        }
    }
    else{
        $response["status"] = false;
        $response["message"] = "Data profil tidak Tersedia";
    }
}
else{
    $response["status"] = false;
    $response["message"] = "Tidak ada data profil";
}

echo json_encode($response);
mysqli_close($konek);

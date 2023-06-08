<?php
include 'connection.php';

$konek = mysqli_connect("localhost", "root", "", "hasilbumi");

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $idusers       = $_POST["idusers"];
    $user_fullname = $_POST["user_fullname"];
    $user_telp     = $_POST["user_telp"];
    $user_name     = $_POST["user_name"];
    
    $perintah = "UPDATE users SET user_fullname = '$user_fullname', user_telp = '$user_telp', user_name = '$user_name'
     WHERE idusers = '$idusers'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek      = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["status"] = true;
        $response["message"] = "Data Profil Berhasil Dirubah";
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
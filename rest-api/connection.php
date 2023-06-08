<?php

$connection = null;

try{
    $host           = "localhost";
    $user_name      = "root";
    $user_password  = "";
    $dbname         = "hasilbumi";

    $database   = "mysql:dbname=$dbname;host=$host";
    $connection = new PDO($database, $user_name, $user_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // if($connection){
    //     echo "Koneksi berhasil";
    // }else{
    //     echo "Gagal";
    // }


}catch (PDOException $e){
    echo    "Error ! " . $e->getMessage();
    die;
}

?>
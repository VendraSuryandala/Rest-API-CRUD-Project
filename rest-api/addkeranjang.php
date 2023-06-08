<?php
include 'connection.php';

$koneksi = mysqli_connect("localhost", "root", "", "hasilbumi");

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id     = $_POST['product_id'];
    $user_id        = $_POST['user_id'];
    $product_name   = $_POST['product_name'];
    $qty            = $_POST['qty'];
    $harga          = $_POST['harga'];
    $satuan         = $_POST['satuan'];
    $berat          = $_POST['berat'];
    $harga_awal     = $_POST['harga_awal'];
    $stok           = $_POST['stok'];


    $response = [];

    //cek produk
    $userQuery = $connection->prepare("SELECT * FROM cart where product_id =?");
    $userQuery->execute(array($product_id));

    if($userQuery->rowCount() != 0) {

        $response['status'] = false;
        $response['message'] = "Produk sudah di keranjang!";
   
    }else{
    $sql = "INSERT INTO cart ( product_id, user_id, product_name, qty, harga, satuan, berat, harga_awal, stok)
    VALUES (:product_id, :user_id, :product_name, :qty, :harga, :satuan, :berat, :harga_awal, :stok)";
    $statment = $connection->prepare($sql);   

    try{
        $statment->execute([
            ':product_id'     => $product_id,
            ':user_id'        => $user_id, 
            ':product_name'   => $product_name,
            ':qty'            => $qty,
            ':harga'          => $harga,
            ':satuan'         => $satuan,
            ':berat'          => $berat,
            ':harga_awal'     => $harga_awal,
            ':stok'           => $stok
        ]);
    $response['status'] = true;
    $response['message'] = "berhasil memasukkan ke keranjang";
    $response['data'] =[
        'user_id'       => $user_id,
        'product_id'    => $product_id,
        'product_name'  => $product_name,
        'qty'           => $qty,
        'harga'         => $harga,
        'satuan'        => $satuan,
        'berat'         => $berat,
        'harga_awal'    => $harga_awal,
        'stok'          => $stok
    
    ];
    }catch  (Exception $e){
        die($e->getMessage());
    }
  }
}

 //merubah data menjadi JSON
 $json = json_encode($response, JSON_PRETTY_PRINT);

 echo $json;


?>
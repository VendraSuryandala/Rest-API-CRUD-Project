<?php
include 'connection.php';

$koneksi = mysqli_connect("localhost", "root", "", "hasilbumi");
    
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = "SELECT * FROM product";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while($data = mysqli_fetch_assoc($query)){
        $array_data[] = $data;
    }

    echo json_encode($array_data);

}else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idproduct      = $_POST['idproduct'];
    $product_name   = $_POST['product_name'];
    $product_seo    = $_POST['product_seo'];
    $satuan         = $_POST['satuan'];
    $harga_beli     = $_POST['harga_beli'];
    $harga_jual     = $_POST['harga_jual'];
    $diskon         = $_POST['diskon'];
    $berat          = $_POST['berat'];
    $product_image  = $_POST['product_image'];
    $keterangan     = $_POST['keterangan'];
    $stok           = $_POST['stok'];
    $sql = "INSERT INTO product (idproduct,product_name, product_seo, satuan, harga_beli, harga_jual, diskon, berat, product_image, keterangan, stok)
    VALUES ('$idproduct','$product_name', '$product_seo', '$satuan', '$harga_beli', '$harga_jual', '$diskon', '$berat',  '$product_image', '$keterangan', '$stok')";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            'pesan' => "gagal"
        ];
        echo json_encode([$data]);
    }  

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $idproduct = $_GET['idproduct'];
    $sql = "DELETE FROM product WHERE idproduct='$idproduct'";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            'pesan' => "gagal"
        ];
        echo json_encode([$data]);
    } 

}else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $idproduct      = $_GET['idproduct'];
    $product_name   = $_GET['product_name'];
    $product_seo    = $_GET['product_seo'];
    $satuan         = $_GET['satuan'];
    $harga_beli     = $_GET['harga_beli'];
    $harga_jual     = $_GET['harga_jual'];
    $diskon         = $_GET['diskon'];
    $berat          = $_GET['berat'];
    $product_image  = $_GET['product_image'];
    $keterangan     = $_GET['keterangan'];
    $stok           = $_GET['stok'];

    $sql = "UPDATE product SET product_name='$product_name', product_seo='$product_seo ', satuan='$satuan', 
    harga_beli='$harga_beli', harga_jual='$harga_jual' , diskon='$diskon' , product_image='$product_image',
    keterangan='$keterangan', stok ='$stok' WHERE idproduct='$idproduct'";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            'pesan' => "gagal"
        ];
        echo json_encode([$data]);
    } 

}

?>
<?php
include 'connection.php';

$koneksi = mysqli_connect("localhost", "root", "", "hasilbumi");

if($_POST){

    $user_fullname      = $_POST['user_fullname'] ?? '';
    $user_telp          = $_POST['user_telp'] ?? '';
    $user_name          = $_POST['user_name'] ?? '';
    $user_password      = $_POST['user_password'] ?? '';
    $user_type          = $_POST['customer'] ?? '';    
    $is_active          = $_POST['1'] ?? '';
    $is_block           = $_POST['0'] ?? '';

    $response = []; //tempat untuk data

    //cek user
    $userQuery = $connection->prepare("SELECT * FROM users where user_name = ?");
    $userQuery->execute(array($user_name));
    $query = $userQuery->fetch();
    
    if($userQuery->rowCount() == 0){
        $response['status'] = false;
        $response['message'] = "Username tidak terdaftar!";
    }else{

        //jika ada username mengambil password
        $user_passwordDB = $query['user_password'];

        if (password_verify($user_password, $user_passwordDB)){
    
            $response['status'] = true;
            $response['message'] = "Login Berhasil";
            $response['data'] =[
                'idusers'       => $query['idusers'],
                'user_fullname' => $query['user_fullname'],
                'user_telp'     => $query['user_telp'],
                'user_name'     => $query['user_name']
            ];
        }else{
            $response['status'] = false;
            $response['message']= "Password anda salah!";
        }
    }

    //merubah data menjadi JSON

    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;

}else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $idusers        = $_POST['idusers'];
    $user_fullname  = $_POST['user_fullname'];
    $user_telp      = $_POST['user_telp'];
    $user_name      = $_POST['user_name'];

    $sql = "UPDATE users SET user_fullname='$user_fullname', user_telp='$user_telp', user_name='$user_name' WHERE idusers='$idusers'";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            'status' => "berhasil ubah data!"
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            'pesan' => "gagal ubah data!"
        ];
        echo json_encode([$data]);
    } 
}
<?php
include 'connection.php';

if($_POST){

    $user_fullname      = filter_input(INPUT_POST, 'user_fullname', FILTER_SANITIZE_STRING);
    $user_telp          = filter_input(INPUT_POST, 'user_telp', FILTER_SANITIZE_STRING);
    $user_name          = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
    $user_password      = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING);
    $user_type          = filter_input(INPUT_POST, 'customer',FILTER_SANITIZE_STRING);
    $is_active          = filter_input(INPUT_POST, '1',FILTER_SANITIZE_STRING);
    $is_block           = filter_input(INPUT_POST, '0',FILTER_SANITIZE_STRING);
    $create_at          = filter_input(INPUT_POST, 'create_at',FILTER_SANITIZE_STRING);

    $response = [];
 
    //cek user
    $userQuery = $connection->prepare("SELECT * FROM users where user_name = ?");
    $userQuery->execute(array($user_name));
   
    if($userQuery->rowCount() != 0) {

        $response['status'] = false;
        $response['message'] = "Akun sudah terdaftar!";
    }else{
        $insertAccount = 'INSERT INTO users (user_fullname, user_telp, user_name, user_password,user_type,
        is_active,is_block,create_at) 
        values (:user_fullname,:user_telp,:user_name,:user_password,:user_type,:is_active,:is_block,:create_at)';
        $statment = $connection->prepare($insertAccount);

        try{
            $statment->execute([
            ':user_fullname'    => $user_fullname,
            ':user_telp'        => $user_telp,
            ':user_name'        => $user_name,
            ':user_password'    => password_hash($user_password, PASSWORD_DEFAULT),
            ':user_type'        => "customer",
            ':is_active'        => "1",
            ':is_block'         => "0",
            ':create_at'        => str_replace("-", "", date("d-m-Y")) // atau bisa juga dengan date("ymd")
            ]);

        $response['status'] = true;
        $response['message'] = "Akun berhasil didaftar!";
        $response['data'] =[
            'user_fullname' => $user_fullname,
            'user_telp'     => $user_telp,
            'user_name'     => $user_name
        ];
        }catch (Exception $e){
            die($e->getMessage());
        }

    }

    //merubah data menjadi JSON
    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;

}

?>
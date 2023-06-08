<?php
include 'connection.php';

if($_POST){
    $user_id        = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);
    $file           = filter_input(INPUT_POST, 'file', FILTER_SANITIZE_STRING);
    $total          = filter_input(INPUT_POST, 'total', FILTER_SANITIZE_STRING);
    $status         = filter_input(INPUT_POST, 'pending', FILTER_SANITIZE_STRING);
    $keterangan     = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);
    $create_at      = filter_input(INPUT_POST, 'create_at', FILTER_SANITIZE_STRING);

    $response = [];


    $insertpembayaran = 'INSERT INTO pembayaran (order_id, user_id, file, total, status, keterangan,
    create_at) 
    values (:order_id, :user_id, :file, :total, :status, :keterangan, :create_at)';
    $statment = $connection->prepare($insertpembayaran);
    
    try{
        $statment->execute([
            ':user_id'      => $user_id,
            ':file'         => $file,
            ':total'        => $total,
            ':status'       => "pending",
            ':keterangan'   => $keterangan,
            ':create_at'    => str_replace("-", "", date("Y-m-d")),
        ]);

        $response['status'] = true;
        $response['message'] = "Berhasil Melakukan pembayaran!";
   
        }catch (Exception $e){
            die($e->getMessage());
        }

    }

    //merubah data menjadi JSON
    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;

}
?>
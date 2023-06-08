<?php
include 'connection.php';

$koneksi = mysqli_connect("localhost", "root", "", "hasilbumi");

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $user_id = $_GET ['user_id'];
    
    $sql = "SELECT * FROM pesanan WHERE user_id = $user_id";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while($data = mysqli_fetch_assoc($query)){
        $array_data[] = $data;
    }

    echo json_encode($array_data);
}else

if($_POST){

    $user_id       = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);
    $code          = filter_input(INPUT_POST, 'CDR-', FILTER_SANITIZE_STRING);
    $datetime      = filter_input(INPUT_POST, 'datetime', FILTER_SANITIZE_STRING);
    $subtotal      = filter_input(INPUT_POST, 'subtotal', FILTER_SANITIZE_STRING);
    $total_harga   = filter_input(INPUT_POST, 'total_harga', FILTER_SANITIZE_STRING);
    $order_prov    = filter_input(INPUT_POST, 'order_prov', FILTER_SANITIZE_STRING);
    $order_kab     = filter_input(INPUT_POST, 'order_kab', FILTER_SANITIZE_STRING);
    $order_kec     = filter_input(INPUT_POST, 'order_kec', FILTER_SANITIZE_STRING);
    $order_kodepos = filter_input(INPUT_POST, 'order_kodepos', FILTER_SANITIZE_STRING);
    $order_address = filter_input(INPUT_POST, 'order_address', FILTER_SANITIZE_STRING);
    $order_kurir   = filter_input(INPUT_POST, 'order_kurir', FILTER_SANITIZE_STRING);
    $order_layanan = filter_input(INPUT_POST, 'order_layanan', FILTER_SANITIZE_STRING);
    $status_bayar  = filter_input(INPUT_POST, 'pending', FILTER_SANITIZE_STRING);
    $status        = filter_input(INPUT_POST, 'Pending', FILTER_SANITIZE_STRING);
    $create_at     = filter_input(INPUT_POST, 'create_at',FILTER_SANITIZE_STRING);

    $response = [];

     //cek pesanan
     $userQuery = $connection->prepare("SELECT * FROM pesanan where code = ?");
     $userQuery->execute(array($code));


     if($userQuery->rowCount() != 0) {
     
        $response['status'] = false;
        $response['message'] = "sudah memesan";
    }else{
        $insertpesanan = 'INSERT INTO pesanan (user_id, code, datetime, subtotal, total_harga,order_prov,order_kab,
        order_kec, order_kodepos, order_address, order_kurir, order_layanan, status_bayar, status, create_at) 
        values (:user_id,:code,:datetime,:subtotal,:total_harga,:order_prov,:order_kab,:order_kec, :order_kodepos, 
        :order_address, :order_kurir, :order_layanan, :status_bayar, :status, :create_at)';
        $statment = $connection->prepare($insertpesanan);


        try{
            $statment->execute([
                ':user_id'      => $user_id,
                ':code'         => "CDR-".str_replace("-", "", date("d-m-Y")),
                ':datetime'     => str_replace("-", "", date("d-m-Y")),
                ':subtotal'     => $subtotal,
                ':total_harga'  => $total_harga,
                ':order_prov'   => $order_prov,
                ':order_kab'    => $order_kab,
                ':order_kec'    => $order_kec,
                ':order_kodepos'=> $order_kodepos,
                ':order_address'=> $order_address,
                ':order_kurir'  => $order_kurir,
                ':order_layanan'=> $order_layanan,
                ':status_bayar' => "pending",
                ':status'       => "pembayaran pending",
                ':create_at'    => str_replace("-", "", date("d-m-Y")),
            ]);

        $response['status'] = true;
        $response['message'] = "Berhasil Memesan!";
        $response['data'] =[
            'order_id'      => $order_id,
            'user_id'       => $user_id,
            'total_harga'   => $total_harga
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
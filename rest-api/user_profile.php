<?php
include 'connection.php';


$koneksi = mysqli_connect("localhost", "root", "", "hasilbumi");

// if($_SERVER['REQUEST_METHOD'] === 'GET'){
//     $users_id = $_GET ['users_id'];
    
//     $sql = "SELECT * FROM user_profile WHERE users_id = $users_id";
//     $query = mysqli_query($koneksi, $sql);
//     $array_data = array();
//     while($data = mysqli_fetch_assoc($query)){
//         $array_data[] = $data;
//     }

//     echo json_encode($array_data);
// }else
 if($_POST){
    $users_id      = $_POST['users_id'] ?? '';
    $fullname      = $_POST['fullname'] ?? '';
    $telp          = $_POST['telp'] ?? '';
    $prov          = $_POST['prov'] ?? '';
    $kab           = $_POST['kab'] ?? '';
    $kec           = $_POST['kec'] ?? '';
    $kodepos       = $_POST['kodepos'] ?? '';
    $address       = $_POST['address'] ?? '';
    $create_at     = $_POST['create_at'] ?? '';
  
    $response = [];

    //cek user
    $userQuery = $connection->prepare("SELECT * FROM user_profile where fullname = ?");
    $userQuery->execute(array($fullname));
    $query = $userQuery->fetch();
    
   
    if($userQuery->rowCount() != 0) {
        $response['status'] = false;
        $response['message'] = "data sudah terdaftar!";
    }else{
        $insertAccount = 'INSERT INTO user_profile (users_id, fullname, telp, prov, kab, kec, kodepos, address, create_at) 
        values (:users_id,:fullname,:telp,:prov,:kab,:kec,:kodepos,:address, :create_at)';
        $statment = $connection->prepare($insertAccount);

        try{
            $statment->execute([
            ':users_id'    => $users_id,
            ':fullname'    => $fullname,
            ':telp'        => $telp,
            ':prov'        => $prov,
            ':kab'         => $kab,
            ':kec'         => $kec,
            ':kodepos'     => $kodepos,
            ':address'     => $address,
            ':create_at'   => str_replace("-", "", date("Y-m-d"))
            ]);    

        $response['status'] = true;
        $response['message'] = "Berhasil menyimpan data";
        $response['data'] = [
            'user_id'     => $users_id,
            'fullname'    => $fullname,
            'telp'        => $telp,
            'prov'        => $prov,
            'kab'         => $kab,
            'kec'         => $kec,
            'kodepos'     => $kodepos,
            'address'     => $address
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
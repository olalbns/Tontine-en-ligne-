<?php

//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

$id_rec = $_GET['id_rec'];
$stmt = $con->prepare("SELECT * FROM recompense WHERE id_rec = :id_rec");
$stmt->bindParam(':id_rec', $id_rec);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$id_uti = $_COOKIE['User_id'];
//  $User_id= $userData["id_EC"];


$response = [
    'status' => 'success',
    'data' => [
        'recMod' => $userData,
        'user'=> [
          'id_uti' => $id_uti
        ] 
    ]
];

echo json_encode($response);

?>
<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_COOKIE['User_id'])) {


$id_uti = $_COOKIE['User_id'];
$stmt = $con->prepare("SELECT * FROM notification WHERE id_uti = :id_uti ORDER BY date DESC");
$stmt->bindParam(':id_uti', $id_uti);
$stmt->execute();
$userData = $stmt->fetchALL(PDO::FETCH_ASSOC);


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
}
?>
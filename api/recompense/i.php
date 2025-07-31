<?php

//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

$stmt = $con->prepare("SELECT * FROM recompense LIMIT 4");
$stmt->execute();
$userData = $stmt->fetchAll(PDO::FETCH_ASSOC);


$response = [
    'status' => 'success',
    'data' => [
        'recMod' => $userData
        
    ]
];

echo json_encode($response);

?>
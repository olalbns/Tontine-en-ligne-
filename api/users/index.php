<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
$id = $_COOKIE["User_id"];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $con->prepare("SELECT u.*, COALESCE(SUM(i.balance_uti), 0) AS total_balance 
                      FROM utilisateurs u
                      LEFT JOIN infocoti i ON u.id_uti = i.id_uti
                      WHERE u.id_uti = :id_uti
                      GROUP BY u.id_uti");
    $stmt->bindParam(':id_uti', $id);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Remplacer balance_uti par celui de infocoti
    if (isset($userData['infocoti_balance'])) {
        $userData['balance_uti'] = $userData['infocoti_balance'];
    }
    unset($userData['infocoti_balance']); // Nettoyer les données

    $id_rec = $userData["id_rec"];
    $stmt = $con->prepare("SELECT * FROM recompense WHERE id_rec = $id_rec");
    $stmt->execute();
    $userRec = $stmt->fetch(PDO::FETCH_ASSOC);

    $response = [
        'status' => 'success',
        'data' => [
            'user' => $userData,
            'rec' => $userRec
        ]
    ];

    echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}

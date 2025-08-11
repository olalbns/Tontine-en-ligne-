<?php
header('Content-Type: application/json');

// Connexion à la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

try {
    if (!isset($_COOKIE["User_id"]) || !is_numeric($_COOKIE["User_id"])) {
        throw new Exception("Identifiant utilisateur invalide");
    }

    $id = (int)$_COOKIE["User_id"];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
        exit;
    }

    $con->beginTransaction();

    // Requête utilisateur
    $stmt = $con->prepare("SELECT u.*, COALESCE(SUM(i.balance_uti), 0) AS total_balance 
                          FROM utilisateurs u
                          LEFT JOIN infocoti i ON u.id_uti = i.id_uti
                          WHERE u.id_uti = :id_uti
                          GROUP BY u.id_uti");
    $stmt->bindParam(':id_uti', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception("Utilisateur non trouvé");
    }

    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Gestion du balance
    if (isset($userData['infocoti_balance'])) {
        $userData['balance_uti'] = $userData['infocoti_balance'];
        unset($userData['infocoti_balance']);
    }

    // Requête récompense
    $stmt = $con->prepare("SELECT * FROM recompense WHERE id_rec = :id_rec");
    $stmt->bindParam(':id_rec', $userData['id_rec'], PDO::PARAM_INT);
    $stmt->execute();
    $userRec = $stmt->fetch(PDO::FETCH_ASSOC);

    $con->commit();

    $response = [
        'status' => 'success',
        'data' => [
            'user' => $userData,
            'rec' => $userRec ?? null
        ]
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    $con->rollBack();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erreur de base de données', 'debug' => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
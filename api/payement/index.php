<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $type = $input['type'] ?? null;
    $details = $input['details'] ?? [];

    if (!$type || empty($details)) {
        echo json_encode(['status' => 'error', 'message' => 'Champs manquants']);
        exit;
    }

    $id_uti = $_COOKIE['User_id'] ?? null;
    if (!$id_uti) {
        echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
        exit;
    }

    // Enregistre dans la table 'payement' (adapte le nom de la table et des champs si besoin)
    $stmt = $con->prepare("INSERT INTO method_payement (id_uti, types, details) VALUES (?, ?, ?)");
    $success = $stmt->execute([
        $id_uti,
        $type,
        json_encode($details) // Stocke le tableau en JSON
    ]);

    if ($success) {
         //enregister une notification
            $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, date) 
                                           VALUES (:id_uti, :id_rec, :message, NOW())");
            $notification->bindParam(':id_uti', $id_uti);
            $notification->bindParam(':id_rec', $id_rec);
            $notification->bindParam(':message', $message);
            $message = "Nouvelle méthode de paiement ajouter.";
            $notification->execute();

        echo json_encode(['status' => 'success', 'message' => 'Méthode enregistrée']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_uti = $_COOKIE['User_id'] ?? null;
    if (!$id_uti) {
        echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
        exit;
    }

    $stmt = $con->prepare("SELECT id_method, types, details FROM method_payement WHERE id_uti = ?");
    $stmt->execute([$id_uti]);
    $methods = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Décoder le champ details (JSON)
    foreach ($methods as &$method) {
        $method['details'] = json_decode($method['details'], true);
    }

    echo json_encode(['status' => 'success', 'data' => $methods]);
    exit;
}

?>
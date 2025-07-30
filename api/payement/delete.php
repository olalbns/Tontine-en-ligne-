<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_method = intval($input['id_method']);

    // Vérifier si l'utilisateur est connecté
    $user_id = $_COOKIE['User_id'] ?? null;
    if (!$user_id) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
        exit;   
    }
}

    // Supprimer la méthode de paiement
    $stmt = $con->prepare("DELETE FROM method_payement WHERE id_method = ? AND id_uti = ?");
    $success = $stmt->execute([$id_method, $user_id]);

    if ($success) {

         //enregister une notification
            $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, date) 
                                           VALUES (:id_uti, :id_rec, :message, NOW())");
            $notification->bindParam(':id_uti', $user_id);
            $notification->bindParam(':id_rec', $id_rec);
            $notification->bindParam(':message', $message);
            $message = "Un moyen de paiement a été supprimé";
            $notification->execute();

        echo json_encode(['status' => 'success', 'message' => 'Méthode supprimée : ' . $id_method]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la suppression']);
    }
    exit;


?>
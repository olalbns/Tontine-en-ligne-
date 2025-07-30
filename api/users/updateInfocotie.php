<?php
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['montant'], $input['dateLimite'], $input['id_uti'], $input['types'], $input['id_rec'], $input['id_info'])) {
        $montant = $input['montant'];
        $dateLimite = $input['dateLimite'];
        $id_uti = $input['id_uti'];
        $type = $input['types'];
        $id_rec = $input['id_rec'];
        $id_info = $input['id_info'];

        $repas = $con->prepare("UPDATE infocoti SET types = :types, montantChoisie = :montantChoisie, date_limite = :date_limite WHERE id_uti = :id_uti AND id_rec = :id_rec AND id_info = :id_info");
        if (
            $req = $repas->execute(array(
                'id_uti' => $id_uti,
                'id_rec' => $id_rec,
                'types' => $type,
                'montantChoisie' => $montant,
                'date_limite' => $dateLimite,
                'id_info' => $id_info
            ))
        ) {
            $response = [
                'status' => 'success',
                'data' => [
                    'message' => "Modification effectué avec success",
                ]
            ];


            //enregister une notification
            $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, date) 
                                           VALUES (:id_uti, :id_rec, :message, NOW())");
            $notification->bindParam(':id_uti', $id_uti);
            $notification->bindParam(':id_rec', $id_rec);
            $notification->bindParam(':message', $message);
            $message = "Modification du mode de cotisation pour la récompense";
            $notification->execute();

            echo json_encode($response);
        }
    } else {
        echo json_encode(value: "Veuillez remplir tout les champs");
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}
?>
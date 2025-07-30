<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['phone'], $input['full_name'], $input['email'], $input['img'])) {
        if (empty($input['img'])){
             echo json_encode("Probleme de modification de l'image");
        }
        $id = $input['id_uti'];
        $email = $input['email'];
        $phone = $input['phone'];
        $img = $input['img'];
        // Séparation du nom complet
        $nameParts = explode(' ', $input['full_name'], 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $repas = $con->prepare("UPDATE utilisateurs SET nom_uti = :firstName, prenom_uti= :lastName, num_uti= :phone, email_uti= :email, img_uti= :img WHERE id_uti = :id");
        if (
            $repas->execute([
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':phone' => $phone,
                ':email' => $email,
                ':img' => $img,
                ':id' => $id
            ])
        ) {
             //enregister une notification
            $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, date) 
                                           VALUES (:id_uti, :id_rec, :message, NOW())");
            $notification->bindParam(':id_uti', $id);
            $notification->bindParam(':id_rec', $id_rec);
            $notification->bindParam(':message', $message);
            $message = "Profile mis a jour";
            $notification->execute();

            echo json_encode("Modification effectué");
        }
        // echo json_encode("Modification effectué");

    } else {
        echo json_encode(value: "Veuillez remplir tout les champs");
    }


    //   $response = [
//         'status' => 'success',
//         'data' => [
//             'user' => $userData,
//             'rec' => $userRec
//         ]
//     ];

    //     echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}
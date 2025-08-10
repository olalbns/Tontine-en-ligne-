<?php
include "../../../Admin/app/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!empty($input['nom_uti']) && !empty($input['prenom_uti']) && !empty($input['email_uti']) && !empty($input['num_uti']) && isset($input['password'])) {
        $stmt = $con->prepare("INSERT INTO utilisateurs (nom_uti, prenom_uti, email_uti, num_uti, password, date_uti) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt->execute([$input['nom_uti'], $input['prenom_uti'], $input['email_uti'], $input['num_uti'], password_hash($input['password'], PASSWORD_DEFAULT)])) {
            echo json_encode(["status" => "success", "message" => "Utilisateur ajouté avec succès"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont requis"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
}

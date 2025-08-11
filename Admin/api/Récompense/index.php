<?php 
include "../../../Admin/app/db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!empty($input['nom_recompense']) && !empty($input['description_recompense']) && !empty($input['points_recompense'])) {
        $stmt = $con->prepare("INSERT INTO recompenses (nom_recompense, description_recompense, points_recompense, date_recompense) VALUES (?, ?, ?, NOW())");
        if ($stmt->execute([$input['nom_recompense'], $input['description_recompense'], $input['points_recompense']])) {
            echo json_encode(["status" => "success", "message" => "Récompense ajoutée avec succès"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont requis"]);
    }
} else 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $con->prepare("SELECT * FROM recompense");
    $stmt->execute();
    $recompenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($recompenses) {
        echo json_encode(["status" => "success", "data" => $recompenses]);
    } else {
        echo json_encode(["status" => "error", "message" => "Aucune récompense trouvée"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
}
?>
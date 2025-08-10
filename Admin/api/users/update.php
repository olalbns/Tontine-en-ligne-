<?php 
include "../../../Admin/app/db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_uti'], $_POST['nom_uti'], $_POST['prenom_uti'], $_POST['email_uti'], $_POST['num_uti'])) {
        $id = $_POST['id_uti'];
        $nom = $_POST['nom_uti'];
        $prenom = $_POST['prenom_uti'];
        $email = $_POST['email_uti'];
        $num = $_POST['num_uti'];

    // Update user in the database
    $stmt = $con->prepare("UPDATE utilisateurs SET nom_uti = ?, prenom_uti = ?, email_uti = ?, num_uti = ? WHERE id_uti = ?");
    if ($stmt->execute([$nom, $prenom, $email, $num, $id])) {
        echo json_encode([
            "status"=> "success",
            "message" => "Utilisateur mis à jour avec succès."]);
    } else {
        echo json_encode([
            "status"=> "error",
            "message" => "Erreur lors de la mise à jour de l'utilisateur."]);
    }
} else {
    echo json_encode([
        "status"=> "error",
        "message" => "Données manquantes."
    ]);

}
} else {
    echo json_encode([
        "status"=> "error",
        "message" => "Méthode non autorisée1."]);

}
?>
<?php 
include "../../../Admin/app/db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_uti'])) {
       $stmt = $con->prepare("DELETE FROM utilisateurs WHERE id_uti = ?");
       if ($stmt->execute([$_POST['id_uti']])) {
           echo json_encode([
               "status" => "success",
               "message" => "Utilisateur supprimé avec succès."
           ]);
       } else {
           echo json_encode([
               "status" => "error",
               "message" => "Erreur lors de la suppression de l'utilisateur."
           ]);
       }
    }else{
        echo json_encode([
            "status" => "error",
            "message" => "ID utilisateur manquant."
        ]);
    }
}
?>
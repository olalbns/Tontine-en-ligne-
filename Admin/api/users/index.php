<?php
include "../../../Admin/app/db.php";
// Récupérer tous les utilisateurs
$stmt = $con->prepare("SELECT * FROM utilisateurs ORDER BY date_uti DESC");
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode([
    'status' => 'success',
    'data' => $utilisateurs
]);
?>
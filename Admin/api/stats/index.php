<?php
include "../../../Admin/app/db.php";
//Récuperer le nombre des utilisateurs 
$stmt = $con->prepare("SELECT COUNT(*) as total_users FROM utilisateurs"); 
$stmt->execute();
$total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
//Récuperer le nombre des cotisations actives
$stmt = $con->prepare("SELECT COUNT(*) as total_cotisations FROM infocoti");
$stmt->execute();
$total_cotisations = $stmt->fetch(PDO::FETCH_ASSOC)['total_cotisations'];
// //Récuperer le nombre des récompenses distribuées
// $stmt = $con->prepare("SELECT COUNT(*) as total_recompenses FROM recompense WHERE statut = 'distribuée'");
// $stmt->execute();
// $total_recompenses = $stmt->fetch(PDO::FETCH_ASSOC)['total_recompenses'];
//Récuperer le montant total des cotisations
$stmt = $con->prepare("SELECT SUM(montant) as total_montant FROM cotisation");
$stmt->execute();
$total_montant = $stmt->fetch(PDO::FETCH_ASSOC)['total_montant'];
//Récuperer le nombre des cotisations en attente
$stmt = $con->prepare("SELECT COUNT(*) as total_en_attente FROM echeance WHERE statut = 'en attente'");
$stmt->execute();
$total_en_attente = $stmt->fetch(PDO::FETCH_ASSOC)['total_en_attente'];
//Récuperer le nombre des cotisations manquées
$stmt = $con->prepare("SELECT COUNT(*) as total_manquees FROM echeance WHERE statut = 'manquée'");
$stmt->execute();
$total_manquees = $stmt->fetch(PDO::FETCH_ASSOC)['total_manquees'];
//Récuperer le nombre des cotisations réussies
$stmt = $con->prepare("SELECT COUNT(*) as total_reussies FROM echeance WHERE statut = 'terminé'");
$stmt->execute();
$total_reussies = $stmt->fetch(PDO::FETCH_ASSOC)['total_reussies'];
//Récuperer le nombre des récompenses disponibles
$stmt = $con->prepare("SELECT COUNT(*) as total_recompenses FROM recompense");
$stmt->execute();
$total_recompenses = $stmt->fetch(PDO::FETCH_ASSOC)['total_recompenses'];
$resultats = [
    'total_users' => $total_users,
    'total_cotisations' => $total_cotisations,
    'total_montant' => $total_montant,
    'total_en_attente' => $total_en_attente,
    'total_manquees' => $total_manquees,
    'total_reussies' => $total_reussies,
    'total_recompenses' => $total_recompenses,
    // 'total_recompenses' => $total_recompenses, 
];
echo json_encode([
    'status' => 'success',
    'data' =>[ $resultats]
]);
?>
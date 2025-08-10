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
/////////////////////////////////////////////
header('Content-Type: application/json');

// Requête SQL
$sql = "
SELECT 
    n.id_notif,
    n.id_uti,
    u.nom_uti AS nom,
    u.prenom_uti AS prenom,
    n.message,
    n.id_rec,
    r.prix_rec AS prix_recompense,
    c.montant AS montant_cotisation,
    ic.montantChoisie AS montant_echeance,
    n.date,
    e.statut AS statut_echeance,
    e.date_cotisation,
    e.date_échéance AS date_echeance
FROM notification n
LEFT JOIN utilisateurs u ON u.id_uti = n.id_uti
LEFT JOIN recompense r  ON r.id_rec = n.id_rec
LEFT JOIN cotisation c ON c.id_rec = n.id_rec AND c.id_uti = n.id_uti
LEFT JOIN infocoti ic ON ic.id_rec = n.id_rec AND ic.id_uti = n.id_uti
LEFT JOIN echeance e   ON e.id_rec = n.id_rec AND e.id_uti = n.id_uti
ORDER BY n.date DESC
";
$stmt = $con->prepare($sql);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mapping message → action + type
$mappingActions = [
    'Félicitations ! Vous avez terminé toutes les cotisations' => ['Cotisation terminée', 'cotisation'],
    'Votre cotisation est en retard' => ['Cotisation en retard', 'cotisation'],
    'Nouvelle échéance programmée' => ['Nouvelle échéance', 'echeance'],
    'Nouvelle récompense ajoutée' => ['Récompense ajoutée', 'recompense'],
    'Mise à jour de la récompense' => ['Récompense mise à jour', 'recompense'],
    'Nouvelle méthode de paiement ajouter' => ['Moyen de paiement ajouté', 'autre'],
    'Un moyen de paiement a été supprimé' => ['Moyen de paiement supprimé', 'autre'],
    'Profile mis a jour' => ['Profil mis à jour', 'autre'],
    'Vous avez reçu un paiement' => ['Paiement reçu', 'autre']
];

$tableauNotifications = [];

foreach ($notifications as $notif) {
    $action = $notif['message'];
    $type = 'autre';

    foreach ($mappingActions as $pattern => $infos) {
        if (stripos($notif['message'], $pattern) !== false) {
            $action = $infos[0];
            $type = $infos[1];
            break;
        }
    }

    $montant = '';
    if ($type === 'recompense' && $notif['prix_recompense'] !== null) {
        $montant = $notif['prix_recompense'];
    } elseif ($type === 'cotisation' && $notif['montant_cotisation'] !== null) {
        $montant = $notif['montant_cotisation'];
    } elseif ($type === 'echeance' && $notif['montant_echeance'] !== null) {
        $montant = $notif['montant_echeance'];
    }

    $dateAffichee = $notif['date_cotisation'] 
                  ?: ($notif['date_echeance'] ?: $notif['date']);

    $statut = $notif['statut_echeance'] ?: '—';

    $tableauNotifications[] = [
        'Utilisateur' => trim($notif['nom'] . ' ' . $notif['prenom']),
        'Action'      => $action,
        'Montant'     => $montant,
        'Date'        => $dateAffichee,
        'Statut'      => $statut
    ];
}

///////////////////////////////////////////////////////////////////////////////

echo json_encode([
    'status' => 'success',
    'data' =>[ $resultats],
    'activity'=> $tableauNotifications
]);
?>
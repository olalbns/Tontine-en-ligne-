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
$sql = "
SELECT 
    n.id_notif,
    n.id_uti,
    u.nom_uti AS nom,
    u.prenom_uti AS prenom,
    n.message,
    n.id_rec,
    CASE 
        WHEN n.type = 'recompense' THEN r.prix_rec 
        WHEN n.type = 'cotisation' THEN c.montant
        WHEN n.type = 'echeance' THEN ic.montantChoisie
        ELSE NULL 
    END AS montant,
    n.date,
    n.type,
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

// Tableau de correspondance message → action
$mappingActions = [
    'Félicitations ! Vous avez terminé toutes les cotisations' => 'Cotisation terminée',
    'Nouvelle récompense ajoutée' => 'Récompense ajoutée',
    'Mise à jour de la récompense' => 'Récompense mise à jour',
    'Nouvelle méthode de paiement ajouter' => 'Moyen de paiement ajouté',
    'Un moyen de paiement a été supprimé' => 'Moyen de paiement supprimé',
    'Profile mis a jour' => 'Profil mis à jour',
    'Nouvelle échéance programmée' => 'Nouvelle échéance',
    'Votre cotisation est en retard' => 'Cotisation en retard',
    'Vous avez reçu un paiement' => 'Paiement reçu'
];

// Tableau final
$tableauNotifications = [];

foreach ($notifications as $notif) {
    // Détermination de l'action
    $action = $notif['message'];
    foreach ($mappingActions as $pattern => $label) {
        if (stripos($notif['message'], $pattern) !== false) {
            $action = $label;
            break;
        }
    }

    // Date affichée
    $dateAffichee = $notif['date_cotisation'] 
                  ?: ($notif['date_echeance'] ?: $notif['date']);

    // Statut
    $statut = $notif['statut_echeance'] ?: '—';

    // Montant
    $montant = ($notif['montant'] !== null) ? $notif['montant'] : '1';

    $tableauNotifications[] = [
        'Utilisateur' => trim($notif['nom'] . ' ' . $notif['prenom']),
        'Action'      => $action,
        'Montant'     => $montant,
        'Date'        => $dateAffichee,
        'Statut'      => $statut
    ];
}

// Affichage HTML
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Utilisateur</th><th>Action</th><th>Montant</th><th>Date</th><th>Statut</th></tr>";
foreach ($tableauNotifications as $ligne) {
    echo "<tr>";
    echo "<td>{$ligne['Utilisateur']}</td>";
    echo "<td>{$ligne['Action']}</td>";
    echo "<td>{$ligne['Montant']}</td>";
    echo "<td>{$ligne['Date']}</td>";
    echo "<td>{$ligne['Statut']}</td>";
    echo "</tr>";
}
echo "</table>";



///////////////////////////////////////////////////////////////////////////////

echo json_encode([
    'status' => 'success',
    'data' =>[ $resultats]
]);
?>
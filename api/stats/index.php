<?php
// Connexion à la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

if (!isset($_COOKIE['User_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'User_id cookie not set']);
    exit;
}

$id_uti = $_COOKIE['User_id'] ?? null;

if (!$id_uti) {
    http_response_code(400);
    echo json_encode(['error' => 'ID utilisateur manquant.']);
    exit;
}
// Récupérer toutes les infos de cotisation de l'utilisateur
$stmt = $con->prepare("SELECT * FROM infocoti WHERE id_uti = ?");
$stmt->execute([$id_uti]);
$cotisations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resultats = [];
$today = new DateTime(); // Date actuelle pour comparaison

foreach ($cotisations as $coti) {
    $balance_uti = floatval($coti['balance_uti']);
    $id_rec = intval($coti['id_rec']);
    $type_cotisation = $coti['types']; // journalier/hebdomadaire/mensuel
    $date_limite = new DateTime($coti['date_limite']);

    // 1. Vérifier et mettre à jour les échéances passées
    $stmt = $con->prepare("SELECT id_eche, date_échéance FROM echeance 
                          WHERE id_uti = ? AND id_rec = ? AND statut = 'en attente' 
                          AND date_échéance < ? 
                          ORDER BY date_échéance ASC");
    $stmt->execute([$id_uti, $id_rec, $today->format('Y-m-d')]);
    $echeances_passees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($echeances_passees as $echeance) {
        // Marquer l'échéance comme manquée
        $stmt_update = $con->prepare("UPDATE echeance SET statut = 'manquée' WHERE id_eche = ?");
        $stmt_update->execute([$echeance['id_eche']]);

        // Enregistrer la notification de type warning
        $message = "Échéance manquée pour le " . (new DateTime($echeance['date_échéance']))->format('d/m/Y');
        $stmt_notif = $con->prepare("INSERT INTO notification 
                                    (id_uti, id_rec, message, type, date) 
                                    VALUES (?, ?, ?, 'warning', NOW())");
        $stmt_notif->execute([$id_uti, $id_rec, $message]);

        // Générer une nouvelle échéance si la date limite n'est pas atteinte
        $echeance_date = new DateTime($echeance['date_échéance']);
        $next_date = clone $echeance_date;

        switch ($type_cotisation) {
            case 'journalier': $next_date->modify('+1 day'); break;
            case 'hebdomadaire': $next_date->modify('+1 week'); break;
            case 'mensuel': $next_date->modify('+1 month'); break;
        }

        if ($next_date <= $date_limite) {
            $stmt_insert = $con->prepare("INSERT INTO echeance 
                                        (id_uti, id_rec, date_échéance, type, statut) 
                                        VALUES (?, ?, ?, ?, 'en attente')");
            $stmt_insert->execute([$id_uti, $id_rec, $next_date->format('Y-m-d'), $type_cotisation]);
            
            // Enregistrer la notification pour la nouvelle échéance
            $message = "Nouvelle échéance programmée pour le " . $next_date->format('d/m/Y');
            $stmt_notif = $con->prepare("INSERT INTO notification 
                                        (id_uti, id_rec, message, type, date) 
                                        VALUES (?, ?, ?, 'info', NOW())");
            $stmt_notif->execute([$id_uti, $id_rec, $message]);
        }
    }

    // 2. Récupérer les infos de la récompense
    $stmt = $con->prepare("SELECT * FROM recompense WHERE id_rec = ?");
    $stmt->execute([$id_rec]);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Récupérer la prochaine échéance valide
    $stmt = $con->prepare("SELECT date_échéance FROM echeance 
                          WHERE id_uti = ? AND id_rec = ? AND statut = 'en attente' 
                          ORDER BY date_échéance ASC LIMIT 1");
    $stmt->execute([$id_uti, $id_rec]);
    $echeance = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $date_echeance = $echeance ? $echeance['date_échéance'] : null;

    if ($rec) {
        $prix_rec = floatval($rec['prix_rec']);
        $nom_rec = $rec['nom_rec'];
        $Progre_non = $prix_rec - $balance_uti; // Montant restant à payer
        $Pourcentage = $prix_rec > 0 ? min(($balance_uti * 100 / $prix_rec), 100) : 0;

        $resultats[] = [
            'prix_rec' => $prix_rec,
            'balance_uti' => $balance_uti,
            'Progre_non' => max($Progre_non, 0), // Ne pas montrer de valeurs négatives
            'Pourcentage' => $Pourcentage,
            'nom_rec' => $nom_rec,
            'date_echeance' => $date_echeance,
            'statut_echeance' => $echeance ? 'en attente' : 'terminée'
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'data' => $resultats
]);

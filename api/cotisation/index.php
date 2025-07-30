<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_rec = intval($input['id_rec']);
    $id_methode = intval($input['id_methode']);
    $montant = floatval($input['montant']);
    $user_id = $_COOKIE['User_id'];

    // 1. Récupération de l'échéance en attente et du prix total de la récompense
    $stmt = $con->prepare("SELECT e.id_eche, e.date_échéance, e.type, 
                                  i.date_limite, i.montantChoisie, i.balance_uti,
                                  r.prix_rec
                          FROM echeance e
                          JOIN infocoti i ON e.id_rec = i.id_rec AND e.id_uti = i.id_uti
                          JOIN recompense r ON e.id_rec = r.id_rec
                          WHERE e.id_uti = ? AND e.statut = 'en attente' AND e.id_rec = ?
                          ORDER BY e.date_échéance ASC
                          LIMIT 1");
    $stmt->execute([$user_id, $id_rec]);
    $echeance = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$echeance) {
        echo json_encode(["success" => false, "message" => "Aucune échéance en attente trouvée pour cette récompense ou utilisateur."]);
        exit;
    }

    $echeance_id = $echeance['id_eche'];
    $type_echeance = $echeance['type'];
    $currentDate = new DateTime($echeance['date_échéance']);
    $date_limite = new DateTime($echeance['date_limite']);
    $montant_attendu = floatval($echeance['montantChoisie']);
    $prix_total = floatval($echeance['prix_rec']);
    $current_balance = floatval($echeance['balance_uti']);

    // Calcul du nouveau solde après cette cotisation
    $nouveau_solde = $current_balance + $montant;

    // 2. Mise à jour de l'échéance actuelle
    $stmt = $con->prepare("UPDATE echeance
                         SET statut = 'cotisée', date_cotisation = NOW()
                         WHERE id_eche = ?");
    $stmt->execute([$echeance_id]);

    // 3. Vérification si le nouveau solde atteint ou dépasse le prix total
    $isLastEcheance = ($nouveau_solde >= $prix_total);

    if ($isLastEcheance) {
        // Marquer toutes les échéances restantes comme terminées
        $stmt_update_eche_final = $con->prepare("UPDATE echeance
                                               SET statut = 'terminé'
                                               WHERE id_uti = ? AND id_rec = ? AND statut = 'en attente'");
        $stmt_update_eche_final->execute([$user_id, $id_rec]);

        // Notification pour dernière échéance
        $message = "Félicitations ! Vous avez terminé toutes les cotisations pour cette récompense.";
        $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, type, date) 
                                     VALUES (?, ?, ?, ?, NOW())");
        $notification->execute([$user_id, $id_rec, $message, "success"]);
    } else {
        // Génération de la prochaine échéance seulement si pas terminé
        $nextDate = clone $currentDate;

        switch ($type_echeance) {
            case 'journalier': $nextDate->modify('+1 day'); break;
            case 'hebdomadaire': $nextDate->modify('+1 week'); break;
            case 'mensuel': $nextDate->modify('+1 month'); break;
        }

        // Vérification que la date ne dépasse pas la limite
        if ($nextDate <= $date_limite) {
            $stmt_next = $con->prepare("INSERT INTO echeance
                                      (id_uti, id_rec, date_échéance, statut, type)
                                      VALUES (?, ?, ?, 'en attente', ?)");
            $stmt_next->execute([
                $user_id, 
                $id_rec, 
                $nextDate->format('Y-m-d'), 
                $type_echeance
            ]);

            // Notification pour échéance suivante
            $message = "Prochaine échéance programmée pour le ".$nextDate->format('d/m/Y');
            $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, date) 
                                         VALUES (?, ?, ?, NOW())");
            $notification->execute([$user_id, $id_rec, $message]);
        }
    }

    // 4. Mise à jour du solde
    $stmt_update_balance = $con->prepare("UPDATE infocoti SET balance_uti = balance_uti + ? 
                                        WHERE id_uti = ? AND id_rec = ?");
    $stmt_update_balance->execute([$montant, $user_id, $id_rec]);

    // 5. Enregistrement de la cotisation
    $stmt2 = $con->prepare("INSERT INTO cotisation (id_uti, id_rec, id_method, montant, date)
                           VALUES (?, ?, ?, ?, NOW())");
    $stmt2->execute([$user_id, $id_rec, $id_methode, $montant]);

    echo json_encode([
        "success" => true,
        "next_echeance" => $isLastEcheance ? null : ($nextDate->format('Y-m-d') ?? null),
        "type" => $type_echeance,
        "message" => $isLastEcheance ? "Dernière cotisation effectuée" : "Cotisation enregistrée",
        "notification" => $message,
        "total_paid" => $nouveau_solde,
        "remaining" => max(0, $prix_total - $nouveau_solde)
    ]);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer l'ID utilisateur depuis le cookie
    $user_id = $_COOKIE['User_id'] ?? null;

    if (!$user_id) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'ID utilisateur manquant.']);
        exit;
    }

    // Récupérer les infos de cotisation de base
    $stmt = $con->prepare("SELECT * FROM infocoti WHERE id_uti = ?");
    $stmt->execute([$user_id]);
    $infocoti = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$infocoti) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Aucune information de cotisation trouvée pour cet utilisateur.']);
        exit;
    }

    // Requête améliorée pour récupérer les cotisations avec le nom de la récompense et le type de paiement
    $stmt = $con->prepare("
        SELECT c.*, r.nom_rec, e.statut, m.types as method_payement
        FROM cotisation c
        JOIN recompense r ON c.id_rec = r.id_rec
        JOIN method_payement m ON c.id_method = m.id_method
        LEFT JOIN (
            SELECT ee1.id_uti, ee1.id_rec, ee1.statut
            FROM echeance ee1
            INNER JOIN (
                SELECT id_uti, id_rec, MAX(date_échéance) as max_date
                FROM echeance
                WHERE id_uti = ?
                GROUP BY id_uti, id_rec
            ) ee2 ON ee1.id_uti = ee2.id_uti AND ee1.id_rec = ee2.id_rec AND ee1.date_échéance = ee2.max_date
        ) e ON e.id_uti = c.id_uti AND e.id_rec = c.id_rec
        WHERE c.id_uti = ?
        ORDER BY c.id_coti ASC
    ");
    $stmt->execute([$user_id, $user_id]);

    $cotisations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formater les données de retour
    $result = [
        'status' => 'success',
        'data' => array_map(function($cotisation) {
            return [
                'id_coti' => $cotisation['id_coti'],
                'montant' => $cotisation['montant'],
                'date' => $cotisation['date'],
                'nom_recompense' => $cotisation['nom_rec'],
                'statut' => $cotisation['statut'],
                'methode_paiement' => $cotisation['method_payement'] // Ajout du type de paiement
            ];
        }, $cotisations),
        'infocoti' => $infocoti
    ];

    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    // Récupérer l'ID utilisateur depuis le cookie
    $user_id = $_COOKIE['User_id'] ?? null;

    if (!$user_id) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'ID utilisateur manquant.']);
        exit;
    }

    // Récupérer les cotisations de l'utilisateur avec le nom de la récompense et récuperer aussi le montan a cotiser par periode dans infocotie

    $stmt = $con->prepare("
        SELECT c.*, r.nom_rec 
        FROM cotisation c
        JOIN recompense r ON c.id_rec = r.id_rec
        WHERE c.id_uti = ? 
        ORDER BY c.id_coti ASC
        LIMIT 4
    ");
    $stmt->execute([$user_id]);
    $cotisations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ajouter le nom de la récompense sous le nom 'nom_recompense' pour chaque cotisation
    foreach ($cotisations as &$cotisation) {
        $cotisation['nom_recompense'] = $cotisation['nom_rec'];
    }

    echo json_encode([
        'status' => 'success',
        'data' => $cotisations,
    ]);
    exit;
}

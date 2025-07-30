<?php
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_GET['id_rec']) && isset($_GET['id_info'])) {
    $id_rec = $_GET['id_rec'];
    $id_info = $_GET['id_info'];
    $id_uti = $_COOKIE['User_id'] ?? null;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!$id_uti) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'User_id Cookie inexistant']);
            exit;
        }

        $stmt = $con->prepare("SELECT id_rec FROM infocoti WHERE id_info = :id_info AND id_uti = :id_uti");
$stmt->bindParam(':id_uti', $id_uti);
$stmt->bindParam(':id_info', $id_info);
$stmt->execute();
$old_id_rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // Met à jour la récompense choisie dans la table infocoti
        $up_info = $con->prepare("UPDATE infocoti SET id_rec = :id_rec WHERE id_info = :id_info AND id_uti = :id_uti");
        $success = $up_info->execute([
            'id_rec' => $id_rec,
            'id_info' => $id_info,
            'id_uti' => $id_uti
        ]);

        if (!$success) {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la modification de la récompense']);
            exit;
        }

        // Récupère la ligne modifiée pour recalculer la date limite
        $stmt = $con->prepare("SELECT types, montantChoisie FROM infocoti WHERE id_info = :id_info AND id_uti = :id_uti");
        $stmt->execute([
            'id_info' => $id_info,
            'id_uti' => $id_uti
        ]);
        $infocoti = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$infocoti) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Cotisation non trouvée']);
            exit;
        }

        $types = $infocoti['types'] ?? null;
        $montant = (float) ($infocoti['montantChoisie'] ?? 0);

        // Récupère le prix de la récompense
        $stmt = $con->prepare("SELECT prix_rec FROM recompense WHERE id_rec = :id_rec");
        $stmt->bindParam(':id_rec', $id_rec);
        $stmt->execute();
        $prix_rec = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$prix_rec) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Récompense non trouvée']);
            exit;
        }

        $total = (float) ($prix_rec['prix_rec'] ?? 0);

        if ($montant <= 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Le montant par période est invalide.',
                'date_limite' => '-'
            ]);
            exit;
        }

        // Calcul du nombre de périodes
        $nbPeriodes = (int) ceil($total / $montant);

        // Date de départ
        $date = new DateTime();

        if ($types === 'journalier') {
            $date->modify("+{$nbPeriodes} days");
        } elseif ($types === 'hebdomadaire') {
            $date->modify('+' . (7 * $nbPeriodes) . ' days');
        } elseif ($types === 'mensuel') {
            $date->modify("+{$nbPeriodes} months");
        } else {
            echo json_encode([
                'status' => 'warning',
                'message' => 'Type de cotisation inconnu.'
            ]);
            exit;
        }

        setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            $date->getTimezone()->getName(),
            IntlDateFormatter::GREGORIAN,
            'EEEE dd MMMM yyyy'
        );
        $date_limite = ucwords($formatter->format($date));

       
        // Met à jour la date limite dans la ligne modifiée
        $up_date = $con->prepare("UPDATE infocoti SET date_limite = :date_limite WHERE id_info = :id_info AND id_uti = :id_uti");
        $success_date = $up_date->execute([
            'date_limite' => $date->format('Y-m-d H:i:s'),
            'id_info' => $id_info,
            'id_uti' => $id_uti
        ]);

        $up_date = $con->prepare("UPDATE echeance 
                         SET id_rec = :id_rec 
                         WHERE id_rec = :old_id_rec 
                         AND statut = :statut 
                         AND id_uti = :id_uti");

        $success_date = $up_date->execute([
            'id_rec' => $id_rec,  // Le nouvel ID de récompense
            'old_id_rec' => $old_id_rec['id_rec'], // L'ancien ID de récompense
            'statut' => "en attente",
            'id_uti' => $id_uti
        ]);



        if ($success_date) {
            $response = [
                'status' => 'success',
                'data' => [
                    'message' => "Récompense mise à jour avec succès",
                    'id_rec' => $id_rec,
                    'id_uti' => $id_uti,
                    'date_limite' => $date_limite
                ]
            ];

            //enregister une notification
            $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, date) 
                                           VALUES (:id_uti, :id_rec, :message, NOW())");
            $notification->bindParam(':id_uti', $id_uti);
            $notification->bindParam(':id_rec', $id_rec);
            $notification->bindParam(':message', $message);
            $message = "Mise à jour de la récompense";
            $notification->execute();

            echo json_encode($response);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Échec de la mise à jour de la date limite']);
        }
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    }
}
?>
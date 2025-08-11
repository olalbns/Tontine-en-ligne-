<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':

        // Sécurisation : récupération de l'ID utilisateur depuis le cookie (ou depuis $_POST si fourni)
        $id_uti = $_COOKIE['User_id'] ?? null;

        if (!$id_uti) {
            $stmt = $con->prepare("SELECT * FROM recompense");
            $stmt->execute();
            $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = [
                'status' => 'success',
                'data' => [
                    'recompense' => $userData,
                ]
            ];

            echo json_encode($response);
            break;
        }

        // Récupérer toutes les récompenses déjà associées à l'utilisateur
        $stmt = $con->prepare("SELECT id_rec FROM infocoti WHERE id_uti = :id_uti");
        $stmt->bindParam(':id_uti', $id_uti);
        $stmt->execute();
        $userRec = $stmt->fetchAll(PDO::FETCH_COLUMN); // tableau simple des id_rec

        if (!empty($userRec)) {
            // Crée une liste de placeholders dynamiques (?, ?, ?, ...)
            $placeholders = implode(',', array_fill(0, count($userRec), '?'));
            $query = "SELECT * FROM recompense WHERE id_rec NOT IN ($placeholders)";
            $stmt = $con->prepare($query);
            $stmt->execute($userRec); // passer directement le tableau
        } else {
            // L'utilisateur n'a aucune récompense : on retourne tout
            $stmt = $con->prepare("SELECT * FROM recompense");
            $stmt->execute();
        }

        $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = [
            'status' => 'success',
            'data' => [
                'recompense' => $userData,
            ]
        ];

        echo json_encode($response);
        break;


    case 'GET':

        // Récupérer toutes les récompenses disponibles
        $stmt = $con->prepare("SELECT * FROM recompense");
        $stmt->execute();
        $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer l'ID utilisateur depuis le cookie
        $id_uti = $_COOKIE['User_id'] ?? null;

        if (!$id_uti) {
            echo json_encode(['status' => 'error', 'message' => 'ID utilisateur manquant.']);
            break;
        }

        // Récupérer toutes les infos de cotisation de l'utilisateur
        $stmt = $con->prepare("SELECT * FROM infocoti WHERE id_uti = ?");
        $stmt->execute([$id_uti]);
        $Rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $recompensesAssociees = [];

        foreach ($Rec as $key) {
            $id_rec = $key['id_rec'];
            $id_info = $key['id_info'];
            $stmt = $con->prepare("SELECT * FROM recompense WHERE id_rec = ?");
            $stmt->execute([$id_rec]);
            $yy = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($yy) {
                $yy['id_info'] = $id_info;

                // Récupérer le dernier statut d’échéance pour cet utilisateur et cette récompense
                $stmtStatut = $con->prepare("
        SELECT statut 
        FROM echeance 
        WHERE id_uti = ? AND id_rec = ? 
        ORDER BY id_eche DESC 
        LIMIT 1
    ");
                $stmtStatut->execute([$id_uti, $id_rec]);
                $lastEcheance = $stmtStatut->fetch(PDO::FETCH_ASSOC);

                $yy['statut'] = $lastEcheance['statut'] ?? null;

                $recompensesAssociees[] = $yy;
            }
        }

        $response = [
            'status' => 'success',
            'data' => [
                'recompenseAll' => $userData,
                'recCh' => $recompensesAssociees
            ]
        ];

        echo json_encode($response);
        break;


    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
        break;
}

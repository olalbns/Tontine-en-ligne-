<?php
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $montant = $input['montant'];
        $dateLimite = $input['dateLimite'];
        $id_uti = $input['id_uti'];
        $type = $input['types'];
        $id_rec = $input['id_rec'];
        $depart_date = date('Y-m-d');


        function convertFrenchDateToYmd($frenchDate)
        {
            // Supprime le jour de la semaine s'il est présent
            $cleanDate = preg_replace('/^(lundi|mardi|mercredi|jeudi|vendredi|samedi|dimanche)\s+/i', '', trim($frenchDate));

            // Mois en français
            $months = [
                'janvier' => '01',
                'février' => '02',
                'fevrier' => '02',
                'mars' => '03',
                'avril' => '04',
                'mai' => '05',
                'juin' => '06',
                'juillet' => '07',
                'août' => '08',
                'aout' => '08',
                'septembre' => '09',
                'octobre' => '10',
                'novembre' => '11',
                'décembre' => '12',
                'decembre' => '12'
            ];

            // Extraction du format "29 juillet 2025"
            if (preg_match('/(\d{1,2})\s+([a-zéûîôàèêùç]+)\s+(\d{4})/iu', $cleanDate, $matches)) {
                $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                $month = strtolower(trim($matches[2]));
                $year = $matches[3];

                // Correction mois mal orthographié
                if (isset($months[$month])) {
                    return "$year-{$months[$month]}-$day";
                }
            }

            return false;
        }


        $dateLimiteYmd = convertFrenchDateToYmd($dateLimite);

        if (!$dateLimiteYmd) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Format de date invalide : ' . $dateLimite
            ]);
            exit;
        }


        try {
            $endDate = new DateTime($dateLimiteYmd);
            $currentDate = new DateTime($depart_date);

            // Mise à jour utilisateur
            $up = $con->prepare("UPDATE utilisateurs SET id_rec = :id_rec WHERE id_uti = :id_uti");
            $up->execute(['id_rec' => $id_rec, 'id_uti' => $id_uti]);

            // Insertion infocoti
            $repas = $con->prepare('INSERT INTO infocoti(id_uti, id_rec, types, montantChoisie, date_limite, depart_date) 
                           VALUES(:id_uti, :id_rec, :types, :montantChoisie, :date_limite, :depart_date)');
            $req = $repas->execute([
                'id_uti' => $id_uti,
                'id_rec' => $id_rec,
                'types' => $type,
                'montantChoisie' => $montant,
                'date_limite' => $dateLimiteYmd,
                'depart_date' => $currentDate->format('Y-m-d')
            ]);

            //////////////////////////////////////////////////////////////////////          

            if ($req) {
                // Génération des échéances
                $stmtEcheance = $con->prepare('INSERT INTO echeance(id_uti, id_rec, date_échéance, type, statut) 
                                     VALUES(?, ?, ?, ?, ?)');
                $echeancesCrees = 0;

                $stmtEcheance->execute([
                    $id_uti,
                    $id_rec,
                    $currentDate->format('Y-m-d'),
                    $type,
                    'en attente'
                ]);
                if ($stmtEcheance) {
                    //enregister une notification
                    $notification = $con->prepare("INSERT INTO notification (id_uti, id_rec, message, date) 
                                           VALUES (:id_uti, :id_rec, :message, NOW())");
                    $notification->bindParam(':id_uti', $id_uti);
                    $notification->bindParam(':id_rec', $id_rec);
                    $notification->bindParam(':message', $message);
                    $message = "Nouvelle récompense ajoutée.";
                    $notification->execute();
                }


                switch ($type) {
                    case 'journalier':
                        $currentDate->modify('+1 day');
                        break;
                    case 'hebdomadaire':
                        $currentDate->modify('+1 week');
                        break;
                    case 'mensuel':
                        $currentDate->modify('+1 month');
                        break;
                    default:
                        break 2;
                }


                $response = [
                    'status' => 'success',
                    'data' => [
                        'message' => "Ajout effectué avec succès",
                        'echeances_crees' => $echeancesCrees
                    ]
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => "Erreur lors de l'insertion dans infocoti"
                ];
            }
            echo json_encode($response);
            exit;
            /////////////////////////////////////////////////////////////////////////////


        } catch (PDOException $e) {
            $response = [
                'status' => 'error',
                'message' => "Erreur BD: " . $e->getMessage()
            ];
        }

        break;

    case 'GET':
        if (isset($_GET['id_info'])) {
            $id_info = $_GET['id_info'];
            $stmt = $con->prepare("SELECT * FROM infocoti WHERE id_info = :id_info");
            $stmt->bindParam(':id_info', $id_info);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            $id_rec = $userData["id_rec"];
            $stmt = $con->prepare("SELECT * FROM recompense WHERE id_rec = :id_rec");
            $stmt->bindParam(':id_rec', $id_rec);
            $stmt->execute();
            $userRec = $stmt->fetch(PDO::FETCH_ASSOC);

            $response = [
                'status' => 'success',
                'data' => [
                    'user' => $userData,
                    'rec' => $userRec
                ]
            ];

            echo json_encode($response);
        } elseif (isset($_COOKIE['User_id'])) {
            $id_uti = $_COOKIE['User_id'];
            $stmt = $con->prepare("SELECT * FROM infocoti WHERE id_uti = :id_uti");
            $stmt->bindParam(':id_uti', $id_uti);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            $id_rec = $userData["id_rec"];
            $stmt = $con->prepare("SELECT * FROM recompense WHERE id_rec = :id_rec");
            $stmt->bindParam(':id_rec', $id_rec);
            $stmt->execute();
            $userRec = $stmt->fetch(PDO::FETCH_ASSOC);

            $response = [
                'status' => 'success',
                'data' => [
                    'user' => $userData,
                    'rec' => $userRec
                ]
            ];


            echo json_encode($response);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['status' => 'error', 'message' => 'ID utilisateur manquant']);
            exit;
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
        break;
}

<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);
    $nom = htmlspecialchars($input['nom']);
    $prenoms = htmlspecialchars($input['prenoms']);
    $email = htmlspecialchars($input['email']);
    $telephone = htmlspecialchars($input['tel']);
    $password = htmlspecialchars($input['motdepasse']); 

    $stmt = $con->prepare("SELECT * FROM utilisateurs WHERE email_uti = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Email déja existante.']);
        exit;
    }

    $stmt = $con->prepare("SELECT * FROM utilisateurs WHERE num_uti = ?");
    $stmt->execute([$telephone]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Numéro de téléphone déja existant.']);
        exit;
    }

    $stmt = $con->prepare("INSERT INTO utilisateurs (nom_uti, prenom_uti, email_uti, num_uti, password) VALUES (?, ?, ?,?, ?)");
    $stmt->execute([$nom, $prenoms, $email, $telephone, password_hash($password, PASSWORD_DEFAULT)]);
    setcookie('Insc', $con->lastInsertId(), time() + (86400 * 2), "/");
    echo json_encode(['status' => 'success', 'message' => 'Inscription réussie.']);
}

?>
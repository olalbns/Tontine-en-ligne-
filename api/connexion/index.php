<?php
//Connexion a la base
include "../../app/db.php";
require_once __DIR__ . '/../../vendor/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);
    $email = htmlspecialchars($input['email']);
    $password = htmlspecialchars($input['password']);

    // Vérification des champs
    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Tous les champs sont requis.']);
        exit;
    }
    // Vérification de l'utilisateur
    $stmt = $con->prepare("SELECT * FROM utilisateurs WHERE email_uti = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Email incorrect ou mot de passe incorrect.']);
        exit;
    }
    // Vérification du mot de passe
    if (!password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Email ou Mot de passe incorrect.']);
        exit;
    }
    // Authentification réussie
    session_start();
    $_SESSION['user_id'] = $user['id_uti'];
    setcookie('User_id', $user['id_uti'], time() + (86400 * 30), "/");
   echo json_encode(['status' => 'success', 'message' => 'Connexion réussie.']);
    exit;
}else{
    echo json_encode(['status' => 'error', 'message' => 'Methode non autorisée.']);
}


?>
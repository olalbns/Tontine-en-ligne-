<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact - Quincaillerie Chaleureuse</title>
  <link rel="stylesheet" href="contact.css">
  <link rel="stylesheet" href="../connection/bootstrap-5.3.7-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
</head>
<body>
  

   <div class="container">
        <form action=""  method="post">
            <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="non">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Entrez votre email" name="email">
        </div>
          
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" rows="4" placeholder="Votre message..." name="message"></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Envoyer</button>
          </div>
        </form>
      </div>
      <?php
include"DB_connect.php";
 session_start();
if(isset($_POST["non"]) && isset($_POST["email"])  && isset($_POST["message"])) {
    $non = htmlspecialchars($_POST["non"]);
$email = htmlspecialchars($_POST["email"]);
$message = htmlspecialchars($_POST["message"]);

$insert = $DB_connect->prepare("INSERT INTO user (non, email, message) VALUES (:non, :email, :message)");
$insert->execute([
    ":non" => $non,
    ":email" => $email,
    ":message" => $message
]);
// header("location:contact.php");

   include "reussie.html";

}


 ?>



</body>
</html>

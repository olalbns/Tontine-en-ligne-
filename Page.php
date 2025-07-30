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

//    include "reussie.html";

}


 ?>
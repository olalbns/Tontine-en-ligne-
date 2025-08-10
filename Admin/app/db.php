<?php 
    try {
        $con = new PDO("mysql:host=localhost;port=3306;
        dbname=tontine;charset=utf8", "root", "");
    } catch (PDOException $e) {
        die('Erreur:' .$e->getMessage());
    } 
?>
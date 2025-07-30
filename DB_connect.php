<?php


try {
    $DB_connect= new PDO(
"mysql:host=localhost;dbname=utilisateur",
"root",
""
);


} catch (PDOException $e) {
echo "Erreur : " . $e->getMessage();
}

?>
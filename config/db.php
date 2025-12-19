<?php
// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "bankly_v2");

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données");
}
?>

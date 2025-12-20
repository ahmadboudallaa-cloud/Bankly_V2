<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

$transactions_sql = "DELETE transactions 
                     FROM transactions 
                     INNER JOIN comptes ON transactions.account_id = comptes.account_id 
                     WHERE comptes.client_id = $id";
mysqli_query($conn, $transactions_sql);

$comptes_sql = "DELETE FROM comptes WHERE client_id = $id";
mysqli_query($conn, $comptes_sql);

$clients_sql = "DELETE FROM clients WHERE client_id = $id";

if(mysqli_query($conn, $clients_sql)){
    $message = "Client supprimé avec succès";
} else {
    $message = "Erreur lors de la suppression: " . mysqli_error($conn);
}

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

header("Location: list_clients.php?message=" . urlencode($message));
exit;
?>
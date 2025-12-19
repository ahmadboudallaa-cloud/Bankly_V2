<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");


$transactions_sql = "DELETE FROM transactions WHERE account_id = $id";
mysqli_query($conn, $transactions_sql);

$comptes_sql = "DELETE FROM comptes WHERE account_id = $id";

if(mysqli_query($conn, $comptes_sql)){
    $message = "Compte supprimé avec succès";
} else {
    $message = "Erreur lors de la suppression: " . mysqli_error($conn);
}

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

header("Location: list_accounts.php?message=" . urlencode($message));
exit;
?>
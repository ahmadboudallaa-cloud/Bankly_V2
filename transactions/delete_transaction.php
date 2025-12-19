<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);

// Supprimer la transaction
$sql = "DELETE FROM transactions WHERE transaction_id = $id";

if(mysqli_query($conn, $sql)){
    $message = "Transaction supprimée avec succès";
} else {
    $message = "Erreur lors de la suppression: " . mysqli_error($conn);
}

header("Location: list_transactions.php?message=" . urlencode($message));
exit;
?>
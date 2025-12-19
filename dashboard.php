<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit;
}

// Statistiques
$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM clients"))['total'];
$accounts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM comptes"))['total'];
$transactions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions"))['total'];

$balance_result = mysqli_query($conn, "SELECT SUM(balance) as total FROM comptes");
$balance_row = mysqli_fetch_assoc($balance_result);
$total_balance = $balance_row['total'] ? number_format($balance_row['total'], 2) : '0.00';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Bankly</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Tableau de Bord</p>
            </div>
            
            <ul class="navbar-nav">
                <li><a href="dashboard.php" class="nav-link active">Tableau de Bord</a></li>
                <li><a href="clients/list_clients.php" class="nav-link">Clients</a></li>
                <li><a href="accounts/list_accounts.php" class="nav-link">Comptes</a></li>
                <li><a href="transactions/list_transactions.php" class="nav-link">Transactions</a></li>
                <li><a href="auth/logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
   
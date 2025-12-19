<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$message = "";

if(isset($_POST['add'])){
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cin = $_POST['cin'];
    
    $sql = "INSERT INTO clients (full_name, email, phone, cin) 
            VALUES ('$full_name', '$email', '$phone', '$cin')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: list_clients.php?message=Client ajouté avec succès");
        exit;
    } else {
        $message = "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter Client - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Ajouter un Client</p>
            </div>
            
            <ul class="navbar-nav">
                <li><a href="../dashboard.php" class="nav-link">Tableau de Bord</a></li>
                <li><a href="list_clients.php" class="nav-link">Clients</a></li>
                <li><a href="../accounts/list_accounts.php" class="nav-link">Comptes</a></li>
                <li><a href="../transactions/list_transactions.php" class="nav-link">Transactions</a></li>
                <li><a href="../auth/logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="main-title">Ajouter un Client</h1>
        
        <?php if($message): ?>
            <div class="message message-error"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2 class="form-title">Informations du Client</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nom Complet *</label>
                    <input type="text" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Téléphone *</label>
                    <input type="text" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label>CIN *</label>
                    <input type="text" name="cin" required>
                </div>
                
                <div class="form-buttons">
                    <a href="list_clients.php" class="btn btn-danger">Annuler</a>
                    <button type="submit" name="add" class="btn">Ajouter Client</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
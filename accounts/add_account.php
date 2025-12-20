<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name");
$message = "";

if(isset($_POST['add'])){
    $account_number = $_POST['account_number'];
    $balance = $_POST['balance'];
    $account_type = $_POST['account_type'];
    $client_id = $_POST['client_id'];
    
    $sql = "INSERT INTO comptes (account_number, balance, account_type, client_id) 
            VALUES ('$account_number', '$balance', '$account_type', '$client_id')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: list_accounts.php?message=Compte ajouté avec succès");
        exit;
    } else {
        $message = "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter Compte - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Ajouter un Compte</p>
            </div>
            
            <ul class="navbar-nav">
                <li><a href="../dashboard.php" class="nav-link">Tableau de Bord</a></li>
                <li><a href="../clients/list_clients.php" class="nav-link">Clients</a></li>
                <li><a href="list_accounts.php" class="nav-link">Comptes</a></li>
                <li><a href="../transactions/list_transactions.php" class="nav-link">Transactions</a></li>
                <li><a href="../auth/logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="main-title">Ajouter un Compte</h1>
        
        <?php if($message): ?>
            <div class="message message-error"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2 class="form-title">Informations du Compte</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Numéro de Compte *</label>
                    <input type="text" name="account_number" required>
                </div>
                
                <div class="form-group">
                    <label>Solde Initial (DH) *</label>
                    <input type="number" name="balance" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label>Type de Compte *</label>
                    <select name="account_type" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Checking">Checking (Courant)</option>
                        <option value="Savings">Savings (Épargne)</option>
                        <option value="Business">Business (Entreprise)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Client *</label>
                    <select name="client_id" required>
                        <option value="">-- Sélectionner un client --</option>
                        <?php while($client = mysqli_fetch_assoc($clients)): ?>
                            <option value="<?php echo $client['client_id']; ?>">
                                <?php echo $client['full_name']; ?> (<?php echo $client['email']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-buttons">
                    <a href="list_accounts.php" class="btn btn-danger">Annuler</a>
                    <button type="submit" name="add" class="btn">Ajouter Compte</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM comptes WHERE account_id = $id");
$account = mysqli_fetch_assoc($result);

$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name");
$message = "";

if(isset($_POST['update'])){
    $account_number = $_POST['account_number'];
    $balance = $_POST['balance'];
    $account_type = $_POST['account_type'];
    $account_status = $_POST['account_status'];
    $client_id = $_POST['client_id'];
    
    $sql = "UPDATE comptes SET 
            account_number = '$account_number',
            balance = '$balance',
            account_type = '$account_type',
            account_status = '$account_status',
            client_id = '$client_id'
            WHERE account_id = $id";
    
    if(mysqli_query($conn, $sql)){
        header("Location: list_accounts.php?message=Compte modifié avec succès");
        exit;
    } else {
        $message = "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier Compte - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Modifier Compte</p>
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
        <h1 class="main-title">Modifier Compte</h1>
        
        <?php if($message): ?>
            <div class="message message-error"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2 class="form-title">Modifier les Informations</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Numéro de Compte *</label>
                    <input type="text" name="account_number" value="<?php echo $account['account_number']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Solde (DH) *</label>
                    <input type="number" name="balance" step="0.01" value="<?php echo $account['balance']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Type de Compte *</label>
                    <select name="account_type" required>
                        <option value="Checking" <?php echo $account['account_type'] == 'Checking' ? 'selected' : ''; ?>>Checking (Courant)</option>
                        <option value="Savings" <?php echo $account['account_type'] == 'Savings' ? 'selected' : ''; ?>>Savings (Épargne)</option>
                        <option value="Business" <?php echo $account['account_type'] == 'Business' ? 'selected' : ''; ?>>Business (Entreprise)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Statut du Compte *</label>
                    <select name="account_status" required>
                        <option value="Active" <?php echo $account['account_status'] == 'Active' ? 'selected' : ''; ?>>Actif</option>
                        <option value="Closed" <?php echo $account['account_status'] == 'Closed' ? 'selected' : ''; ?>>Fermé</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Client *</label>
                    <select name="client_id" required>
                        <option value="">-- Sélectionner un client --</option>
                        <?php 
                        mysqli_data_seek($clients, 0);
                        while($client = mysqli_fetch_assoc($clients)): 
                        ?>
                            <option value="<?php echo $client['client_id']; ?>" 
                                <?php echo $client['client_id'] == $account['client_id'] ? 'selected' : ''; ?>>
                                <?php echo $client['full_name']; ?> (<?php echo $client['email']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-buttons">
                    <a href="list_accounts.php" class="btn btn-danger">Annuler</a>
                    <button type="submit" name="update" class="btn">Modifier Compte</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
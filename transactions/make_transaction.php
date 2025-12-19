<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$accounts = mysqli_query($conn, "SELECT * FROM comptes WHERE account_status = 'Active'");
$message = "";

if(isset($_POST['submit'])){
    $account_id = $_POST['account_id'];
    $amount = $_POST['amount'];
    $transaction_type = $_POST['transaction_type'];
    
    // Insérer la transaction
    $sql = "INSERT INTO transactions (account_id, amount, transaction_type) 
            VALUES ('$account_id', '$amount', '$transaction_type')";
    
    if(mysqli_query($conn, $sql)){
        // Mettre à jour le solde du compte
        if($transaction_type == 'credit'){
            $update_sql = "UPDATE comptes SET balance = balance + $amount WHERE account_id = $account_id";
        } else {
            $update_sql = "UPDATE comptes SET balance = balance - $amount WHERE account_id = $account_id";
        }
        
        mysqli_query($conn, $update_sql);
        
        header("Location: list_transactions.php?message=Transaction effectuée avec succès");
        exit;
    } else {
        $message = "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle Transaction - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Nouvelle Transaction</p>
            </div>
            
            <ul class="navbar-nav">
                <li><a href="../dashboard.php" class="nav-link">Tableau de Bord</a></li>
                <li><a href="../clients/list_clients.php" class="nav-link">Clients</a></li>
                <li><a href="../accounts/list_accounts.php" class="nav-link">Comptes</a></li>
                <li><a href="list_transactions.php" class="nav-link">Transactions</a></li>
                <li><a href="../auth/logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="main-title">Nouvelle Transaction</h1>
        
        <?php if($message): ?>
            <div class="message message-error"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2 class="form-title">Détails de la Transaction</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Compte *</label>
                    <select name="account_id" required>
                        <option value="">-- Sélectionner un compte --</option>
                        <?php while($account = mysqli_fetch_assoc($accounts)): ?>
                            <option value="<?php echo $account['account_id']; ?>">
                                <?php echo $account['account_number']; ?> (<?php echo number_format($account['balance'], 2); ?> DH)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Type de Transaction *</label>
                    <select name="transaction_type" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="credit">Crédit (Dépôt)</option>
                        <option value="debit">Débit (Retrait)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Montant (DH) *</label>
                    <input type="number" name="amount" step="0.01" required>
                </div>
                
                <div class="form-buttons">
                    <a href="list_transactions.php" class="btn btn-danger">Annuler</a>
                    <button type="submit" name="submit" class="btn">Valider Transaction</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
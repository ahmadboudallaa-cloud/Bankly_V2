<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT transactions.*, comptes.account_number 
        FROM transactions 
        LEFT JOIN comptes ON transactions.account_id = comptes.account_id
        ORDER BY transaction_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transactions - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Historique des Transactions</p>
            </div>
            
            <ul class="navbar-nav">
                <li><a href="../dashboard.php" class="nav-link">Tableau de Bord</a></li>
                <li><a href="../clients/list_clients.php" class="nav-link">Clients</a></li>
                <li><a href="../accounts/list_accounts.php" class="nav-link">Comptes</a></li>
                <li><a href="list_transactions.php" class="nav-link active">Transactions</a></li>
                <li><a href="../auth/logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="main-title">Transactions</h1>
        
        <?php if(isset($_GET['message'])): ?>
            <div class="message message-success"><?php echo $_GET['message']; ?></div>
        <?php endif; ?>
        
        <div class="center-buttons">
            <a href="make_transaction.php" class="btn">Nouvelle Transaction</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Compte</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['transaction_date']; ?></td>
                        <td><?php echo $row['account_number']; ?></td>
                        <td>
                            <?php if($row['transaction_type'] == 'credit'): ?>
                                <span class="badge badge-success">Crédit</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Débit</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo number_format($row['amount'], 2); ?> DH</strong></td>
                        <td>
                            <a href="delete_transaction.php?id=<?php echo $row['transaction_id']; ?>" 
                               class="btn btn-small btn-danger"
                               onclick="return confirm('Supprimer cette transaction?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px;">Aucune transaction</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT comptes.*, clients.full_name 
        FROM comptes 
        LEFT JOIN clients ON comptes.client_id = clients.client_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Comptes - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Gestion des Comptes</p>
            </div>
            
            <ul class="navbar-nav">
                <li><a href="../dashboard.php" class="nav-link">Tableau de Bord</a></li>
                <li><a href="../clients/list_clients.php" class="nav-link">Clients</a></li>
                <li><a href="list_accounts.php" class="nav-link active">Comptes</a></li>
                <li><a href="../transactions/list_transactions.php" class="nav-link">Transactions</a></li>
                <li><a href="../auth/logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="main-title">Liste des Comptes</h1>
        
        <?php if(isset($_GET['message'])): ?>
            <div class="message message-success"><?php echo $_GET['message']; ?></div>
        <?php endif; ?>
        
        <div class="center-buttons">
            <a href="add_account.php" class="btn">Nouveau Compte</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Solde</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['account_number']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['account_type']; ?></td>
                        <td><strong><?php echo number_format($row['balance'], 2); ?> DH</strong></td>
                        <td>
                            <?php if($row['account_status'] == 'Active'): ?>
                                <span class="badge badge-success">Actif</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Fermé</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_account.php?id=<?php echo $row['account_id']; ?>" class="btn btn-small">Modifier</a>
                            <a href="delete_account.php?id=<?php echo $row['account_id']; ?>" 
                               class="btn btn-small btn-danger"
                               onclick="return confirm('Supprimer ce compte?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px;">Aucun compte</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
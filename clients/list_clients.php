<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Clients - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Gestion des Clients</p>
            </div>
            
            <ul class="navbar-nav">
                <li><a href="../dashboard.php" class="nav-link">Tableau de Bord</a></li>
                <li><a href="list_clients.php" class="nav-link active">Clients</a></li>
                <li><a href="../accounts/list_accounts.php" class="nav-link">Comptes</a></li>
                <li><a href="../transactions/list_transactions.php" class="nav-link">Transactions</a></li>
                <li><a href="../auth/logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="main-title">Liste des Clients</h1>
        
        <?php if(isset($_GET['message'])): ?>
            <div class="message message-success"><?php echo $_GET['message']; ?></div>
        <?php endif; ?>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="message message-error"><?php echo $_GET['error']; ?></div>
        <?php endif; ?>
        
        <div class="center-buttons">
            <a href="add_client.php" class="btn">Nouveau Client</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>CIN</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['cin']; ?></td>
                        <td><?php echo $row['registration_date']; ?></td>
                        <td>
                            <a href="edit_client.php?id=<?php echo $row['client_id']; ?>" class="btn btn-small">Modifier</a>
                            <a href="delete_client.php?id=<?php echo $row['client_id']; ?>" 
                               class="btn btn-small btn-danger"
                               onclick="return confirm('Supprimer ce client?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px;">Aucun client</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="text-align: center; margin: 20px 0; color: var(--primary);">
            Total: <?php echo mysqli_num_rows($result); ?> clients
        </div>
    </div>
</body>
</html>
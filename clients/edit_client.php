<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update'])){
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cin = $_POST['cin'];
    
    $sql = "UPDATE clients SET 
            full_name = '$full_name',
            email = '$email',
            phone = '$phone',
            cin = '$cin'
            WHERE client_id = $id";
    
    if(mysqli_query($conn, $sql)){
        header("Location: list_clients.php?message=Client modifié avec succès");
        exit;
    } else {
        $message = "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier Client - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <h1>Bankly V2</h1>
                <p>Modifier Client</p>
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
        <h1 class="main-title">Modifier Client</h1>
        
        <?php if($message): ?>
            <div class="message message-error"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2 class="form-title">Modifier les Informations</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nom Complet *</label>
                    <input type="text" name="full_name" value="<?php echo $client['full_name']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="<?php echo $client['email']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Téléphone *</label>
                    <input type="text" name="phone" value="<?php echo $client['phone']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>CIN *</label>
                    <input type="text" name="cin" value="<?php echo $client['cin']; ?>" required>
                </div>
                
                <div class="form-buttons">
                    <a href="list_clients.php" class="btn btn-danger">Annuler</a>
                    <button type="submit" name="update" class="btn">Modifier Client</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
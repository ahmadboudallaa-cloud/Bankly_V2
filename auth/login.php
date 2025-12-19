<?php
session_start();
include("../config/db.php");

$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        
        if($password == $user['password']){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = "Email non trouvé";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Bankly</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Bankly V2</h2>
        
        <?php if($error): ?>
            <div class="message message-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-buttons">
                <button type="submit" name="login" class="btn">Se Connecter</button>
            </div>
        </form>
        
        <div style="margin-top: 20px; text-align: center; font-size: 14px; color: #666;">
            <p>Email: admin@bankly.com</p>
            <p>Mot de passe: admin123</p>
        </div>
    </div>
</body>
</html>
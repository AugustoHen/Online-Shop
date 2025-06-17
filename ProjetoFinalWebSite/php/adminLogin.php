<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM utilizadores WHERE username = ? AND permissao = 'adm'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['passe']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username; 
        header("Location: adminPage.php"); 
        exit;
    } else {
        $error = "Nome de utilizador ou palavra-passe inválidos, ou falta de permissão.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administração</title>
    <link rel="stylesheet" href="../css/adminLogin.css" type="text/css">
   
</head>
<body>
    <div class="container">
        <h1>Login Administração</h1>
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <label>Nome de Utilizador:</label><br>
            <input type="text" name="username" required><br>
            <label>Palavra-passe:</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>

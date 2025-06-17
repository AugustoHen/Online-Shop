<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM utilizadores WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $utilizador = $result->fetch_assoc();

        if (password_verify( $password, $utilizador['passe'])) {
            $_SESSION['username'] = $utilizador['username'];
            header("Location: userPage.php");
            exit;
        } else {
            echo "<div class='error-message'>Senha inválida!</div>";
        }
    } else {
        echo "<div class='error-message'>Nome de utilizador não encontrado!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Acesse sua conta de usuário na Loja Geek para acompanhar pedidos, editar perfil e muito mais.">
    <title>Login | Acesso de Usuário - Loja Geek</title>
    <link rel="stylesheet" href="../css/loginuser.css" type="text/css" >    
</head>
<body>

    <div class="container">
        <h2>Login</h2>
        <form method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Entrar</button>
        </form>
        <a href="validarCompra.php">Ainda não tem uma conta? Registre-se aqui</a>
    </div>
</body>
</html>

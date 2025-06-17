<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$currentUsername = $_SESSION['username'];

$sql = "SELECT nome, apelido, username FROM utilizadores WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "<script>alert('Erro ao buscar os dados do utilizador.');</script>";
    exit;
}

$sqlEncomendas = "SELECT nome, morada, produtos, quantidade, total FROM encomendas WHERE username = ?";
$stmtEncomendas = $conn->prepare($sqlEncomendas);
$stmtEncomendas->bind_param("s", $currentUsername);
$stmtEncomendas->execute();
$resultEncomendas = $stmtEncomendas->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUsername = trim($_POST['username']);
    $newPassword = trim($_POST['password']);

    if (!empty($newUsername) && $newUsername != $currentUsername) {
        $sqlCheckUsername = "SELECT username FROM utilizadores WHERE username = ?";
        $stmtCheck = $conn->prepare($sqlCheckUsername);
        $stmtCheck->bind_param("s", $newUsername);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            echo "<script>alert('Este nome de utilizador já está em uso. Por favor, escolha outro.');</script>";
            header("Refresh:0");
        }
    }

    $updates = [];
    $params = [];

    if (!empty($newUsername)) {
        $updates[] = "username = ?";
        $params[] = $newUsername;
    }
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updates[] = "passe = ?";
        $params[] = $hashedPassword;
    }

    $params[] = $currentUsername;

    $sql = "UPDATE utilizadores SET " . implode(', ', $updates) . " WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);

    if ($stmt->execute()) {
        if (!empty($newUsername)) {
            $_SESSION['username'] = $newUsername;
        }
        echo "<script>alert('Dados atualizados com sucesso!');</script>";
        header("Refresh:0");
    } else {
        echo "<script>alert('Erro ao atualizar os dados.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Dados | Área do Usuário - Loja Geek</title>
    <link rel="stylesheet" href="../css/userPage.css" type="text/css" >
 
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($userData['nome']); ?>!</h1>
        <p>Gerencie seus dados e preferências aqui.</p>
    </header>

    <main class="content">
        <h3>Dados Atuais</h3>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($userData['nome']); ?></p>
        <p><strong>Apelido:</strong> <?php echo htmlspecialchars($userData['apelido']); ?></p>
        <p><strong>Nome de Utilizador:</strong> <?php echo htmlspecialchars($userData['username']); ?></p>

        <h3>Redefinir Dados</h3>
        <form method="post">
            <label for="username">Novo Nome de Utilizador:</label>
            <input type="text" id="username" name="username" placeholder="Deixe em branco para não alterar">

            <label for="password">Nova Senha:</label>
            <input type="password" id="password" name="password" placeholder="Deixe em branco para não alterar">

            <button type="submit">Atualizar</button>
        </form>

        <h3>Suas Encomendas</h3>
        <?php if ($resultEncomendas->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Morada</th>
                        <th>Produtos</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($encomenda = $resultEncomendas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($encomenda['nome']); ?></td>
                            <td><?php echo htmlspecialchars($encomenda['morada']); ?></td>
                            <td><?php echo htmlspecialchars($encomenda['produtos']); ?></td>
                            <td><?php echo htmlspecialchars($encomenda['quantidade']); ?></td>
                            <td><?php echo htmlspecialchars($encomenda['total']); ?> €</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você ainda não fez nenhuma encomenda.</p>
        <?php endif; ?>

        <a href="logout.php" class="logout-link">Voltar à Página Principal</a>
    </main>
</body>
</html>

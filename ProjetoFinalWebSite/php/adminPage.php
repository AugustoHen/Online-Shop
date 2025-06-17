<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: adminLogin.php");
    exit;
}

$sqlEncomendas = "SELECT * FROM encomendas";
$encomendas = $conn->query($sqlEncomendas);

$sqlProdutos = "SELECT * FROM products";
$produtos = $conn->query($sqlProdutos);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_produto'])) {
    $nome = trim($_POST['nome']);
    $quantidade = intval($_POST['quantidade']);
    $valor = floatval($_POST['valor']);
    
    $sqlInserir = "INSERT INTO products (names, quant, cost) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sqlInserir);
    $stmt->bind_param("sid", $nome, $quantidade, $valor);
    $stmt->execute();
    echo "<script>alert('Produto inserido com sucesso!');</script>";
    echo "<script>window.location.href = 'adminPage.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_quantidade'])) {
    $id = intval($_POST['id']);
    $quantidade = intval($_POST['quantidade']);

    $sqlAtualizar = "UPDATE produtos SET quantidade = ? WHERE id = ?";
    $stmt = $conn->prepare($sqlAtualizar);
    $stmt->bind_param("ii", $quantidade, $id);
    $stmt->execute();
    echo "<script>alert('Quantidade atualizada com sucesso!');</script>";
    echo "<script>window.location.href = 'adminPage.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_valor'])) {
    $id = intval($_POST['id']);
    $valor = floatval($_POST['valor']);

    $sqlAtualizar = "UPDATE produtos SET valor = ? WHERE id = ?";
    $stmt = $conn->prepare($sqlAtualizar);
    $stmt->bind_param("di", $valor, $id);
    $stmt->execute();
    echo "<script>alert('Valor atualizado com sucesso!');</script>";
    echo "<script>window.location.href = 'adminPage.php';</script>";
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Painel administrativo para gerenciar produtos, encomendas e usuários da Loja Geek.">
    <link rel="stylesheet" href="../css/adminPage.css" type="text/css"> 
    <title>Administração Da Loja da Banda</title>

</head>

<body>
    <h1>Bem-vindo à Administração</h1>

    <button onclick="window.location.href='index.php';">Voltar à Página Principal</button>
    
    <h2>Encomendas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Produtos</th>
            <th>Total</th>
        </tr>
        <?php while ($encomenda = $encomendas->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($encomenda['id']) ?></td>
                <td><?php echo htmlspecialchars($encomenda['nome']); ?></td>
                <td><?php echo htmlspecialchars($encomenda['produtos']); ?></td>
                <td>€<?= htmlspecialchars(number_format($encomenda['total'], 2)) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Produtos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th>Alterar Quantidade</th>
            <th>Alterar Valor</th>
        </tr>
        <?php while ($produto = $produtos->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($produto['id']) ?></td>
                <td><?php echo htmlspecialchars($produto['names']); ?></td>
                <td><?= htmlspecialchars($produto['quant']) ?></td>
                <td>€<?= htmlspecialchars(number_format($produto['cost'], 2)) ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
                        <input type="number" name="quantidade" value="<?= htmlspecialchars($produto['quant']) ?>" required>
                        <button type="submit" name="atualizar_quantidade">Atualizar Quantidade</button>
                    </form>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
                        <input type="number" step="0.01" name="valor" value="<?= htmlspecialchars($produto['cost']) ?>" required>
                        <button type="submit" name="atualizar_valor">Atualizar Valor</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Inserir Novo Produto</h2>
    <form method="post">
        <input type="hidden" name="novo_produto" value="1">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>
        <label>Quantidade:</label>
        <input type="number" name="quantidade" required><br>
        <label>Valor:</label>
        <input type="number" step="0.01" name="valor" required><br>
        <button type="submit">Inserir Produto</button>
    </form>
</body>
</html>

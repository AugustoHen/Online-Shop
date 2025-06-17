<?php
include 'db.php';

$quantidade1 = intval($_POST['quantidade1'] ?? 0);
$quantidade2 = intval($_POST['quantidade2'] ?? 0);
$quantidade3 = intval($_POST['quantidade3'] ?? 0);
$quantidade4 = intval($_POST['quantidade4'] ?? 0);
$quantidade5 = intval($_POST['quantidade5'] ?? 0);
$totalGeral = floatval($_POST['totalGeral'] ?? 0);

$produto1 = $conn->query("SELECT * FROM products WHERE names='T-Shirt'")->fetch_assoc();
$produto2 = $conn->query("SELECT * FROM products WHERE names='CD'")->fetch_assoc();
$produto3 = $conn->query("SELECT * FROM products WHERE names='Souvenirs'")->fetch_assoc();
$produto4 = $conn->query("SELECT * FROM products WHERE names='Gifts'")->fetch_assoc();
$produto5 = $conn->query("SELECT * FROM products WHERE names='tshirt2'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Validação de Dados | Confirmação de Compra - Loja Geek</title>
    <meta charset="UTF-8">
    <meta name="description" content="Confirme os dados da sua compra e finalize o pedido com segurança na Loja Geek.">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@300;500;700&display=swap">
    <link rel="stylesheet" href="../css/validarCompra.css" type="text/css">
    
    <script>
        function validarFormulario(event) {
            const nome = document.querySelector('input[name="nome"]').value.trim();
            const apelido = document.querySelector('input[name="apelido"]').value.trim();
            const username = document.querySelector('input[name="username"]').value.trim();
            const passe = document.querySelector('input[name="passe"]').value.trim();
            const dataNascimento = document.querySelector('input[name="dataNascimento"]').value.trim();
            const morada = document.querySelector('textarea[name="morada"]').value.trim();

            if (!nome || !apelido || !username || !passe || !dataNascimento || !morada) {
                alert("Por favor, preencha todos os campos.");
                event.preventDefault();
                return false;
            }

            const nascimento = new Date(dataNascimento);
            const hoje = new Date();
            let idade = hoje.getFullYear() - nascimento.getFullYear();
            const mes = hoje.getMonth() - nascimento.getMonth();
            if (mes < 0 || (mes === 0 && hoje.getDate() < nascimento.getDate())) {
                idade--;
            }

            if (idade < 18) {
                alert("Você deve ter pelo menos 18 anos para realizar uma compra.");
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<?php if (isset($_GET['erro'])): ?>
    <aside class="alerta"><?php echo htmlspecialchars($_GET['erro']); ?></aside>
<?php endif; ?>

<?php if (isset($_GET['sucesso'])): ?>
    <aside class="alerta sucesso"><?php echo htmlspecialchars($_GET['sucesso']); ?></aside>
<?php endif; ?>

<h2>Confirmação de Compra</h2>
<p>Produtos Selecionados:</p>
<ul>
    <?php if ($quantidade1 > 0): ?>
        <li><?php echo htmlspecialchars($produto1['names']) . " - Quantidade: $quantidade1"; ?></li>
    <?php endif; ?>
    <?php if ($quantidade2 > 0): ?>
        <li><?php echo htmlspecialchars($produto2['names']) . " - Quantidade: $quantidade2"; ?></li>
    <?php endif; ?>
    <?php if ($quantidade3 > 0): ?>
        <li><?php echo htmlspecialchars($produto3['names']) . " - Quantidade: $quantidade3"; ?></li>
    <?php endif; ?>
    <?php if ($quantidade4 > 0): ?>
        <li><?php echo htmlspecialchars($produto4['names']) . " - Quantidade: $quantidade4"; ?></li>
    <?php endif; ?>
    <?php if ($quantidade5 > 0): ?>
        <li><?php echo htmlspecialchars($produto5['names']) . " - Quantidade: $quantidade5"; ?></li>
    <?php endif; ?>
</ul>

<p><strong>Total Geral:</strong> €<?= htmlspecialchars(number_format($totalGeral, 2)) ?></p>

<h3>Preencha seus dados</h3>
<form method="post" action="finalizarCompra.php" onsubmit="return validarFormulario(event)">
    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Apelido:</label>
    <input type="text" name="apelido" required>

    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Palavra-passe:</label>
    <input type="password" name="passe" required>

    <label>Data de Nascimento:</label>
    <input type="date" name="dataNascimento" required>

    <label>Morada:</label>
    <textarea name="morada" required></textarea>

    <input type="hidden" name="quantidade1" value="<?= htmlspecialchars($quantidade1) ?>">
    <input type="hidden" name="quantidade2" value="<?= htmlspecialchars($quantidade2) ?>">
    <input type="hidden" name="quantidade3" value="<?= htmlspecialchars($quantidade3) ?>">
    <input type="hidden" name="quantidade4" value="<?= htmlspecialchars($quantidade4) ?>">
    <input type="hidden" name="quantidade5" value="<?= htmlspecialchars($quantidade5) ?>">
    <input type="hidden" name="totalGeral" value="<?= htmlspecialchars($totalGeral) ?>">


    <button type="submit">Confirmar Compra</button>
</form>

</body>
</html>

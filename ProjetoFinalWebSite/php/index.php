<?php
include 'db.php';

$sql1 = "SELECT * FROM products WHERE names='T-Shirt'";
$result1 = $conn->query($sql1);
$produto1 = $result1->fetch_assoc();

$sql2 = "SELECT * FROM products WHERE names='CD'";
$result2 = $conn->query($sql2);
$produto2 = $result2->fetch_assoc();

$sql3 = "SELECT * FROM products WHERE names='Souvenirs'";
$result3 = $conn->query($sql3);
$produto3 = $result3->fetch_assoc();

$sql4 = "SELECT * FROM products WHERE names='Gifts'";
$result4 = $conn->query($sql4);
$produto4 = $result4->fetch_assoc();

$sql5 = "SELECT * FROM products WHERE names='tshirt2'";
$result5 = $conn->query($sql5);
$produto5 = $result5->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Loja da Banda - Camisetas, Cds e Souvenirs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Compre camisetas exclusivas, CDs e souvenirs na nossa loja online com entrega rápida e atendimento personalizado.">


    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">


    <script src="https://kit.fontawesome.com/c19e9be1b9.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/index.css" type="text/css">

 
</head>

<body>
    <nav class="w3-bar">
        <a href="#">🏠 Início</a>
        <a href="loginuser.php" target="_blank">👤 Minha Conta</a>
        <a href="adminLogin.php">🔐 Administração</a>
        <a href="validarCompra.php">📝 Registro</a> <!-- Link para a página de registro -->
        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
    </nav>

    <main id="galeria">
        <h1 id="titleport">Loja Online</h1>

        <table>
            <tr>
                <td><img src="../imagens/Tshirt.jpg"></td>
                <td><img src="../imagens/CD.jpg"></td>
                <td><img src="../imagens/souveniers.jpg"></td>
                <td><img src="../imagens/gifts.jpg"></td>
                <td><img src="../imagens/tshirt2.jpg"></td>
            </tr>
            <tr>
                <?php
                $produtos = [$produto1, $produto2, $produto3, $produto4, $produto5];
                foreach ($produtos as $produto) {
                    echo "<td><h4>{$produto['names']}</h4>
                          <p>Preço: €{$produto['cost']}</p>
                          <p>Stock disponível: " . (isset($produto['quant']) ? $produto['quant'] : "Indisponível") . "</p>
                          <button onclick='adicionarAoCarrinho({$produto['id']}, \"{$produto['names']}\", {$produto['cost']})'>Adicionar ao Carrinho</button></td>";
                }
                ?>
            </tr>
            <tr>
                <?php
                foreach ($produtos as $index => $produto) {
                    $i = $index + 1;
                    if ($produto['quant'] > 0) {
                        echo "<td>
                            <label for='quantidade$i'>Quantidade:</label>
                            <select id='quantidade$i' name='quantidade$i' onchange='atualizarTotal()'>"; 
                        for ($q = 0; $q <= $produto['quant']; $q++) {
                        echo "<option value='" . htmlspecialchars($q) . "'>" . htmlspecialchars($q) . "</option>";
                        }
                        echo "</select></td>";
                    } else {
                        echo "<td><p style='color: red;'>Indisponível no momento</p></td>";
                    }
                }
                ?>
            </tr>
            <tr>
                <?php for ($i = 1; $i <= 5; $i++) {
                    echo "<td><p>Total: € <span id='total" . htmlspecialchars($i) . "'>0.00</span></p></td>";
                } ?>
            </tr>
        </table>

        <div id="compra-container">
            <div id="carrinho">
                <h3>Itens no Carrinho:</h3>
                <ul id="itensCarrinho">
                    <!-- Itens do carrinho serão listados aqui -->
                </ul>
            </div>
            
            <h3>Total Geral: € <span id="totalGeral">0.00</span></h3>
            
            <form method="post" action="validarCompra.php" onsubmit="return prepararFormulario()">
                <input type="hidden" id="hiddenTotalGeral" name="totalGeral" value="0">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <input type="hidden" name="quantidade<?= htmlspecialchars($i) ?>" id="hiddenQuantidade<?= htmlspecialchars($i) ?>" value="0">
                <?php endfor; ?>
                <button type="submit"><i class="fas fa-shopping-cart"></i>Comprar</button>
            </form>
        </div>
    </main>

    <script>
        let carrinho = [];

        function adicionarAoCarrinho(id, nome, preco) {
            const quantidade = document.getElementById('quantidade' + id).value;
            if (quantidade > 0) {
                carrinho.push({ nome, preco, quantidade });
                atualizarCarrinho();
            }
        }

        function atualizarCarrinho() {
            const listaCarrinho = document.getElementById('itensCarrinho');
            listaCarrinho.innerHTML = '';

            carrinho.forEach(item => {
                const li = document.createElement('li');
                li.innerText = `${item.nome} - Quantidade: ${item.quantidade} - €${(item.preco * item.quantidade).toFixed(2)}`;
                listaCarrinho.appendChild(li);
            });
        }

        function atualizarTotal() {
            const precos = [<?= $produto1['cost'] ?>, <?= $produto2['cost'] ?>, <?= $produto3['cost'] ?>, <?= $produto4['cost'] ?>, <?= $produto5['cost'] ?>];
            let totalGeral = 0;
            for (let i = 1; i <= 5; i++) {
                const select = document.getElementById('quantidade' + i);
                const qtd = select ? parseInt(select.value) || 0 : 0;
                const total = qtd * precos[i - 1];
                document.getElementById('total' + i).innerText = total.toFixed(2);
                document.getElementById('hiddenQuantidade' + i).value = qtd;
                totalGeral += total;
            }
            document.getElementById('totalGeral').innerText = totalGeral.toFixed(2);
            document.getElementById('hiddenTotalGeral').value = totalGeral.toFixed(2);
        }

        function prepararFormulario() {
            atualizarTotal();
            return true;
        }
    </script>
</body>
</html>

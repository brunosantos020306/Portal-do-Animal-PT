<!-- adicionar o navegador da página que se encontra noutra página php -->
<?php
include 'header.php';
session_start();

// código para remover os itens do carrinho.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_id'])) {
    $removeId = $_POST['remove_id'];
    foreach ($_SESSION['carrinho'] as $key => $item) {
        if ($item['id'] == $removeId) {
            unset($_SESSION['carrinho'][$key]);
            break;
        }
    }
    // receber os itens que são adicionados ao carrinho
    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Carrinho</title>
    <link rel="stylesheet" href="geral.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div id="main">
    <div class="carrinho" id="carrinho">
        <h1>Portal do Animal PT - carrinho</h1>
        <ul class="lista_compras" id="lista_carrinho">
            <?php
            if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                foreach ($_SESSION['carrinho'] as $item) {
                    echo "<li>";
                    if ($item['tipo'] == 'produto') {
                        echo "<img class='imagem-carrinho' src='/PAP/ImagensProdutos/" . htmlspecialchars($item['fotografia'], ENT_QUOTES, 'UTF-8') . "' alt='" . htmlspecialchars($item['nome'], ENT_QUOTES, 'UTF-8') . "'>";
                        echo htmlspecialchars($item['nome'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($item['quantidade'], ENT_QUOTES, 'UTF-8') . "x) - €" . number_format($item['preco'] / $item['quantidade'], 2) . " cada, total: €" . number_format($item['preco'], 2);

                    } elseif ($item['tipo'] == 'servico') {
                        echo "<img class='imagem-carrinho' src='/PAP/ImagensServicos/" . htmlspecialchars($item['fotografia'], ENT_QUOTES, 'UTF-8') . "' alt='" . htmlspecialchars($item['nome'], ENT_QUOTES, 'UTF-8') . "'>";
                        echo htmlspecialchars($item['nome'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($item['quantidade'], ENT_QUOTES, 'UTF-8') . "x) - €" . number_format($item['preco'] / $item['quantidade'], 2) . " cada, total: €" . number_format($item['preco'], 2);
                        echo "<br>Data: " . htmlspecialchars($item['data'], ENT_QUOTES, 'UTF-8') . " Hora: " . htmlspecialchars($item['hora'], ENT_QUOTES, 'UTF-8');
                        echo "<br>Duração: " . htmlspecialchars($item['duracao'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($item['tipo_preco'], ENT_QUOTES, 'UTF-8') . "(s)";
                        if ($item['tipo_preco'] === 'dia') {
                            echo "<br>Tipo de Preço: Por Dia";
                        } elseif ($item['tipo_preco'] === 'hora') {
                            echo "<br>Tipo de Preço: Por Hora";
                        } elseif ($item['tipo_preco'] === 'minuto') {
                            echo "<br>Tipo de Preço: Por Minuto";
                        }
                    }
                    echo "<form method='post' style='display:inline; margin-left:10px;'>";
                    echo "<input type='hidden' name='remove_id' value='" . htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<button type='submit' class='botao_lixo'><i class='fa-solid fa-trash'></i></button>";
                    echo "</form>";
                    echo "</li>";
                }
            } else {
                echo "<li>Seu carrinho está vazio.</li>";
            }
            ?>
        </ul>
        <div class="pagamento">
            <div class="total">
                Total: €
                <?php
                $total = 0;
                if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $item) {
                        $total += $item['preco'];
                    }
                }

                echo number_format($total, 2);
                ?>
            </div>
            <?php if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])): ?>
                <form method="post" action="checkout.php">
                    <?php
                    foreach ($_SESSION['carrinho'] as $item) {
                       
                    }
                    ?>
                    <br>
                    <input type='hidden' name='total' value='<?php echo number_format($total, 2); ?>'>

                    <label for="método de pagamento">Método de pagamento:</label>
                    <br>
                    <select name="tipos_pagamento">
                        <option>Cartão de crédito</option>
                        <option>Cartão de débito</option>
                        <option>Paypal</option>
                        <option>MBWAY</option>
                    </select>
                    <button type='submit' name='checkout' id="checkout" class='botao_carrinho'>Checkout</button>
                </form>
            <?php endif; ?>

            <div>
                <form action="produtos.php" method="post" style="display:inline;">
                    <button type="submit" class="botao_voltar">Voltar aos Produtos</button>
                </form>
                <form action="servicos.php" method="post" style="display:inline;">
                    <button type="submit" class="botao_voltar">Voltar aos Serviços</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>
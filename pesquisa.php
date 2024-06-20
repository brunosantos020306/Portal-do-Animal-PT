<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Pesquisa</title>
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="catalogo.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include "header.php"; ?>

    <div id="main">
        <?php
        include 'ligacao.php';
        session_start();

        $pesquisa = mysqli_real_escape_string($conn, $_POST['termo_pesquisa']);

        $sql_produtos = "SELECT * FROM Produto WHERE nome LIKE '%$pesquisa%'";
        $sql_servicos = "SELECT * FROM Servico WHERE nome LIKE '%$pesquisa%'";

        $result_produtos = $conn->query($sql_produtos);
        $result_servicos = $conn->query($sql_servicos);
        ?>

        <h1 class="titulo">Resultados da Pesquisa</h1>

        <?php
        if ($result_produtos->num_rows > 0 || $result_servicos->num_rows > 0) {
            if ($result_produtos->num_rows > 0) {
                echo "<h2 class='subtitulo'>Produtos</h2>";
                while ($row = $result_produtos->fetch_assoc()) {
                    echo "<div class='unidade'>";
                    echo "<a target='_self' href='detalhes.php?tipo=produto&id=" . $row["id"] . "'>";
                    echo "<img src='/PAP/ImagensProdutos/" . $row["fotografia"] . "' alt='" . $row["nome"] . "'></a>";
                    echo "<div class='nome'><b>" . $row["nome"] . "</b></div>";
                    echo "<div class='preco'>Preço: <b id='dinheiro'>" . number_format($row["preco"], 2) . " € </b></div>";
                    echo "<div class='carrinho_botao'>";
                    echo "<form method='post' action='servicos.php'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='hidden' name='nome' value='" . $row["nome"] . "'>";
                    echo "<input type='hidden' name='preco' value='" . $row["preco"] . "'>";
                    echo "<input type='hidden' name='fotografia' value='" . $row["fotografia"] . "'>";
                    echo "<button class='botao_carrinho' id='botao_carrinho' type='submit'><i class='fa-solid fa-plus'></i><i class='fa-solid fa-cart-shopping'></i></button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhum produto encontrado.</p>";
            }

            if ($result_servicos->num_rows > 0) {
                echo "<h2 class='subtitulo'>Serviços</h2>";
                while ($row = $result_servicos->fetch_assoc()) {
                    echo "<div class='unidade'>";
                    echo "<a target='_self' href='detalhes.php?tipo=servico&id=" . $row["id"] . "'>";
                    echo "<img src='/PAP/ImagensServicos/" . $row["fotografia"] . "' alt='" . $row["nome"] . "'></a>";
                    echo "<div class='nome'><b>" . $row["nome"] . "</b></div>";
                    echo "<div class='preco'>Preço: <b id='dinheiro'>" . $row["preco"] . " € </b></div>";
                    echo "<div class='carrinho_botao'><button class='botao_carrinho'><i class='fa-solid fa-plus'></i><i class='fa-solid fa-cart-shopping'></i></button></div>";
                    if (isset($_SESSION['Admin']) && $_SESSION['Admin'] === true) {
                        echo "<div class='lixo'><button class='botao_lixo'><i class='fa-solid fa-trash'></i></button></div>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhum serviço encontrado.</p>";
            }
        } else {
            echo "<p>0 resultados :(</p>";
        }

        $conn->close();
        ?>
    </div>

    <?php include "footer.php"; ?>
</body>

</html>
<?php
session_start();
include 'ligacao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_id'])) {
    
    $removeId = $_POST['remove_id'];

    $sql = "DELETE FROM Produto WHERE id = $removeId";

    if ($conn->query($sql) === TRUE) {
        header('Location: produtos.php');
        exit;
    } else {
 $_SESSION['mensagem'] = "Erro ao remover o produto: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['email'])) {
        $_SESSION['erro_carrinho'] = "Precisa iniciar sessão para adicionar produtos ao carrinho.";
        header('Location: produtos.php');
        exit;
    }

    if (isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['preco']) && isset($_POST['fotografia']) && isset($_POST['tipo']) && isset($_POST['quantidade'])) {
        $itemId = $_POST['id'];
        $itemNome = $_POST['nome'];
        $itemPreco = $_POST['preco'];
        $itemFotografia = $_POST['fotografia'];
        $itemTipo = $_POST['tipo'];
        $itemQuantidade = $_POST['quantidade'];

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }

        $_SESSION['carrinho'][] = array(
            'id' => $itemId, 
            'nome' => $itemNome, 
            'preco' => $itemPreco * $itemQuantidade, 
            'fotografia' => $itemFotografia, 
            'tipo' => $itemTipo, 
            'quantidade' => $itemQuantidade
        );

        header('Location: produtos.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Produtos</title>
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="catalogo.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include "header.php"; ?> 

    <div id="main">
    <h1 class="titulo">Produtos
    <?php
    if (isset($_SESSION['Admin']) && $_SESSION['Admin'] === true) {
        echo '<a href="adicionar_produto.php" style="margin-left: 10px; color: green;"><i class="fa-solid fa-pen"></i></a>';
    }
    ?>

<?php
if (isset($_SESSION['mensagem'])) {
    echo "<div id='mensagem'>" . $_SESSION['mensagem'] . "</div>";
    unset($_SESSION['mensagem']);
}
?>

</h1>
<?php
if (isset($_SESSION['mensagem'])) {
    echo "<div id='mensagem'>" . $_SESSION['mensagem'] . "</div>";
    unset($_SESSION['mensagem']);
}
?>
        </h1>
        
        <?php
        if (isset($_SESSION['erro_carrinho'])) {
            echo "<div id='erro_carrinho'>" . $_SESSION['erro_carrinho'] . "</div>";
            unset($_SESSION['erro_carrinho']);
        }

        $sql = "SELECT * FROM Produto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='unidade'>";
                echo "<a target='_self' href='detalhes.php?tipo=produto&id=" . $row["id"]. "'>";
                echo "<img src='/PAP/ImagensProdutos/" . $row["fotografia"]. "' alt='". $row["nome"]. "'></a>";
                echo "<div class='nome'><b>". $row["nome"]. "</b></div>";
                echo "<div class='preco'>Preço: <b id='dinheiro'>". number_format($row["preco"], 2). " € </b></div> ";
                echo "<div class='carrinho_botao'>";
                echo "<form method='post' action='produtos.php'>";
                echo "<input type='number' name='quantidade' value='1' min='1' max='10' style='float: left; margin-right: 10px;'>";
                echo "<input type='hidden' name='id' value='". $row["id"]. "'>";
                echo "<input type='hidden' name='nome' value='". $row["nome"]. "'>";
                echo "<input type='hidden' name='preco' value='". $row["preco"]. "'>";
                echo "<input type='hidden' name='fotografia' value='". $row["fotografia"]. "'>";
                echo "<input type='hidden' name='tipo' value='produto'>";
                echo "<button class='botao_carrinho' id='botao_carrinho' type='submit'><i class='fa-solid fa-plus'></i><i class='fa-solid fa-cart-shopping'></i></button>";
                echo "</form>";
                echo "</div>";

                if (isset($_SESSION['Admin']) && $_SESSION['Admin'] === true) {
                    echo "<div class='lixo'>";
                    echo "<form method='post' class='form-remove'>";
                    echo "<input type='hidden' name='remove_id' value='{$row["id"]}'>";
                    echo "<button type='submit' class='botao_lixo'><i class='fa-solid fa-trash'></i></button>";
                    echo "</form>";
                    echo "</div>";
                }

                echo "</div>";
            }
        } else {
            echo "0 resultados :(";
        }
        $conn->close(); 
        ?>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
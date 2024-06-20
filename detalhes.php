<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Detalhes</title>
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="detalhes.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include "header.php"; ?> 

    <div id="main">
        <?php
        include 'ligacao.php';

        $tipo = $_GET['tipo']; 
        $id =  $_GET['id']; 

        $sql = "SELECT * FROM $tipo WHERE id = $id";
        $result = $conn->query($sql);

        if($row = $result->fetch_assoc()) {
            echo "<div id='coluna_1'>";
            echo "<div id='titulo'><b>". $row["nome"]. "</b></div>";

            echo "<br><br>";

            if ($tipo == "servico") {
                echo "<div id='imagems_servicos'><img id='img' src='/PAP/ImagensServicos/" . $row["fotografia"] . "' alt='" . $row["nome"]. "width:500px'></a></div>";

            } else if($tipo == "produto") {
                echo "<div id='imagems_produtos'><img id='img' src='/PAP/ImagensProdutos/" . $row["fotografia"] . "' alt='" . $row["nome"]. "width:300px'></a></div>";
            }

            echo "</div>";
            
            echo "<div class='coluna_2'>";

            echo "<div class='descricao'><b> Descrição:". $row["descricao"]. "</b></div>";

            echo "<br>";

            echo "<div class='preco'><b> Preço:" . "<div id='dinheiro'>" . $row["preco"]. " </div> € </b></div>";

            echo "<br>";

            if ($tipo == "produto") {
                echo "<div class='caracteristicas'><b> Caracteristicas:". $row["caracteristicas"]. "</b></div>";
            }

            echo "<br><br>";

            echo "<div id='botoes'>
            <a href='produtos.php'><button type='button' class='botao_retroceder'>Produtos</button></a>
            <a href='servicos.php'><button type='button' class='botao_retroceder'>Servicos</button></a>
            </div>";

            echo "</div>";
        } 
        ?>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
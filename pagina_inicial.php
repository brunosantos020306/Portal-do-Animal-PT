<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT</title>
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="pagina_inicial.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

<!-- adicionar o navegador da página que se encontra noutra página php -->
    <?php
    include "header.php";
    ?>

<!-- criação do main com o conteúdo principal da página -->
    <div id="main">
        <div id="coluna1">
        <div id="titulo">
            <h1 id="slogan">Encontre os melhores produtos e serviços para os seus animais!</h1>
        </div>

        <!-- criação de botões -->
        <div id="botoes">
            <a href="produtos.php"><button type="button" class="botoes">Produtos</button></a>

            <a href="servicos.php"><button type="button" class="botoes">Serviços</button></a>
        </div>
        </div>

        <div id="coluna2">

        <!-- inserção da imagem alusiva do site -->
        <div id="imagem">
            <img src="caogatonovo.png">
        </div>
        </div>
    </div>

    <!-- adicionar o footer da página que se encontra noutra página php -->
    <?php
    include "footer.php";
    ?>
    
</body>

</html>
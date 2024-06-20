<?php
include 'header.php';
?>
<?php
session_start();
include 'ligacao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['Admin']) && $_SESSION['Admin'] === true) {
 
    if (isset($_POST['nome_produto']) && isset($_POST['preco_produto']) && isset($_POST['descricao_produto']) && isset($_FILES['fotografia_produto'])) {
       
        $nome = $_POST['nome_produto'];
        $preco = $_POST['preco_produto'];
        $descricao = $_POST['descricao_produto'];
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fotografia_produto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        
        $check = getimagesize($_FILES["fotografia_produto"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['mensagem'] = "O arquivo não é uma imagem.";
            header('Location: adicionar_produto.php');
            exit;
        }


        if (file_exists($target_file)) {
            $_SESSION['mensagem'] = "O arquivo já existe.";
            header('Location: adicionar_produto.php');
            exit;
        }

     
        if ($_FILES["fotografia_produto"]["size"] > 500000) {
            $_SESSION['mensagem'] = "O arquivo é muito grande.";
            header('Location: adicionar_produto.php');
            exit;
        }

     
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['mensagem'] = "São apenas permitidos arquivos JPG, JPEG, PNG e GIF são permitidos.";
            header('Location: adicionar_produto.php');
            exit;
        }

      
        if (move_uploaded_file($_FILES["fotografia_produto"]["tmp_name"], $target_file)) {
            $fotografia = basename($_FILES["fotografia_produto"]["name"]);

            $sql = "INSERT INTO Produto (nome, preco, descricao, fotografia) VALUES ('$nome', '$preco', '$descricao', '$fotografia')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['mensagem'] = "Produto adicionado com sucesso!";
                header('Location: produtos.php');
                exit;
            } else {
                $_SESSION['mensagem'] = "Erro ao adicionar produto: " . $conn->error;
                header('Location: adicionar_produto.php');
                exit;
            }
        } else {
            $_SESSION['mensagem'] = "Desculpe, ocorreu um erro ao fazer o upload do arquivo.";
            header('Location: adicionar_produto.php');
            exit;
        }
    } else {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios!";
        header('Location: adicionar_produto.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="geral.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div id="main">
    <h1 id="texto_adicionar_produto">Adicionar Novo Produto</h1>
    <form action="adicionar_produto.php" method="POST" enctype="multipart/form-data">
        <label for="nome_produto">Nome do Produto:</label>
        <input type="text" id="nome_produto" name="nome_produto" required><br><br>
        
        <label for="preco_produto">Preço do Produto:</label>
        <input type="number" id="preco_produto" name="preco_produto" step="0.01" required><br><br>
        
        <label for="descricao_produto">Descrição do Produto:</label><br>
        <textarea id="descricao_produto" name="descricao_produto" rows="4" cols="50" required></textarea><br><br>
        
        <label for="fotografia_produto">Upload da Fotografia do Produto:</label>
        <input type="file" id="fotografia_produto" name="fotografia_produto" accept="image/*" required><br><br>
        
        <input type="submit" id="adicionar_produto" value="Adicionar Produto">
    </form>
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>
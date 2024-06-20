<!-- adicionar o navegador da página que se encontra noutra página php -->
<?php
include 'header.php';
?>
<?php
// incluir a ligação á base de dados
session_start();
include 'ligacao.php';

//receber as informações do serviço

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['Admin']) && $_SESSION['Admin'] === true) {

    if (isset($_POST['nome_servico']) && isset($_POST['preco_servico']) && isset($_POST['descricao_servico']) && isset($_FILES['fotografia_servico'])) {

        $nome = $_POST['nome_servico'];
        $preco = $_POST['preco_servico'];
        $descricao = $_POST['descricao_servico'];
        $tipo_preco = $POST['tipo_preco'];

        // buscar a fotografia do serviço
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fotografia_servico"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        

        $check = getimagesize($_FILES["fotografia_servico"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['mensagem'] = "O arquivo não é uma imagem.";
            header('Location: adicionar_servico.php');
            exit;
        }


        if (file_exists($target_file)) {
            $_SESSION['mensagem'] = "Desculpe, o arquivo já existe.";
            header('Location: adicionar_servico.php');
            exit;
        }

  
        if ($_FILES["fotografia_servico"]["size"] > 500000) {
            $_SESSION['mensagem'] = "Desculpe, o arquivo é muito grande.";
            header('Location: adicionar_servico.php');
            exit;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['mensagem'] = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
            header('Location: adicionar_servico.php');
            exit;
        }

        if (move_uploaded_file($_FILES["fotografia_servico"]["tmp_name"], $target_file)) {
       
            $fotografia = basename($_FILES["fotografia_servico"]["name"]);

            //inserir os dados do serviço na base de dados
            $sql = "INSERT INTO Servico (nome, preco, descricao, fotografia, tipo_preco) VALUES ('$nome', '$preco', '$descricao', '$fotografia', '$tipo_preco')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['mensagem'] = "Servico adicionado com sucesso!";
                header('Location: servicos.php');
                exit;
            } else {
                $_SESSION['mensagem'] = "Erro ao adicionar servico: " . $conn->error;
                header('Location: adicionar_servico.php');
                exit;
            }
        } else {
            $_SESSION['mensagem'] = "Desculpe, ocorreu um erro ao fazer o upload do arquivo.";
            header('Location: adicionar_servico.php');
            exit;
        }
    } else {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios!";
        header('Location: adicionar_servico.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Servico</title>
    <link rel="stylesheet" href="geral.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<!-- dados que o administrador vai ter de inserir para adicionar o serviço -->
<div id="main">
    <h1 id="texto_adicionar_servico">Adicionar Novo Servico</h1>
    <form action="adicionar_servico.php" method="POST" enctype="multipart/form-data">
        <label for="nome_produto">Nome do Servico:</label>
        <input type="text" id="nome_servico" name="nome_servico" required><br><br>
        
        <label for="preco_servico">Preço do Servico:</label>
        <input type="number" id="preco_servico" name="preco_servico" step="0.01" required><br><br>
        
        <label for="descricao_servico">Descrição do Servico:</label><br>
        <textarea id="descricao_servico" name="descricao_servico" rows="4" cols="50" required></textarea><br><br>
        
        <label for="fotografia_servico">Upload da Fotografia do Servico:</label>
        <input type="file" id="fotografia_servico" name="fotografia_servico" accept="image/*" required><br><br>
        
        <input type="submit" id="adicionar_servico" value="Adicionar Servico">
    </form>
    </div>

 <!-- adicionar o footer da página que se encontra noutra página php -->
    <?php
    include "footer.php";
    ?>
</body>
</html>
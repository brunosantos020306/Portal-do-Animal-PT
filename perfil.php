<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Perfil</title>
    <link rel="stylesheet" href="geral.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
</head>
<body>

    <?php include "header.php"; ?>  

    <?php
    if (isset($_SESSION['email'])) {
     $nome = $_SESSION['nome'];
    }
    ?>

    <div id="main">
        <?php include 'ligacao.php'; ?>
        
        <h1 id="titulo_perfil">Perfil - <?php echo "$nome" ?></h1>

        <?php 
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $codigo_postal = $_SESSION['codigo_postal'];
                $morada = $_SESSION['morada'];
                $telefone = $_SESSION['telefone'];
                $data_nascimento = $_SESSION['data_nascimento'];
                $tipo_user = $_SESSION['tipo_user'];

                echo "<div class='perfil'>";
                echo "<div class='nome_cliente'><b>Nome:</b> " . $nome . "</div>";
                echo "<br>";
                echo "<div class='email'><b>Email:</b> " . $email . "</div>";
                echo "<br>";
                echo "<div class='codigo_postal'><b>Código Postal:</b> " . $codigo_postal . "</div>";
                echo "<br>";
                echo "<div class='morada'><b>Morada:</b> " . $morada . "</div>";
                echo "<br>";
                echo "<div class='telefone'><b>Telefone:</b> " . $telefone . "</div>";
                echo "<br>";
                echo "<div class='data_nascimento'><b>Data de Nascimento:</b> " . $data_nascimento . "</div>";
                echo "<br>";
                echo "<div class='tipo_user'><b>Tipo de utilizador:</b> " . $tipo_user . "</div>";
                echo "</div>";
                echo "<br>";
            }
            $conn->close(); 
        ?>
        
    </div>

    <?php include "footer.php"; ?>

</body>
</html>
<?php 
    require("verificar.php");
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Login</title>
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="login.css">
<link href="https://fonts.googleapis.com/css2?family=Acme&family=Lemon&family=Scada&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lemon&family=Scada&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php 

if($erro != null) {
    ?> <style>.erro{display:block}</style> <?php
}

?>

</head>
<body>

    <?php
    include "header.php";
    ?>

<div id="main">
 <section>
    <fieldset class="login">
    <h1 id="registo_titulo">Login</h1>
    <form method="post" action="" autocomplete="off">


    <div class="ct_nome_utilizador">
    <label id="label_email">E-Mail:</label>
    <input type="text" class="input_boxes" name="email" id="email" value="<?php echo $email?>" required>
    </div>

    <br><br>

    <div class="ct_password">
    <label id="label_password">Password:</label>
    <input type="password" class="input_boxes" name="pass" id="pass" value="<?php echo $pass?>" required>
    <br>
    </div>

        <div class="form">
            <input type="submit" name="submit" id="submit" value="Enviar"></input>
        </div>

        <p class="p_login">se ainda não tem conta <a href="registo.php" class="link_login">clique aqui</a></p>

        <p class="erro">
        <?php echo $erro?>
        </p>

    </form>
    </fieldset>
</section>
</div>

<?php
    include "footer.php";
    ?>

</body>
</html>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Registo</title>
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="registo.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&family=Lemon&family=Scada&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        function validateInput(event) {
            const input = event.target.value;
            if (/\d/.test(input)) {
                event.target.value = input.replace(/\d/g, '');
            }
        }
    </script>
</head>

<body>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        registo();

    }

    function registo()
    {
        include 'ligacao.php';

        $nif = $_POST["nif"];
        $nome = $_POST["nome"];
        $password = $_POST["password"];
        $codigo_postal = $_POST["codigo_postal"];
        $morada = $_POST["morada"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $dt = $_POST["data_nascimento"];
        $tipo_user = $_POST["tipo_user"];

        $sql = "INSERT INTO Cliente (nif, nome, pass, codigo_postal, morada, email, telefone, dt, tipo_user) VALUES ('$nif' , '$nome' , '$password' , '$codigo_postal' , '$morada' , '$email' , '$telefone' ,'$dt', '$tipo_user')";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Dados inseridos com sucesso!")</script>';
        } else {
            echo '<script>alert("Dados não inseridos")</script>';
        } 
        mysqli_close($conn);
    }

    ?>

    <?php
    include "header.php";
    ?>

    <div id="main">
        <section>
            <fieldset class="registo">
                <h1 id="registo_titulo">Registo</h1>
                <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>

                    <div class="ct_nome_utilizador">
                        <label id="labels_registo">Nome:</label>
                        <input type="text" class="input_boxes" name="nome" id="nome" oninput="validateInput(event)"
                            required>
                    </div>

                    <br>

                    <div class="ct_password">
                        <label id="labels_registo">Password:</label>
                        <input type="password" class="input_boxes" name="password" id="password" required>
                    </div>

                    <br>

                    <div class="ct_nif">
                        <label id="labels_registo">Nif:</label>
                        <input type="text" class="input_boxes" name="nif" id="nif" maxLength=10
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            required />
                    </div>

                    <br>


                    <div class="ct_email">
                        <label id="labels_registo">E-mail:</label>
                        <input type="email" class="input_boxes" name="email" id="email" maxLength=100 required />
                    </div>

                    <br>

                    <div class="ct_datanascimento">
                        <label id="labels_registo">Data Nasc:</label>
                        <input type="date" class="input_boxes" name="data_nascimento" id="data_nascimento" required />
                    </div>

                    <script>
                        var dataInput = document.getElementById("data_nascimento");
                        var dataAtual = new Date().toISOString().split("T")[0];
                        dataInput.setAttribute("max", dataAtual);
                    </script>

                    <br>

                    <div class="ct_telefone">
                        <label id="labels_registo">Telefone:</label>
                        <input type="text" class="input_boxes" name="telefone" id="telefone" maxLength=9
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            required />
                    </div>
                    <br>
                    <div class="ct_codigopostal">
                        <label id="labels_registo">Codigo Post:</label>
                        <input type="text" class="input_boxes" name="codigo_postal" id="codigo_postal" required />
                    </div>
                    <br>
                    <div class="ct_morada">
                        <label id="labels_registo">Morada:</label>
                        <input type="text" class="input_boxes" name="morada" id="morada" required />
                    </div>
                    <div class="ct_User">
                        <select name="tipo_user" id="tipo_user">
                            <option>Utilizador</option>
                            <option>Administrador</option>
                        </select>
                    </div>

                    <br>

                    <div class="form">
                        <input type="submit" name="submit" id="submit"></input>
                    </div>

                    <p class="p_login"> se já tem conta <a href="login.php" class="link_login">clique aqui</a></p>

                </form>
            </fieldset>
        </section>
    </div>

    <?php
    include "footer.php";
    ?>

</body>

</html>
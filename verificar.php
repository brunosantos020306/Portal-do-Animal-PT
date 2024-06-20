<?php
session_start();

$erro = null;

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    include 'ligacao.php';

    $sql = "SELECT nome, morada, telefone, tipo_user, codigo_postal, dt FROM Cliente WHERE email = '$email' AND pass = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['email'] = $email;
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['codigo_postal'] = $row['codigo_postal'];
            $_SESSION['morada'] = $row['morada'];
            $_SESSION['telefone'] = $row['telefone'];
            $_SESSION['data_nascimento'] = $row['dt'];
            $_SESSION['tipo_user'] = $row['tipo_user'];

            if ($row['tipo_user'] == "Administrador") {
                $_SESSION['Admin'] = true;
                header("location: produtos.php");
                exit();
            } else if ($row['tipo_user'] == "Utilizador") {
                $_SESSION['Utilizador'] = true;
                header("location: pagina_inicial.php");
                exit();
            }
        }
    } else {
        $erro = "Os dados estão incorretos!";
    }

    $conn->close();
}
?>
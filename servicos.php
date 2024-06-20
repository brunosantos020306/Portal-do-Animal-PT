<?php
session_start();
include 'ligacao.php';

// código para remover serviços.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_id'])) {
    
    $removeId = $_POST['remove_id'];

    $sql = "DELETE FROM Servico WHERE id = $removeId";

    if ($conn->query($sql) === TRUE) {
        header('Location: servicos.php');
        exit;
    } else {
 $_SESSION['mensagem'] = "Erro ao remover o serviço: " . $conn->error;
    }
}

// código da mensagem que aparece quando se tenta adicionar serviços ao carrinho e o utilizador não tem sessão iniciada.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['email'])) {
        $_SESSION['erro_carrinho'] = "Precisa iniciar sessão para adicionar serviços ao carrinho.";
        header('Location: servicos.php');
        exit;
    }
}

// código para adicionar um serviço ao carrinho.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['id'], $_POST['nome'], $_POST['preco'], $_POST['fotografia'], $_POST['tipo'], $_POST['quantidade'], $_POST['data'], $_POST['hora'], $_POST['tipo_preco'])) {
        $itemId = $_POST['id'];
        $itemNome = $_POST['nome'];
        $itemPreco = $_POST['preco'];
        $itemFotografia = $_POST['fotografia'];
        $itemTipo = $_POST['tipo'];
        $itemQuantidade = $_POST['quantidade'];
        $itemData = $_POST['data'];
        $itemHora = $_POST['hora'];
        $itemTipoPreco = $_POST['tipo_preco'];
        $duracao = ($_POST['tipo_preco'] === 'hora' || $_POST['tipo_preco'] === 'minuto' || $_POST['tipo_preco'] === 'dia') ? $_POST['duracao'] : 0;

// diferentes operações consoante o tipo de preço.
        switch ($itemTipoPreco) {
            case 'hora':
                $precoTotal = $itemPreco * $itemQuantidade * $duracao;
                break;
            case 'minuto':
                $precoTotal = $itemPreco * $itemQuantidade * $duracao;
                break;
            case 'dia':
                $precoTotal = $itemPreco * $itemQuantidade * $duracao;
                break;
            case 'nenhum':
                $precoTotal = $itemPreco * $itemQuantidade;
                break;
            default:
                $precoTotal = $itemPreco * $itemQuantidade;
                break;
        }

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }

        // código do array que vai receber os diferentes serviços adicionados ao carrinho.
        $_SESSION['carrinho'][] = array(
            'id' => $itemId,
            'nome' => $itemNome,
            'preco' => $precoTotal,
            'fotografia' => $itemFotografia,
            'tipo' => $itemTipo,
            'quantidade' => $itemQuantidade,
            'data' => $itemData,
            'hora' => $itemHora,
            'tipo_preco' => $itemTipoPreco,
            'duracao' => $duracao
        );

        header('Location: servicos.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Animal PT - Serviços</title>
    <link rel="stylesheet" href="geral.css">
    <link rel="stylesheet" href="catalogo.css">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateInputs = document.querySelectorAll("input[type='date']");
            var timeInputs = document.querySelectorAll("input[type='time']");
            var today = new Date().toISOString().split('T')[0];

            dateInputs.forEach(function(dateInput) {
                dateInput.setAttribute('min', today);

                dateInput.addEventListener('change', function() {
                    var selectedDate = new Date(dateInput.value);
                    var now = new Date();
                    var timeInput = dateInput.parentElement.querySelector("input[type='time']");

                    if (selectedDate.toISOString().split('T')[0] === now.toISOString().split('T')[0]) {
                        var hours = now.getHours().toString().padStart(2, '0');
                        var minutes = now.getMinutes().toString().padStart(2, '0');
                        var currentTime = hours + ':' + minutes;
                        timeInput.setAttribute('min', currentTime);
                    } else {
                        timeInput.removeAttribute('min');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <?php include "header.php"; ?>  

    <div id="main">
        <h1 class="titulo">Serviços
            <?php
            if (isset($_SESSION['Admin']) && $_SESSION['Admin'] === true) {
                echo '<a href="adicionar_servico.php" style="margin-left: 10px; color: green;"><i class="fa-solid fa-pen"></i></a>';
            }
            ?>
        </h1>
        
        <?php
        if (isset($_SESSION['erro_carrinho'])) {
            echo "<div id='erro_carrinho'>" . $_SESSION['erro_carrinho'] . "</div>";
            unset($_SESSION['erro_carrinho']);
        }

        $sql = "SELECT * FROM Servico";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='unidade'>";
                echo "<a target='_self' href='detalhes.php?tipo=servico&id=" . $row["id"] . "'>";
                echo "<img src='/PAP/ImagensServicos/" . $row["fotografia"]. "' alt='". $row["nome"]. "'></a>";
                echo "<div class='nome'><b>". $row["nome"]. "</b></div>";
                echo "<div class='preco'>Preço: <b id='dinheiro'>". number_format($row["preco"], 2). " € " . $row["tipo_preco"] . "</b></div> ";
                echo "<div class='carrinho_botao'>";
                echo "<form method='post' action='servicos.php'>";
                echo "<input type='number' name='quantidade' class='quantidade_servico' value='1' min='1' max='1' style='float: left; margin-right: 10px;'>";
                echo "<input type='date' name='data' required style='float: left; margin-right: 10px;'>";
                echo "<input type='time' name='hora' required style='float: left; margin-right: 10px;'>";

                if ($row["tipo_preco"] === "hora") {
                    echo "<input type='number' name='duracao' placeholder='Horas' min='1' required>";
                } else if ($row["tipo_preco"] === "minuto") {
                    echo "<input type='number' name='duracao' placeholder='Minutos' min='1' required>";
                } else if ($row["tipo_preco"] === "dia") {
                    echo "<input type='number' name='duracao' placeholder='Dias' min='1' required style='position: absolute left: 20px;'>";
                }

                echo "<input type='hidden' name='id' value='". $row["id"]. "'>";
                echo "<input type='hidden' name='nome' value='". $row["nome"]. "'>";
                echo "<input type='hidden' name='preco' value='". $row["preco"]. "'>";
                echo "<input type='hidden' name='fotografia' value='". $row["fotografia"]. "'>";
                echo "<input type='hidden' name='tipo' value='servico'>";

                echo "<select name='tipo_preco' required style='float: left; margin-right: 10px;'>
                    <option value='nenhum'>Nenhum</option>
                    <option value='minuto'>Minuto</option>
                    <option value='hora'>Hora</option>
                    <option value='dia'>Dia</option>
                </select>";

                echo "<button class='botao_carrinho' id='botao_carrinho' type='submit'><i class='fa-solid fa-plus'></i><i class='fa-solid fa-cart-shopping'></i></button>";
                echo "</form>";
                echo "</div>";

                if (strpos(strtolower($row["nome"]), 'vacinação') !== false) {
                    echo "<select name='tipo_vacinacao' required style='float: left; margin-right: 10px;'>
                    <option value='Herpevírus Felino'> Herpevírus Felino</option>
                    <option value='Panleucopenia Felina'>Panleucopenia Felina</option>
                    <option value='Calicivírus Felino'>Calicivírus Felino</option>
                    <option value='Leucemia Felina'>Leucemia Felina</option>
                    </select>";
                }

                $tipo_preco = $_POST['tipo_preco'];

                if ($tipo_preco == "Minuto") {
                echo "<input type='number' name='duracao' placeholder='Minutos' min='1' required>";
                } if ($tipo_preco == "Hora") {
                    echo "<input type='number' name='duracao' placeholder='Horas' min='1' required>";
                } if ($tipo_preco == "Dia") {
                    echo "<input type='number' name='duracao' placeholder='Dias' min='1' required>";
                }

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
        }
        ?>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
<?php
session_start();
include 'ligacao.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $clienteId = $_SESSION['clienteId'];
    $clienteNIF = $_SESSION['nif'];
    $produtos = $_POST['produtos'];
    $quantidades = $_POST['quantidades'];
    $precos = $_POST['precos'];
    $dataHora = date('Y-m-d H:i:s');

    $conn->begin_transaction();

    try {
        foreach ($produtos as $index => $produtoId) {
            $produtoId = intval($produtoId);
            $quantidade = intval($quantidades[$index]);
            $preco = floatval($precos[$index]);
            $totalItem = $quantidade * ($preco / $quantidade); 

            $stmt = $conn->prepare("INSERT INTO Venda (Produto_id, Cliente_nif, dataHora, quantidade, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issid", $produtoId, $clienteNIF, $dataHora, $quantidade, $totalItem);

            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }

            $stmt->close();
        }

        $conn->commit();

        echo "<script>
            alert('Obrigado pela sua compra! O seu pedido foi efetuado com sucesso!.');
            window.location.href = 'pagina_inicial.php';
            </script>";

        unset($_SESSION['carrinho']);
    } catch (Exception $e) {
        $conn->rollback();
        echo "Erro: " . $e->getMessage();
    }

    exit;
}
?>
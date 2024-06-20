<link rel="stylesheet" href="geral.css">
<div id="header">
<div id="header_left">
    <form action="pesquisa.php" method="POST">
        <input id="caixa_pesquisa" type="text" name="termo_pesquisa" placeholder="Digite sua pesquisa...">
        <button id="pesquisa" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>
<div id="header_center">
    <img src="Portal do Animal PT logo.png" class="logo" onclick="window.location.replace('pagina_inicial.php')" />
</div>
<div id="header_right">
    <?php

    require("verificar.php");

    if (isset($_SESSION['email'])) {
        $email = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
        echo "<p id='email_sessao'>" . "bem vindo , " . $email . "</p>";
        
        if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
            echo "<span class='quantidade'>" . count($_SESSION['carrinho']) . "</span>";
        }

        echo "<div id='logo_carrinho'><a href='carrinho.php'><i class='fa-solid fa-cart-shopping'></i></a></div>";
        echo "<div id='logo_logout'><a href='logout.php'><i id='logo_logout' class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
        echo "<a href='perfil.php'><i id='logo_perfil' class='fa-solid fa-user'></i></a>";

    } else {
        echo "<a href='login.php'><i id='cliente' class='fa-solid fa-circle-user'></i></a>";
    }
    ?>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    atualizarQuantidadeCarrinho();
});

function atualizarQuantidadeCarrinho() {
    var quantidadeSpan = document.querySelector('.quantidade');

    if (quantidadeSpan && <?php echo isset($_SESSION['carrinho']) ? 'true' : 'false'; ?>) {
        quantidadeSpan.textContent = <?php echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '0'; ?>;
    }
}
</script>
<?php
session_start();
?>

<?php

session_unset();
session_destroy();

echo "<script>
            alert('Sessão terminada');
            window.location.href = 'pagina_inicial.php';
          </script>";
          
?>

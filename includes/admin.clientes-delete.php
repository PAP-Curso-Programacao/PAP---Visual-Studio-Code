<?php
session_start();
require_once 'conn.php';
require_once 'functions.inc.php';

if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];
    // Verifica se o cliente foi apagado com sucesso
    if (apagarCliente($db, $cliente_id)) {
        echo '<script>alert("Cliente apagado com sucesso");</script>';
        // Redireciona para a página de lista de clientes após o alerta ser exibido
        echo '<script>window.location.href = "../admin.clientes.php";</script>';
        exit; 
    } else {
        echo "Erro ao apagar o cliente.";
    }
} else {
    echo "ID do cliente não fornecido.";
}
?>

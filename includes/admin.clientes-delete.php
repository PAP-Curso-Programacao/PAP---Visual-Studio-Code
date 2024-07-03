<?php
session_start();
require_once 'conn.php';
require_once 'functions.inc.php';

if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    if (isClientInUse($db, $cliente_id)) {
        header("Location: ../admin.clientes.php?error=client_in_use");
        exit();
    } else {
        // Chame uma função para excluir o cliente
        if (apagarCliente($db, $cliente_id)) {
            // Redirecione de volta para a página de administração após a exclusão
            header("Location: ../admin.clientes.php?error=none");
            exit();
        } else {
            // Caso haja algum erro na exclusão
            header("Location: ../admin.clientes.php?delete=error");
            exit();
        }
    }
}
?>

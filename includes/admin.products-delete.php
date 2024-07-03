<?php
session_start();
require_once 'conn.php';
require_once 'functions.inc.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Chame uma função para excluir o produto
    if (deleteProduct($db, $id)) {
        // Redirecione de volta para a página de administração após a exclusão
        header("Location: ../admin.products.php?error=none");
        exit();
    } else {
        // Caso haja algum erro na exclusão
        header("Location: ../admin.products.php?delete=error");
        exit();
    }
}
?>
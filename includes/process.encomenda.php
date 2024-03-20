<?php
session_start();

// Recupere os dados do carrinho
$productsInCart = isset($_SESSION['productsInCart']) ? $_SESSION['productsInCart'] : [];

require_once 'conn.php';
require_once 'functions.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $encomendaId = createOrder($db, $_SESSION["userid"], $_SESSION["useruid"]);
    if ($encomendaId !== false && $encomendaId !== null && $encomendaId !== 0) {
        createOrderLine($db, $encomendaId, $productsInCart);
        header("location: ../catalogo.php?error=none");
    } else {
        echo "Erro na criação da encomenda";
    }
} else {
    header("location: ../index.php");
}
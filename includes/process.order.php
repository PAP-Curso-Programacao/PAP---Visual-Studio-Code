<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents("php://input");
    $postData = json_decode($postData, true);

    $productsInCart = isset($postData['productsInCart']) ? $postData['productsInCart'] : [];
    $total = isset($postData['total']) ? $postData['total'] : 0;
    
    $_SESSION['productsInCart'] = $productsInCart;
    $_SESSION['total'] = $total;
} else {
    echo "Nenhuma solicitação POST recebida";
    http_response_code(400);
}
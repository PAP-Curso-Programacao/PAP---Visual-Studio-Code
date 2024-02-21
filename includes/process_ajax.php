<?php
// Certifique-se de incluir a lógica de início de sessão se necessário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dadosRecebidos = file_get_contents('php://input');
    $pedido = json_decode($dadosRecebidos, true);

    $productsInCart = isset($postData['productsInCart']) ? $postData['productsInCart'] : [];
    $total = isset($postData['total']) ? $postData['total'] : 0;

    // Aqui você pode processar os dados do pedido, como validar os dados, salvar no banco de dados, etc.
    $_SESSION['carrinho'] = $pedido['productsInCart'];
    $_SESSION['total'] = $pedido['total'];

    // Retorna uma resposta
    echo json_encode(['status' => 'success', 'message' => 'Pedido processado com sucesso.']);
}else {
    echo "Nenhuma solicitação POST recebida";
    http_response_code(400);
}
?>
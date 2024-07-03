<?php
session_start();
require_once 'includes/conn.php';
require_once 'includes/functions.inc.php';

// Configurações para a paginação
$currentPage = isset($_GET['page-nr']) ? (int)$_GET['page-nr'] : 1;
$rowsPerPage = 5; // Número de pedidos por página

// Obter pedidos e informações de paginação
$paginationResultPedidos = paginationPedidos($db, $currentPage, $rowsPerPage);
$pedidos = $paginationResultPedidos['pedidos'];
$totalPagesPedidos = $paginationResultPedidos['totalPages'];

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $orders = fetchOrders($db, $searchTerm);

    // Retornar os resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($orders);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Pedidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <div class="logo">
            <i class='bx bx-menu menu-icon'></i>
            <span class="logo-name">Pastelaria Crocancia</span>
        </div>
        <div class="sidebar">
            <div class="logo">
                <i class='bx bx-menu menu-icon'></i>
                <span class="logo-name">Painel administrador</span>
            </div>
            <div class="sidebar-content">
                <ul class="lists">
                    <li class="list">
                        <a href="admin.dashboard.php" class="nav-link">
                            <i class='bx bxs-dashboard icon'></i>
                            <span class="link">Dashboard</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="admin.clientes.php" class="nav-link">
                            <i class='bx bx-user icon'></i>
                            <span class="link">Clientes</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="admin.products.php" class="nav-link">
                            <i class='bx bxs-package icon'></i>
                            <span class="link">Produtos</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="admin.pedidos.php" class="nav-link">
                            <i class='bx bx-notepad icon'></i>
                            <span class="link">Pedidos</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="includes/logout.inc.php" class="nav-link">
                            <i class='bx bx-user icon'></i>
                            <span class="link">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="containerPedido">
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-size: 18px;">
                        Lista de Encomendas
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data do Pedido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pedido['ID']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['ClienteID']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['Nome']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['Email']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['DataPedida']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                        <a href="?page-nr=<?php echo $currentPage - 1; ?>">Anterior</a>
                        <?php endif; ?>
                        <?php if ($currentPage < $totalPagesPedidos): ?>
                        <a href="?page-nr=<?php echo $currentPage + 1; ?>">Próximo</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-panel">
            <div class="title">
                <h2>Buscar Encomendas</h2>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <input type="text" id="searchInput" placeholder="Digite o ID do pedido">
                    <button onclick="fetchOrders()"><i class='bx bx-search'></i></button>
                </div>
                <div id="searchResults" class="search-results">

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        function fetchOrders() {
            const searchTerm = document.getElementById('searchInput').value.trim();

            // Verifica se o searchTerm não está vazio
            if (searchTerm !== '') {
                fetch(`admin.pedidos.php?search=${encodeURIComponent(searchTerm)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao buscar pedidos');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const searchResults = document.getElementById('searchResults');
                        searchResults.innerHTML = ''; // Limpa resultados anteriores
                        data.forEach(order => {
                            const orderDetails = document.createElement('div');
                            orderDetails.classList.add('order-details'); // Adiciona classe para estilização
                            orderDetails.innerHTML = `
                                <p><strong>ID:</strong> ${order.ID}</p>
                                <p><strong>Cliente ID:</strong> ${order.ClienteID}</p>
                                <p><strong>Nome:</strong> ${order.Nome}</p>
                                <p><strong>Email:</strong> ${order.Email}</p>
                                <p><strong>Data do Pedido:</strong> ${order.DataPedida}</p>
                            `;
                            searchResults.appendChild(orderDetails);
                        });
                    })
                    .catch(error => console.error('Erro ao buscar pedidos:', error));
            } else {
                alert('Por favor, digite um ID do pedido.');
            }
        }
    </script>
</body>

</html>

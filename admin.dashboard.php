<?php
    session_start();
    require_once 'includes/conn.php';
    require_once 'includes/functions.inc.php';

    $recentUsers = getRecentUsers($db, 5); // Busca os 5 usuários mais recentes
    $totalProdutos = contarProdutos($db); // Chama a função e armazena o resultado na variável $totalProdutos.
    $totalClientes = contarClientes($db); // Chama a função e armazena o resultado na variável $totalClientes.
    $totalPedidos = contarPedidos($db); // Chama a função e armazena o resultado na variável
    $recentOrders = getRecentOrders($db, 5); // Chama a função e armazena o resultado na variável $recentOrders
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
    <div class="containeradmin">
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1><?php echo $totalClientes; ?></h1>
                        <h3>Clientes</h3>
                    </div>
                    <div class="icon-case">
                        <img src="img/icon/user.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1><?php echo $totalProdutos; ?></h1>
                        <h3>Produtos</h3>
                    </div>
                    <div class="icon-case">
                        <img src="img/icon/product.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1><?php echo $totalPedidos; ?></h1>
                        <h3>Pedidos</h3>
                    </div>
                    <div class="icon-case">
                        <img src="img/icon/pedidos.png" alt="">
                    </div>
                </div>
            </div>
            <div class="content-2">
                <div class="pedidos-recentes">
                    <div class="title">
                        <h2>Encomendas recentes</h2>
                        <a href="admin.pedidos.php" class="btn">Ver todos</a>
                    </div>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>ClienteID</th>
                            <th>Email</th>
                            <th>Data do Pedido</th>
                        </tr>
                        <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['ID']); ?></td>
                            <td><?php echo htmlspecialchars($order['ClienteID']); ?></td>
                            <td><?php echo htmlspecialchars($order['Email']); ?></td>
                            <td><?php echo htmlspecialchars($order['DataPedida']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="novos-clientes">
                    <div class="title">
                        <h2>Novos Clientes</h2>
                        <a href="admin.clientes.php" class="btn">Ver todos</a>
                    </div>
                    <table>
                        <tr>
                            <th>Perfil</th>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>DataRegisto</th>
                        </tr>
                        <?php foreach ($recentUsers as $user): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($user['Perfil']); ?>" style="width: 70px; height:70px;"></td>
                            <td><?php echo htmlspecialchars($user['ID']); ?></td>
                            <td><?php echo htmlspecialchars($user['Nome']); ?></td>
                            <td><?php echo htmlspecialchars($user['Email']); ?></td>
                            <td><?php echo htmlspecialchars($user['dataRegisto']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
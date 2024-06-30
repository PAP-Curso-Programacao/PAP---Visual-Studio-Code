<?php
    session_start();

    require_once 'includes/conn.php';
    require_once 'includes/functions.inc.php';

    $currentPage = isset($_GET['page-nr']) ? (int)$_GET['page-nr'] : 1;
    $paginationResultClientes = paginationClientes($db, $currentPage);
    $clientes = $paginationResultClientes['clientes'];
    $totalPagesClientes = $paginationResultClientes['totalPages'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
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
                        <a href=".php" class="nav-link">
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

    <div class="containerCliente">
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-size: 18px;">
                        Lista de Clientes
                    </h4>    
                    <a href="admin.clientes-add.php" class="btn-home">Adicionar Clientes</a>
                </div>
                <div class="card-body">
                   <table class="table">
                        <thead>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telemovel</th>
                            <th>Ação</th>
                        </thead>
                        <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['ID']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['Nome']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['Email']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['Telefone']); ?></td>
                            <td width="300px">
                                    <a href="admin.clientes-edit.php?ID=<?php echo $cliente['ID']; ?>" class="btn-edit" style="background-color: #0b0; font-weight: 500">Editar</a>
                                    <a href="includes/admin.clientes-delete.php?id=<?php echo $cliente['ID']; ?>" class="btn-edit" style="background-color: #fc0000; font-weight: 500">Apagar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                   </table>
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?page-nr=<?php echo $currentPage - 1; ?>">Anterior</a>
                        <?php endif; ?>
                        <?php if ($currentPage < $totalPagesClientes): ?>
                            <a href="?page-nr=<?php echo $currentPage + 1; ?>">Próximo</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/script.js"></script>
</body>
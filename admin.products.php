<?php
    session_start();
    require_once 'includes/conn.php';
    require_once 'includes/functions.inc.php';

    $mostSoldProduct = getMostSoldProduct($db);
    $leastSoldProduct = getLeastSoldProduct($db);

    // Obter o número da página atual da URL
    $currentPage = isset($_GET['page-nr']) ? (int)$_GET['page-nr'] : 1;

    // Chamar a função de paginação
    $paginationResult = pagination($db, $currentPage);
    $products = $paginationResult['products'];
    $totalPages = $paginationResult['totalPages'];
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

        <div class="containeradmin" style="padding: 20px">
            <div class="content">
                <div class="cards">
                        <div class="add-products form-container">
                            <form action="includes/add.product.php" method="POST" enctype="multipart/form-data">
                                <div class="input-field">
                                    <label style="font-size: 14px">Nome do produto:</label>
                                    <input type="text" name="name" required>
                                </div>
                                <div class="input-field">
                                    <label style="font-size: 14px">Preço do produto:</label>
                                    <input type="number" name="preco" required>
                                </div>
                                <div class="input-field">
                                    <label style="font-size: 14px">Descrição do produto:</label>
                                    <textarea name="desc"></textarea>
                                </div>
                                <div class="input-field">
                                    <label style="font-size: 14px">Quantidade do produto:</label>
                                    <input type="number" name="stock" required>
                                </div>
                                <div class="input-field">
                                    <label style="font-size: 14px">Imagem do produto:</label>
                                    <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/gif" required>
                                </div>
                                <input type="submit" name="add_produto" value="Adicionar produto" class="btn">
                            </form>
                        </div>
                    <div class="content-2">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="produtos">
                                <table>
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagem</th>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th>Quantidade</th>
                                        <th>Editar</th>
                                    </tr>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['ID']); ?></td>
                                        <td><img src="<?php echo $product['Imagem']; ?>" style="width: 150px; height:100px;"></td>
                                        <td><?php echo htmlspecialchars($product['Nome']); ?></td>
                                        <td><?php echo htmlspecialchars($product['Preço']); ?></td>
                                        <td><?php echo htmlspecialchars($product['Stock']); ?></td>
                                        <td><a href="admin.editProducts.php" class="btn-edit">Edit</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <div class="pagination">
                                <?php if ($currentPage > 1): ?>
                                    <a href="?page-nr=<?php echo $currentPage - 1; ?>">Anterior</a>
                                <?php endif; ?>
                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="?page-nr=<?php echo $currentPage + 1; ?>">Próximo</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>   
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/script.js"></script>
</body>
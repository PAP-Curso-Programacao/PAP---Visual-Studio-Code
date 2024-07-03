<?php
    session_start();
    require_once 'includes/conn.php';
    require_once 'includes/functions.inc.php';


// Verifica se foi enviado o ID do produto via GET
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    // Obtém os detalhes do produto pelo ID
    $product = obterProdutoPorId($db, $productId);
} else {
    // Caso não tenha sido enviado o ID, redireciona para a página de administração de produtos
    header("Location: admin.products.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $stock = $_POST['stock'];
    $imagem = $_POST['imagem']; // Aqui você pode lidar com o upload de imagem se necessário

    // Chama a função para atualizar o produto
    atualizarProduto($id, $nome, $preco, $descricao, $stock, $imagem);

    // Redireciona para a página de administração de produtos após a atualização
    header("Location: admin.products.php");
    exit();
}
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

    <div class="containerEdit">
    <div class="content-2">
        <h2>Editar Produto</h2>
        <?php if ($product): ?>
            <form method="POST" action="includes/editProduct.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo isset($productId) ? $productId : ''; ?>">
                
                <div class="form-row" style="margin-top: 2rem">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo isset($product['Nome']) ? htmlspecialchars($product['Nome']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço:</label>
                        <input type="number" id="preco" name="preco" step="0.01" value="<?php echo isset($product['Preço']) ? $product['Preço'] : ''; ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" value="<?php echo isset($product['Descrição']) ? htmlspecialchars($product['Descrição']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Quantidade:</label>
                        <input type="number" id="stock" name="stock" value="<?php echo isset($product['Stock']) ? $product['Stock'] : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="imagem">Imagem:</label>
                    <label for="file-upload" class="custom-file-upload">
                        <img id="img-preview" src="<?php echo isset($product['Imagem']) ? htmlspecialchars($product['Imagem']) : ''; ?>" alt="Imagem do Produto">
                    </label>
                <input type="file" id="file-upload" name="profile_image" style="display:none;">
            </div>
                    <div class="form-actions">
                        <button type="submit">Guardar</button>
                    </div>
                </div>

                
            </form>
        <?php else: ?>
            <p>Produto não encontrado.</p>
        <?php endif; ?>
    </div>
</div>

    
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Quando a imagem for clicada
    $('#img-preview').click(function() {
        $('#file-upload').click(); // Simula o clique no input file
    });

    // Quando um arquivo for selecionado
    $('#file-upload').change(function() {
        var file = $(this)[0].files[0]; // Obtém o arquivo selecionado
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-preview').attr('src', e.target.result); // Mostra a imagem selecionada
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>

</body>
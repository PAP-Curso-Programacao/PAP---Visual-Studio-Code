<?php
session_start();

require_once 'includes/conn.php';
require_once 'includes/functions.inc.php';

$nome = $telefone = $email = $senha = $perfil = $role = '';

// Verificar se há um ID de cliente na query string
if (isset($_GET['ID'])) {
    $cliente_id = $_GET['ID'];
    $cliente_dados = getClienteById($db, $cliente_id);

    if ($cliente_dados) {
        // Preencher as variáveis com os dados do cliente
        $nome = $cliente_dados['Nome'];
        $telefone = $cliente_dados['Telefone'];
        $email = $cliente_dados['Email'];
        $senha = $cliente_dados['Senha'];
        $perfil = $cliente_dados['Perfil'];
        $role = $cliente_dados['role'];
    } else {
        echo "Cliente não encontrado.";
    }
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

    <div class="containerCliente">
        <div class="content">
            <div class="card" style="min-height: 0vh">
                <div class="card-header">
                    <h4 style="font-size: 18px;">
                        Editar Cliente
                    </h4>
                    <a href="admin.clientes.php" class="btn-home">Voltar</a>
                </div>
                <div class="card-body">
                    <form action="includes/editCliente.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="ID" value="<?php echo $cliente_id; ?>">
                        <div style="display: flex; justify-content: space-between;">
                            <div class="input-field" style="flex: 1">
                                <label> Nome</label>
                                <input type="text" name="name" class="" value="<?php echo htmlspecialchars($nome); ?>" required>
                            </div>
                            <div class="input-field" style="flex: 1">
                                <label> Telemovel</label>
                                <input type="number" name="phone" class="" value="<?php echo htmlspecialchars($telefone); ?>" required>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="input-field" style="flex: 1">
                                <label> Email</label>
                                <input type="email" name="email" class="" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="input-field" style="flex: 1">
                                <label> Password</label>
                                <input type="password" name="password" class="" value="<?php echo htmlspecialchars($senha); ?>" required>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="input-field" style="flex: 1">
                                <label> Escolha o cargo</label>
                                <select name="role" class="form-select" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; color: #333; width:20%">
                                    <option value="">Escolha o cargo</option>
                                    <option value="admin" <?php if($role == 'admin') echo 'selected'; ?>>Administrador</option>
                                    <option value="user" <?php if($role == 'user') echo 'selected'; ?>>Cliente</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                            <div class="input-field" style="flex: 1;">
                                <label for="file-upload" class="custom-file-upload">
                                    <?php if (!empty($perfil)): ?>
                                        <label for="">Foto de perfil:</label>
                                        <img id="img-preview" src="<?php echo htmlspecialchars($perfil); ?>" alt="Foto de perfil">
                                    <?php endif; ?>
                                </label>
                                <input type="file" id="file-upload" name="profile_image" style="display:none;" onchange="previewImage(event)">
                                <button type="submit" class="btn-edit" style="margin-left: 10px; float: right; font-weight: bold; height: 4rem; margin-top: 1rem;">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        document.getElementById('img-preview').addEventListener('click', function() {
            document.getElementById('file-upload').click();
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('img-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>

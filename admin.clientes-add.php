<?php
    session_start();
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
            <div class="card" style="min-height: 0vh">
                <div class="card-header">
                    <h4 style="font-size: 18px;">
                        Adicionar Clientes    
                    </h4>
                    <a href="admin.clientes.php" class="btn-home">Voltar</a>
                </div>
                <div class="card-body">
                    <form action="POST">
                        <div style="display: flex; justify-content: space-between;">
                            <div class="input-field" style="flex: 1">
                                <label> Nome</label>
                                <input type="text" name="name" class="">
                            </div>
                            <div class="input-field" style="flex: 1">
                                <label> Telemovel</label>
                                <input type="text" name="phone" class="">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="input-field" style="flex: 1">
                                <label> Email</label>
                                <input type="text" name="email" class="">
                            </div>
                            <div class="input-field" style="flex: 1">
                                <label> Password</label>
                                <input type="text" name="password" class="">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="input-field" style="flex: 1">
                                <label> Escolha o cargo</label>
                                <select name="" class="form-select" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; color: #333; width:20%">
                                    <option value="">Escolha o cargo</option>
                                    <option value="admin">Administrador</option>
                                    <option value="user">Cliente</option>
                                </select>
                                <button type="submit" name="salvarCliente" class="btn-edit" style="margin-left: 10px; float: right; font-weight: bold">Guardar</button>
                            </div>
                        </div>
                    </div>        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
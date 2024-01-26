<?php
    session_start();

    if (!isset($_SESSION["useruid"])) {
        header("location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
        <div class="shopping-cart">
                <a href="carrinho.php"><i class='bx bx-shopping-bag'></i></a>
        </div>

        <div class="sidebar">
            <div class="logo">
                <i class='bx bx-menu menu-icon'></i>
                <span class="logo-name">Pastelaria Crocancia</span>
            </div>
            <div class="sidebar-content">
                <ul class="lists">
                    <li class="list">
                        <a href="index.php" class="nav-link">
                            <i class='bx bx-home icon'></i>
                            <span class="link">Home</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="catalogo.php" class="nav-link">
                            <i class='bx bx-book icon'></i>
                            <span class="link">Catalogo</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="about.php" class="nav-link">
                            <i class='bx bx-info-circle icon'></i>
                            <span class="link">Sobre</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="contact.php" class="nav-link">
                            <i class='bx bx-envelope icon'></i>
                            <span class="link">Contacte Nos</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="login.php" class="nav-link">
                            <i class='bx bx-user icon'></i>
                            <span class="link">Perfil</span>
                        </a>
                    </li>
                </ul>
                <div class="bottom-content">
                    <li class="list">
                        <a href="" class="nav-link">
                            <i class='bx bxs-dashboard icon'></i>
                            <span class="link">Dashboard</span>
                        </a>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <section class="overlay"></section>

    <section class="profile">
        <div class="wrapper">
            <div class="left">
                <img src="img/icon/boy.png" alt="" width="100">
                <?php
                    include('/includes/profile.inc.php');
                    // Loop para obter os resultados da consulta
                    foreach ($user as $info) {
                    // Informações do cliente recebidas do banco de dados
                    $nome = $info[0];
                    $email = $info[1];
                    $telemovel = $info[2];
                    $morada = $info[3];
                ?>
            </div>
            <div class="right">
                <div class="info">
                    <h3>Informações</h3>
                    <div class="info_data">
                        <div class="data">
                            <h4>Nome:</h4>
                            <p><?php echo $nome; ?></p>
                        </div>
                        <div class="data">
                            <h4>Email:</h4>
                            <p><?php echo $email; ?></p>
                        </div>
                        <div class="data">
                            <h4>Telemovel:</h4>
                            <p><?php echo $telemovel; ?></p>
                        </div>
                        <div class="data">
                            <h4>Morada:</h4>
                            <p><?php echo $morada; ?></p>
                        </div>
                    </div>
                </div>
                <div class="btn">
                    <ul>
                        <a href="editProfile.php"><i class='bx bx-pencil icon'></i></a>
                        <a href="includes/logout.inc.php"><i class='bx bx-log-out icon'></i></a>
                    </ul>
                </div>
            </div>
            </div>
            <?php
            }
            ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
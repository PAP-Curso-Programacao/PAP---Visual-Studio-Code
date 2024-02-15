<?php
    session_start();

    if (!isset($_SESSION["userid"])) {
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
                    $telemovel = $info[3];
                    $morada = $info[2];
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

    <footer id="footer" class="footer">
        <div class="col">
            <h4>Contact</h4>
            <p><strong>Endereço:</strong> Largo Dr. Serafim Lopes Pereira, 2400-250 Leiria</p>
            <p><strong>Telemovel:</strong> 244 848 250</p>
            <p><strong>Horário:</strong> Segunda a Domingo: 9h até 18h</p>
            <div class="follow">
                <h4>Sigam nos</h4>
                <div class="icon">
                    <i class='bx bxl-facebook'></i>
                    <i class='bx bxl-twitter'></i>
                    <i class='bx bxl-instagram'></i>
                    <i class='bx bxl-pinterest' ></i>
                    <i class='bx bxl-youtube' ></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>Sobre</h4>
            <a href="about.php">Sobre Nos</a>
            <a href="about.php">Equipa</a>
            <a href="contact.php">Contacto</a>
        </div>

        <div class="col">
            <h4>Conta</h4>
            <a href="login.php">Login</a>
            <!--
            <a href="#">Ver carrinho</a>
            <a href="#">Acompanhar pedido</a>-->
        </div>

        <div class="col install">
            <h4>Instalar aplicação</h4>
            <p>Google Play ou App Store</p>
            <div class="row">
                <img src="img/pay/play.jpg" alt="">
                <img src="img/pay/app.jpg" alt="">
            </div>
            <p>Pagamento Seguros</p>
            <img src="img/pay/pay.png" alt="">
        </div>
        <div class="copyright">
            <p>© 2024 Todos os direitos reservados</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
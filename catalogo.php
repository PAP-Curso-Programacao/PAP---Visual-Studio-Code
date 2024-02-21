<?php
    session_start();

    $userLoggedIn = isset($_SESSION["userid"])
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
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
        <div class="shopping-cart">
            <i class='bx bx-shopping-bag' id="cart-icon"></i>
            <span id="cart-badge" class="cart-badge">0</span>
            <div class="cart">
                <h2 class="cart-title">O Seu Carrinho</h2>
                <div class="cart-content">
                        <div class="cart-box">

                        </div>
                </div>
                <div class="total">
                    <div class="total-title">Total</div>
                    <div class="total-price">$0</div>
                </div>
                <button type="button" class="btn-buy">Comprar Agora</button>
                <i class='bx bx-x' id="close-cart"></i>
            </div>
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
                        <?php if(isset($_SESSION['useruid']) && $_SESSION['useruid'] == true): ?>
                            <!-- Usuário está logado: Mostrar Perfil -->
                            <a href="profile.php" class="nav-link">
                            <i class='bx bx-user icon'></i>
                            <span class="link">Perfil</span>
                            </a>
                        <?php else: ?>
                            <!-- Usuário não está logado: Mostrar Login -->
                            <a href="login.php" class="nav-link">
                            <i class='bx bx-user icon'></i>
                            <span class="link">Login</span>
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="overlay"></section>
    
<section id="product1" class="product1">
    <h2>O nosso Catalogo</h2>
    <div class="pro-container">
        <?php
            include('/includes/catalogo.inc.php');

            $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

            foreach ($catalogos as $catalogo) {
                $imagem = htmlspecialchars($catalogo[0]);
                $nome = htmlspecialchars($catalogo[1]);
                $preco = htmlspecialchars($catalogo[2]);
        ?>
                <div class="pro">
                    <img src="<?php echo $imagem; ?>" alt="<?php echo $nome; ?>">
                    <div class="des">
                        <h5><?php echo $nome; ?></h5>
                        <h4><?php echo $preco; ?>€</h4>
                    </div>
                    <a href="#"><i class='bx bx-cart add-cart'></i></a>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
<script>

    var isUserLoggedIn = <?php echo json_encode(isset($_SESSION['userid']) && $_SESSION['useruid']); ?>;

</script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
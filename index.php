<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastelaria</title>
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
                            <span class="link">Inicio</span>
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
                            <span class="link">Contacto</span>
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
                <?php /* <div class="bottom-content">
                    <li class="list">
                        <a href="" class="nav-link">
                            <i class='bx bxs-dashboard icon'></i>
                            <span class="link">Dashboard</span>
                        </a>
                    </li>
                </div>*/?>
            </div>
        </div>
    </nav>

    <section class="overlay"></section>

    <section id="home" class="home">
        <div class="swiper home-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide" style="background: url(img/banner/banner1.jpg) no-repeat;">
                    <div class="content">
                        <h3>Pasteis Deliciosos</h3>
                        <a href="catalogo.php" class="btn-home">Comece agora</a>
                    </div>
                </div>
                <div class="swiper-slide slide" style="background: url(img/banner/banner2.jpg) no-repeat;">
                    <div class="content">
                        <h3>Sabores irresistíveis</h3>
                        <a href="catalogo.php" class="btn-home">Comece agora</a>
                    </div>
                </div>
                <div class="swiper-slide slide" style="background: url(img/banner/banner3.jpg) no-repeat;">
                    <div class="content">
                        <h3>Feitos com carinho</h3>
                        <a href="catalogo.php" class="btn-home">Comece agora</a>
                    </div>
                </div>
            </div>
            <div class="swiper-scrollbar"></div>
        </div>
    </section>    

    <section id="feature" class="feature">
        <div class="fe-box">
            <img src="img/icon/online.png" alt="">
            <h6>Online Order</h6>
        </div>
        <div class="fe-box">
            <img src="img/icon/free.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/icon/support.png" alt="">
            <h6>24h Support</h6>
        </div>
    </section>

    <section id="product" class="product">
        <h2>Os Nossos Produtos</h2>
        <p>Descubra um mundo de sabores refinados</p>
        <div class="pro-container">
        <?php
            include('/includes/catalogoIndex.inc.php');

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
                    <a href="catalogo.php"><i class='bx bx-cart cart'></i></a>
                </div>
        <?php
            }
        ?>
        </div>
        <div class="row-btn">
            <a href="catalogo.php" class="btn">Todos os produtos<i class='bx bxs-right-arrow'></i></a>
        </div>
    </section>

    <section id="review" class="review">
        <div class="container">
            <div class="board">
                <h2 class="text-light">Mensagens dos nossos clientes</h2>
                <p class="text-light">As melhores mensagens dos nossos clientes</p>

                <div class="swiper slider2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="flex">
                                <div class="comments">
                                    A pastelaria destaca-se pelo sabor dos pasteis. Cada mordida é uma explosão de sabores genuínos que me transporta para outra dimensão. Os funcionários são atenciosos e sempre dispostos a oferecer recomendações.
                                </div>
                                <div class="profile">
                                    <img src="img/review/1.jpg" alt="">
                                    <a href="#">Ricardo Duarte</a>
                                    <span>CEO Rissois</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="flex">
                                <div class="comments">
                                    Os pasteis da são deliciosos e o atendimento é impecável. Cada visita é uma experiência deliciosa e acolhedora. Os pasteis em si sao brutais e como podem ver voltarei com certeza aqui!                                
                                </div>
                                <div class="profile">
                                    <img src="img/review/3.jpeg" alt="">
                                    <a href="#">Rafael Cordeiro</a>
                                    <span>WEB Developer</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="flex">
                                <div class="comments">
                                    A pastelaria superou todas as minhas expectativas! A variedade de pasteis disponíveis é incrível, atendendo a todos os gostos. O cuidado com a qualidade dos ingredientes é evidente, resultando em pasteis frescos e deliciosos. Esta pastelaria tornou se a minha favorita na cidade!
                                </div>
                                <div class="profile">
                                    <img src="img/review/2.jpg" alt="">
                                    <a href="#">Eric Duarte</a>
                                    <span>BarMan</span>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
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
    <script src="js/script.js">
    </script>
</body>

</html>
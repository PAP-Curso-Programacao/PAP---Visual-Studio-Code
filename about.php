<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
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
                            <span class="link">Login</span>
                        </a>
                    </li>
                </ul
            </div>
        </div>
    </nav>

    <section class="overlay"></section>

    <section class="about-head">
        <img src="img/banner/about.jpg" alt="">
        <div>
            <h2>Quem Somos?</h2>
            <p>A Pastelaria Crocancia é mais do que apenas um estabelecimento, é um ponto de encontro para os amantes de sabores autênticos e experiências culinárias memoráveis. 
                Nascida da paixão pela confeitaria tradicional, a nossa pastelaria se destaca pelo compromisso em oferecer pasteis frescos, feitos diariamente com ingredientes de alta qualidade
            </p>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <div class="row">
                <div class="title">
                    <h1>A nossa equipa</h1>
                </div>
            </div>
            <div class="team-card" id="team-section">
                <div class="card">
                    <div class="image-section">
                        <img src="img/review/4.jpeg" alt="">
                    </div>
                    <div class="content">
                        <h3>Pedro Azevedo</h3>
                        <h4>CEO</h4>
                        <p>Força criativa, com um olhar sempre voltado para o futuro tem sido fundamental para a expansão e o sucesso contínuo da empresa</p>
                    </div>
                </div>
                <div class="card">
                    <div class="image-section">
                        <img src="img/icon/boy.png" alt="">
                    </div>
                    <div class="content">
                        <h3>Myro</h3>
                        <h4>CEO</h4>
                        <p>Expertise em finanças e operações, incansável na eficiência e sustentabilidade, garante que a empresa não apenas cresça, mas também mantenha uma base sólida e responsável</p>
                    </div>
                </div>
                <div class="card">
                    <div class="image-section">
                        <img src="img/review/3.jpeg" alt="">
                    </div>
                    <div class="content">
                        <h3>Rafael Cordeiro</h3>
                        <h4>WEB Developer</h4>
                        <p>Responsável por criar e manter o nosso site, garantir que seja não apenas visualmente atraente, mas também funcional e fácil de navegar</p>
                    </div>
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
    <script src="js/script.js"></script>
</body>

</html>
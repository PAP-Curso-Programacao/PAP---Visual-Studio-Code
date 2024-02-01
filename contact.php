<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
                </ul>
            </div>
        </div>
    </nav>

    <section class="overlay"></section>

    <section class="contact-details">
        <div class="details">
            <span>Entre em Contato</span>
            <h2>Visite a nossa pastelaria ou entre em contato connosco</h2>
            <h3>Pastelaria Crocancia</h3>
            <div>
                <li>
                    <i class='bx bx-map-alt'></i>
                    <p>Largo Dr. Serafim Lopes Pereira, 2400-250 Leiria</p>
                </li>
                <li>
                    <i class='bx bx-envelope'></i>
                    <p>geral@aeds.pt</p>
                </li>
                <li>
                    <i class='bx bx-phone'></i>
                    <p>244 848 250</p>
                </li>
                <li>
                    <i class='bx bx-time'></i>
                    <p>Segunda a Domingo: 9h até 18h</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3067.7139197461706!2d-8.814724525132519!3d39.74607659618627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22736babbc5e2b%3A0x3b1d0d49e6b4c24f!2sEscola%20Secund%C3%A1ria%20Domingos%20Sequeira!5e0!3m2!1spt-PT!2spt!4v1705481172643!5m2!1spt-PT!2spt" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section class="form-details">
        <form action="">
            <span>Deixe uma mensagem</span>
            <h2>Deliciamo-nos ao receber notícias vossas</h2>
            <input type="text" placeholder="Nome">
            <input type="text" placeholder="Email">
            <input type="text" placeholder="Subject">
            <textarea name="" id="" cols="30" rows="10" placeholder="Mensagem"></textarea>
            <div class="s-btnn">
                <a href="#">Submeter</a>
            </div>
        </form>

        <div class="people">
            <div>
                <img src="img/review/3.jpeg" alt="">
                <p><span>Rafael Cordeiro</span>Web Developer <br> Telemovel: +351 912 
                123 312 <br>Email: rafael@gmail.com</p>
            </div>
            <div>
                <img src="img/review/4.jpeg" alt="">
                <p><span>Pedro Azevedo</span>CEO<br> Telemovel: +351 912 
                123 312 <br>Email: pastelaria@gmail.com</p>
            </div>
            <div>
                <img src="img/icon/boy.png" alt="">
                <p><span>Volodymyr Krasnyak</span>CEO<br> Telemovel: +351 912 
                123 312 <br>Email: pastelaria@gmail.com</p>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
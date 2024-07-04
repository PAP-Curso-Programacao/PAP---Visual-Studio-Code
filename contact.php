<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
                            <span class="link">Contacto</span>
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
            <h2>Visite a nossa pastelaria ou entre em contacto connosco</h2>
            <h3>Pastelaria Crocancia</h3>
            <div>
                <li>
                    <i class='bx bx-map-alt'></i>
                    <p>Largo Dr. Serafim Lopes Pereira, 2400-250 Leiria</p>
                </li>
                <li>
                    <i class='bx bx-envelope'></i>
                    <p>pastelaria@gmail.com</p>
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
        <form action="includes/enviar-email.php" method="POST">
            <span>Deixe uma mensagem</span>
            <h2>Gostamos de receber notícias vossas</h2>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="email" placeholder="Email" required>
            <select name="subject" required>
                <option value="" disabled selected>Escolha um assunto</option>
                <option value="Reclamações">Reclamações</option>
                <option value="Elogios">Elogios</option>
                <option value="Outros">Outros</option>
            </select>
            <textarea name="message" id="" cols="30" rows="10" placeholder="Mensagem" required></textarea>
            <div class="btn">
                <button name="submitContact">Submeter</button>
            </div>
        </form>

        <div class="people">
            <div>
                <img src="img/review/3.jpeg" alt="">
                <p><span>Rafael Cordeiro</span>Web Developer <br> Telemovel: +351 923 
                321 123 <br>Email: rafael@gmail.com</p>
            </div>
            <div>
                <img src="img/review/4.jpeg" alt="">
                <p><span>Pedro Azevedo</span>CEO<br> Telemovel: +351 912 
                345 678 <br>Email: pastelaria@gmail.com</p>
            </div>
            <div>
                <img src="img/review/5.jpeg" alt="">
                <p><span>Volodymyr Krasnyak</span>CEO<br> Telemovel: +351 968 
                765 432 <br>Email: pastelaria@gmail.com</p>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
    <?php
    if (isset($_GET["error"])) {
        $errorMessage = "";
        $errorType = "Sucesso";

        switch ($_GET["error"]) {
            case "none":
                $errorMessage = "Gmail enviado com sucesso!";
                break;
            default:
                break;
        }

        if (!empty($errorMessage)) {
            echo '<script>';
echo 'document.addEventListener("DOMContentLoaded", function() {';
echo 'toastr.success("' . $errorMessage . '", "' . $errorType . '", {';
echo 'closeButton: false,';
echo 'progressBar: true,';
echo 'positionClass: "toast-top-right",';
echo 'timeOut: 3000,';
echo 'extendedTimeOut: 1000,';
echo 'preventDuplicates: false,';
echo 'newestOnTop: false,';
echo 'showDuration: 300,';
echo 'hideDuration: 300,';
echo 'showEasing: "swing",';
echo 'hideEasing: "linear",';
echo 'showMethod: "slideDown",';
echo 'hideMethod: "slideUp",';
echo 'toastClass: "custom-toast-class"';
echo '});';
echo '});';
echo '</script>';

        }
    }
    ?>
</body>
</html>
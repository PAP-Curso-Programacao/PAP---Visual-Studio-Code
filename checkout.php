<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.css" rel="stylesheet"/>
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
                </ul
            </div>
        </div>
    </nav>

    <section class="overlay"></section>

    <section class="payment">
        <div class="container">
            <form action="includes/process.encomenda.php" method="post" id="encomendaForm">
                <div class="row">
                    <div class="col">
                        <h3 class="title">Produtos</h3>
                            <div class="container">
                                <div class="cart-box">
                                <?php
    if (isset($_GET['details']) && isset($_GET['total'])) {
        $cartDetails = json_decode($_GET['details'], true);
        $total = $_GET['total'];

        foreach ($cartDetails as $item) {
            echo "
                <img src='{$item['productImg']}' alt='{$item['title']}' class='cart-img'>
                <div class='detail-box'>
                    <div class='cart-product-title'><h3 style='color: #efece3'>{$item['title']}</h3></div>
                    <div class='cart-price' style='color: #efece3'>{$item['price']}€</div>
                    <div class='cart-quantity-box'>
                        <label for='quantity' style='color: #efece3'>Quantidade:</label>
                        <input type='text' value='{$item['quantity']}' class='cart-quantity' id='quantity' disabled>
                    </div>
                </div>
            ";
        }
            ?></div>
                                        </div>
        <?php
        echo "
            <div class='total'>
                <div class='total-title' style='color: #efece3'>Total</div>
                <div style='color: #efece3'>€{$total}</div>
            </div>
        ";
    }
?>


                    </div>

                    <div class="col">
                        <h3 class="title">Pagamento</h3>
                        <div class="inputBox">
                            <span>Cartões: </span>
                            <img src="img/pay/card_img.png" alt="">
                        </div>
                        <div class="inputBox">
                            <span >Nome No Cartão:</span>
                            <input type="text" placeholder="Ex: Alberto Tavares" required>
                        </div>
                        <div class="inputBox">
                            <span>Número Do Cartão:</span>
                            <input type="number" placeholder="Ex: 1111-2222-3333" required>
                        </div>
                        <div class="inputBox">
                            <span>Mês Expirado:</span>
                            <input type="text" placeholder="Ex: Janeiro" required>
                        </div>

                        <div class="flex">
                            <div class="inputBox">
                                <span>Ano Expirado:</span>
                                <input type="number" placeholder="Ex: 2022" required>
                            </div>
                            <div class="inputBox">
                                <span>CVV :</span>
                                <input type="number" placeholder="Ex: 123" required>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#"><input type="submit" value="Concluir Pagamento" class="submit-btn"></a>
            </form>
        </div>
    </section>


    <?php
    if (isset($_GET["error"])) {
        $errorMessage = "";
        $errorType = "Sucesso";

        switch ($_GET["error"]) {
            case "none":
                $errorMessage = "Encomenda feita com sucesso!";
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
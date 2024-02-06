<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

    <section class="login">
        <div class="form_container">
           <div class="form login_form">
                <form method="post" action="includes/process_login.php">
                    <h2>Login</h2>
                    <div class="input_box">
                        <input type="email"  name="email" id="loginEmail" class="placeholder" placeholder="Insira o seu email" required>
                        <i class='bx bx-envelope email'></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" id="LoginPassword" class="placeholder" placeholder="Insira o a sua password" required>
                        <i class='bx bx-lock-alt password'></i>
                        <i class='fa-regular fa-eye-slash pw_hide'></i>
                    </div>

                    <div class="option_field">
                        <span class="checkbox">
                            <input type="checkbox" id="check">
                            <label for="check">Relembrar me</label>
                        </span>
                        <a href="#" class="forgot_pw">Forgot password</a>
                    </div>

                    <button class="button">Entrar Agora</button>

                    <div class="login_signup">
                        Não tem uma conta? <a href="#" id="signup">Registar</a>
                    </div>
                </form>
           </div>
           <?php
            if (isset($_GET["error"])) {
                $errorMessage = "";
                $errorType = "Atenção";

                switch ($_GET["error"]) {
                    case "wronglogin":
                        $errorMessage = "Dados inseridos não encontrados!";
                        break;
                    case "emptyinput":
                        $errorMessage = "Preencha todos os campos!";
                        break;
                    default:
                        break;
                }

                if (!empty($errorMessage)) {
                    echo '<script>';
                    echo 'document.addEventListener("DOMContentLoaded", function() {';
                    echo 'toastr.warning("' . $errorMessage . '", "' . $errorType . '", {
            closeButton: false,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000,
            extendedTimeOut: 1000,
            preventDuplicates: false,
            newestOnTop: false,
            showDuration: 300,
            hideDuration: 300,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "slideDown",
            hideMethod: "slideUp",
            toastClass: "custom-toast-class"
        });';
                    echo '});';
                    echo '</script>';
                }
            }
            ?>

            <div class="form signup_form">
                <form method="post" action="includes/process_register.php">
                    <h2>Registar</h2>
                    <div class="input_box">
                        <input type="text" name="name" id="name" class="placeholder" placeholder="Insira o seu nome" required>
                        <i class='bx bx-user user'></i>
                    </div>
                    <div class="input_box">
                        <input type="email" name="email" id="signupEmail" class="placeholder" placeholder="Insira o seu gmail" required>
                        <i class='bx bx-envelope email'></i>
                    </div>
                    <div class="input_box">
                        <input type="text" name="telemovel" id="telemovel" class="placeholder" placeholder="Insira o seu telemovel" required>
                        <i class='bx bx-phone phone'></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" id="password" class="placeholder" placeholder="Criar a sua password" required>
                        <i class='bx bx-lock-alt password'></i>
                        <i class='fa-regular fa-eye-slash pw_hide'></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="confirmPassword" id="confirmPassword" class="placeholder" placeholder="Confirmar password" required>
                        <i class='bx bx-lock-alt password'></i>
                        <i class='fa-regular fa-eye-slash pw_hide'></i>
                    </div>

                    <button class="button">Registar Agora</button>

                    <div class="login_signup">
                        Já tem uma conta? <a href="#" id="login">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyinput"){
                $errorMessage = "Preencha todos os campos!";
            }
            else if($_GET["error"] == "wronglogin"){
                $errorMessage = "Informacao do login incorreta!";
            }
            else if($_GET["error"] == "invalidemail"){
                $errorMessage = "Escolha um gmail diferente!";
            }
            else if($_GET["error"] == "invalidphone"){
                $errorMessage = "Escolha um numero de telemovel diferente!";
            }
            else if($_GET["error"] == "passwordsdontmatch"){
                $errorMessage = "Passwords nao coincidem!";
            }
            else if($_GET["error"] == "stmtfailed"){
                $errorMessage = "Aconteceu algo de errado, tente novamente!";
            }
            if (!empty($errorMessage)) {
                echo '<script>';
                echo 'document.addEventListener("DOMContentLoaded", function() {';
                echo 'toastr.warning("' . $errorMessage . '", "' . $errorType . '", {
                closeButton: false,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 3000,
                extendedTimeOut: 1000,
                preventDuplicates: false,
                newestOnTop: false,
                showDuration: 300,
                hideDuration: 300,
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "slideDown",
                hideMethod: "slideUp",
                toastClass: "custom-toast-class"
            });';
                echo '});';
                echo '</script>';
            }
        }
    ?>
     <?php
                        if (isset($_GET["error"])) {
                            $errorMessage = "";
                            $errorType = "Sucesso";

                            switch ($_GET["error"]) {
                                case "none":
                                    $errorMessage = "login feito com sucesso!";
                                    break;
                                default:
                                    break;
                            }
                        }   
                        ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
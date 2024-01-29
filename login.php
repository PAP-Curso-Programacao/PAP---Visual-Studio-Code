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
                            <label for="check">Relembar me</label>
                        </span>
                        <a href="#" class="forgot_pw">Forgot password</a>
                    </div>

                    <button class="button">Entrar Agora</button>

                    <div class="login_signup">
                        Não tem uma conta? <a href="#" id="signup">Registar</a>
                    </div>
                </form>
           </div>

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
                echo "<p>Preencha todos os campos!</p>";
            }
            else if($_GET["error"] == "invalidname"){
                echo "<p>Escolha um nome diferente!</p>";
            }
            else if($_GET["error"] == "wronglogin"){
                echo "<p>Informacao do login incorreta!</p>";
            }
            else if($_GET["error"] == "invalidemail"){
                echo "<p>Escolha um gmail diferente!</p>";
            }
            else if($_GET["error"] == "passwordsdontmatch"){
                echo "<p>Passwords nao coincidem!</p>";
            }
            else if($_GET["error"] == "stmtfailed"){
                echo "<p>Aconteceu algo de errado, tente novamente!</p>";
            }
            else if($_GET["error"] == "none"){
                echo "<p>Ja se encontra logado!</p>";
            }
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
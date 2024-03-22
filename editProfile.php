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
    <title>Editar Profile</title>
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

    <section class="profile">
    <div class="wrapper">
            <?php
                include('/includes/profile.inc.php');
                foreach ($user as $info) {
                $nome = $info[0];
                $email = $info[1];
                $telemovel = $info[2];
                $image_perfil = $info[3];
            ?>
        <div class="left">
            <form action="includes/editProfile.inc.php" method="post" enctype="multipart/form-data">
                <img src="<?php echo $image_perfil; ?>" alt="" width="100">
                <label for="fileInput" class="label-ABC">Atualizar Foto</label>
                <input class="input-btn" name="profile_image" type="file" accept="image/*" id="fileInput">
                </div>
        <div class="right">
            <div class="info">
                <h3>Informações</h3>
                    <div class="info_data">
                            <div class="data">
                                <h4>Nome:</h4>
                                <p><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($nome); ?>"></p>
                            </div>
                            <div class="data">
                                <h4>Email:</h4>
                                <p><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"></p>
                            </div>
                            <div class="data">
                                <h4>Telemovel:</h4>
                                <p><input type="text" id="telemovel" name="telemovel" value="<?php echo htmlspecialchars($telemovel); ?>"></p>
                            </div>
                    </div>
                </div>
                <div class="btn">
                    <ul>
                        <a href="index.php"><i class='bx bx-arrow-back icon'></i></a>
                        <button type="submit" id="btnSubmit" class="s-btnn"><i class='bx bx-refresh icon'></i></button>
                        <a href="includes/logout.inc.php"><i class='bx bx-log-out icon'></i></a>
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
</div>
</section>
<?php
  if (isset($_GET["error"])) {
    $errorMessage = "";
    $errorType = "Atenção";

    switch ($_GET["error"]) {
      case "ivalidname":
        $errorMessage = "Nome inválido!";
        break;
      case "ivalidphone":
        $errorMessage = "Número de telemovel inválido!";
        break;
      case "userexists":
        $errorMessage = "Nome ou Telemovel já existem!";
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
        echo 'toastr.error("' . $errorMessage . '", "' . $errorType . '", {
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
    var fileInput = document.getElementById('fileInput');
    var imageToChange = document.querySelector('.left img'); // Assume que a imagem a ser mudada está dentro de um div com classe 'left'

    fileInput.addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                imageToChange.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });
    </script>
</body>
</html>
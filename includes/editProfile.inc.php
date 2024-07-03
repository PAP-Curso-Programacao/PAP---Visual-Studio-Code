<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_SESSION['userid'];
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $telefone = $_POST['telemovel'];

    require_once 'conn.php';
    require_once 'functions.inc.php';

    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
      $targetDir = "../img/profiles/";
      $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
  
      $allowedExtensions = array("jpg", "jpeg", "png", "gif");
      if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
          $imagem_perfil_nome = basename($_FILES["profile_image"]["name"]);
          $imagem_perfil_caminho = ".\img\profiles\\" . $imagem_perfil_nome;
          
          updateImage($db, $_SESSION["userid"], $imagem_perfil_caminho);
          header("location: ../editProfile.php?error=none");
  
          exit();
        }
      }
    }
  
    // Verificar se o email já existe para outro usuário
    $stmt = $db->prepare("SELECT * FROM Clientes WHERE Email = :email AND ID != :id");
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':id', $cliente_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($result->fetchArray()) {
        header("Location: ../editProfile.php?error=invalidemail");
        exit();
    }


    $stmt = $db->prepare("SELECT * FROM Clientes WHERE Telefone = :telefone AND ID != :id");
    $stmt->bindValue(':telefone', $telefone, SQLITE3_TEXT);
    $stmt->bindValue(':id', $cliente_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($result->fetchArray()) {
        header("Location: ../editProfile.php?error=invalidphone");
        exit();
    }

    if (strlen($telefone) !== 9) {
      header("Location: ../editProfile.php?error=invalidphone");
      exit();
    }

    if (emptyInputProfile($db, $nome, $telefone, $email) !== false) {
        header("location: ../editProfile.php?error=emptyinput");
        exit();
      }
      if (invalidName($nome)) {
        header("location: ../editProfile.php?error=invalidname");
        exit(); // Importante: garantir que o script pare aqui após o redirecionamento
    }
      if (userExistsProfile($db, $_SESSION["userid"], $email, $telefone) !== false) {
        header("location: ../editProfile.php?error=userexists");
        exit();
      }
    
      updateUser($db, $_SESSION["userid"], $nome, $email, $imagem_perfil_caminho);
    } else {
      header("location: ../login.php");
      exit();
}
?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $morada = $_POST['morada'];
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
  

    if (emptyInputProfile($db, $nome, $telefone, $email) !== false) {
        header("location: ../editProfile.php?error=emptyinput");
        exit();
      }
      if (invalidName($nome) !== false) {
        header("location: ../editProfile.php?error=ivalidnome");
        exit();
      }
      if (invalidPhone($telefone) !== false) {
        header("location: ../editProfile.php?error=ivalidphone");
        exit();
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

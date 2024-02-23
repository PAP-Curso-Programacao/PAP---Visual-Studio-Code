<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $morada = $_POST['morada'];
    $telefone = $_POST['telemovel'];

    require_once 'conn.php';
    require_once 'functions.inc.php';

    if (emptyInputProfile($nome, $telefone, $email) !== false) {
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
    
      updateUser($db, $_SESSION["userid"],$morada);
    } else {
      header("location: ../login.php");
      exit();
}
?>

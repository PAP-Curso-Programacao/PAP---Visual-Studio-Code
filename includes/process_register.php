<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $telemovel = $_POST['telemovel'];
  $confirmPassword = $_POST['confirmPassword'];

  require_once 'conn.php';
  require_once 'functions.inc.php';

  if (emptyInputSignup($nome, $email, $telemovel, $password, $confirmPassword) !== false) {
    header("location: ../login.php?error=emptyinput");
    exit();
  }
  if (invalidName($nome) !== false) {
    header("location: ../login.php?error=invalidname");
    exit();
  }
  if (invalidEmail($email) !== false) {
    header("location: ../login.php?error=invalidemail");
    exit();
  }
  if (invalidPhone($telemovel) !== false) {
    header("location: ../login.php?error=invalidphone");
    exit();
  }
  if(pwdMatch($password, $confirmPassword) !== false){
    header("location: ../login.php?error=passwordsdontmatch");
    exit();
  }
  if(userExists($db, $email, $telemovel) !== false){
    header("location: ../login.php?error=userexists");
    exit();
  }
  createUser($db,$nome,$email,$password,$telemovel, $dataRegisto);
} else {
  header("location: ../login.php");
  exit();
}
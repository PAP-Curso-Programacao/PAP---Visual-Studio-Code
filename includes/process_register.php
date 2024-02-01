<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  require_once 'conn.php';
  require_once 'functions.inc.php';

  if (emptyInputSignup($nome, $email, $password, $confirmPassword) !== false) {
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
  if(pwdMatch($password, $confirmPassword) !== false){
    header("location: ../login.php?error=passwordsdontmatch");
    exit();
  }
  if(userExists($db, $nome, $email) !== false){
    header("location: ../login.php?error=nometaken");
    exit();
  }
  createUser($db,$nome,$email,$password);
} else {
  header("location: ../login.php");
  exit();
}
<?php
    include('conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'conn.php';
    require_once 'functions_inc.php';

    if (emptyInputLogin($email, $password) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($db, $email, $password);
    } else {
    header("location: ../php/login.php");
    exit();
}
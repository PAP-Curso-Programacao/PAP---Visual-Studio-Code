<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   // Obtém os dados do formulário
    $nome = $_POST['name'];
    $telefone = $_POST['phone'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $cargo = $_POST['role'];

    require_once 'conn.php';
    require_once 'functions.inc.php';

    $target_dir = "../img/profiles/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Verifica o tamanho do arquivo
    if ($_FILES["profile_image"]["size"] > 500000) {
        echo "Desculpe, o arquivo é muito grande.";
        $uploadOk = 0;
    }

    // Permite determinados formatos de arquivo
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        $uploadOk = 0;
    }

    // Verifica se $uploadOk está definido como 0 por algum erro
    if ($uploadOk == 0) {
        echo "Desculpe, seu arquivo não foi enviado.";
    // Se tudo estiver ok, tenta fazer o upload do arquivo
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            echo "O arquivo ". htmlspecialchars( basename( $_FILES["profile_image"]["name"])). " foi enviado.";
            addUser($db, $nome, $email, $senha, $telefone, $cargo, $target_file);
        } else {
            echo "Desculpe, houve um erro ao enviar seu arquivo.";
            header("location: ../admin.dashboard.php");
            exit();
        }
    }
}
?>

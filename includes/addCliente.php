<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['name'];
    $telefone = $_POST['phone'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $cargo = $_POST['role'];
    $profile_image = $_FILES['profile_image'];

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
                $imagem_perfil_caminho = "./img/profiles/" . $imagem_perfil_nome;

                // Chame sua função para adicionar o cliente ao banco de dados
                if (addUser($db, $nome, $email, $senha, $telefone, $cargo, $imagem_perfil_caminho)) {
                    echo "Cliente cadastrado com sucesso.";
                    // Redirecionar ou exibir mensagem de sucesso
                } else {
                    echo "Erro ao cadastrar o cliente.";
                }
            } else {
                echo "Erro ao fazer o upload da imagem.";
            }
        } else {
            echo "Formato de imagem não permitido. Apenas JPG, JPEG, PNG e GIF são permitidos.";
        }
    }
}
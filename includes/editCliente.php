<?php
require_once 'conn.php'; // Ensure this file correctly sets up the $conn variable
require_once 'functions.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ID'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $profile_image = $_FILES['profile_image'];

    // Retrieve the current client data
    $current_data = getClienteById($conn, $id);

    if (!$current_data) {
        echo "Cliente não encontrado.";
        exit;
    }

    // Update password if provided
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password = $current_data['Senha'];
    }   

    if (isset($profile_image) && $profile_image['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../img/profiles/";
        $targetFile = $targetDir . basename($profile_image['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Verifica se é uma imagem
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $allowedExtensions)) {
            if (move_uploaded_file($profile_image['tmp_name'], $targetFile)) {
                // Atualiza o caminho da imagem no banco de dados
                $imagem_perfil_caminho = ".\img\profiles\\" . basename($profile_image['name']);
                updateProfileImage($conn, $id, $imagem_perfil_caminho);
            } else {
                echo "Erro ao fazer o upload da imagem.";
                exit;
            }
        } else {
            echo "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
            exit;
        }
    }

    $sql = "UPDATE Clientes SET Nome = ?, Telefone = ?, Email = ?, Senha = ?, `role` = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        error_log("Failed to prepare the SQL statement: " . $conn->error);
        echo "Erro ao atualizar o cliente.";
        exit;
    }

    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $phone);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $password);
    $stmt->bindParam(5, $role);
    $stmt->bindParam(6, $id);

    if (!$stmt->execute()) {
        error_log("Failed to execute the statement: " . $stmt->error);
        echo "Erro ao atualizar o cliente.";
        exit;
    }

    echo "Cliente atualizado com sucesso.";
    header("Location: ../admin.clientes.php");
    exit;
}
?>
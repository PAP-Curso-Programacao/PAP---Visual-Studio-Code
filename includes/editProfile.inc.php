<?php
session_start();

if (!isset($_SESSION["useruid"])) {
    header("location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conn.php';
    require_once 'functions.inc.php';

    $nome = $_POST['name'];
    $email = $_POST['email'];
    $telemovel = $_POST['telemovel'];
    $morada = $_POST['morada'];
    $userId = $_SESSION['userid']; // Supondo que o ID do usuário está armazenado na sessão

    // Validação e limpeza dos dados (opcional, mas recomendado)
    // ...

    // Query de atualização
    $sql = "UPDATE Clientes SET Nome = ?, Email = ?, Telefone = ?, Morada = ? WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql); // Altere para sua conexão e função de preparação de query
    if (!$stmt) {
        header("Location: ../editProfile.php?error=sqlerror");
        exit();
    }

    // Vincula parâmetros à declaração preparada
    mysqli_stmt_bind_param($stmt, "sssii", $nome, $email, $telemovel, $morada, $userId);

    // Executa a declaração
    if (!mysqli_stmt_execute($stmt)) {
      // Imprime o erro
      echo "Erro na execução da query: " . mysqli_stmt_error($stmt);
      exit();
  } else {
      // Redireciona após a atualização bem-sucedida
      header("Location: ../editProfile.php?update=success");
      exit();
  }
}
?>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['name'];
    $preco = $_POST['preco'];
    $desc = $_POST['desc'];
    $stock = $_POST['stock'];

    require_once 'conn.php';
    require_once 'functions.inc.php';

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
      $targetDir = "../img/products/";
      $targetFile = $targetDir . basename($_FILES["image"]["name"]);
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
  
      $allowedExtensions = array("jpg", "jpeg", "png", "gif");
      if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
          $imagem_perfil_nome = basename($_FILES["image"]["name"]);
          $imagem_produto_caminho = ".\img\products\\" . $imagem_perfil_nome;
          
          addProduto($db, $nome, $preco, $desc, $stock, $imagem_produto_caminho);
          } else {
              echo "Erro ao conectar ao banco de dados.";
          }
      } else {
          echo "Erro ao fazer o upload da imagem.";
      }
  } else {
      echo "Imagem do produto não encontrada.";
  }
} else {
  echo "Formulário não submetido corretamente.";
}

?>
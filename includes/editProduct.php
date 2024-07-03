<?php
session_start();

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verifica se o ID do produto foi enviado
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        
        // Aqui você deve receber os outros campos do formulário
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $descricao = $_POST['descricao'];
        $stock = $_POST['stock'];

        require_once 'conn.php';
        require_once 'functions.inc.php';
        
        // Processar a imagem, se ela foi enviada
        if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
            $targetDir = "../img/products/";
            $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");
            if (in_array($imageFileType, $allowedExtensions)) {
              if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                $imagem_perfil_nome = basename($_FILES["profile_image"]["name"]);
                $imagem_perfil_caminho = ".\img\products\\" . $imagem_perfil_nome;
                
                updateImageProduct($db, $id, $imagem_perfil_caminho);
                header("location: ../admin.editProducts.php?error=none");
        
                exit();
              }
            }
          }
    
        atualizarProduto($db, $id, $nome, $preco, $descricao, $stock, $imagem_perfil_caminho);
        
        // Redirecionar de volta para a página de administração ou outra página de destino
        header("Location: ../admin.products.php?error=none");
        exit();
    } else {
        // Caso o ID do produto não tenha sido enviado corretamente
        header("Location: ../admin.products.php?error=noid");
        exit();
    }
}
?>

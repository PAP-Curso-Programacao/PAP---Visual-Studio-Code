<?php
    include('/includes/conn.php');
    
    // Modifica a consulta SQL para buscar apenas os primeiros 3 produtos
    $result = $db->query('SELECT * FROM Produtos ORDER BY RANDOM() LIMIT 3');
    
    $catalogos = array();
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $catalogos[] = array($row['Imagem'], $row['Nome'], $row['Preço']);
    }
?>

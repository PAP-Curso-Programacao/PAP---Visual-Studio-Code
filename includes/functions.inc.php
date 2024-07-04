<?php
    function emptyInputSignup($nome, $email, $password, $confirmPassword){
        $result;
        if(empty($nome) || empty($email) || empty($password) || empty($confirmPassword)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }

    function invalidName($nome){
        $result;
        if (!preg_match("/^[a-zA-Z _]*$/", $nome)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }

    function invalidEmail($email){
        $result;
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }

    function invalidPhone($telefone){
        return !preg_match("/^[0-9]{9}$/", $telefone);
    }

    function pwdMatch($password, $confirmPassword){
        $result;
        if($password !== $confirmPassword){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    
    function isEmptyCart($cart) {
        $result = empty($cart);
        return $result;
    }    

    function userExists($db, $email, $telefone){   
        $sql = "SELECT * FROM Clientes WHERE Email = :email OR Telefone = :telefone;";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
    
        // Associe os valores usando os nomes dos placeholders
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':telefone', $telefone, SQLITE3_TEXT);
        $result = $stmt->execute();
    
        if ($row = $result->fetchArray()) {
            return $row;
        } else {
            return false;
        }
    }
    
    

    function createUser($db, $nome, $email, $password, $telefone, $dataRegisto){
        $dataRegisto = $dataRegisto ?: date('Y-m-d');

        $sql = "INSERT INTO Clientes (Nome, Email, Senha, Telefone, dataRegisto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        };
        
        $options = [
            'cost' => 12
        ];

        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $options);

        $stmt->bindValue(1, $nome, SQLITE3_TEXT);
        $stmt->bindValue(2, $email, SQLITE3_TEXT);
        $stmt->bindValue(3, $passwordHash, SQLITE3_TEXT);
        $stmt->bindValue(4, $telefone, SQLITE3_TEXT);
        $stmt->bindValue(5, $dataRegisto, SQLITE3_TEXT);
        $result = $stmt->execute();
    
        if ($result) {
            header("location: ../login.php?error=none");
        } else {
            header("location: ../login.php?error=stmtfailed");
        }
        exit();
    }

    function emptyInputLogin($email, $password){
    $result = false;
    if (empty($email) || empty($password)) {
        $result = true;
    }
    return $result;
    }
    
    function emailExists($db, $email) {
        $sql = "SELECT * FROM Clientes WHERE Email = ?;"; // Assumindo que 'users' é o nome da sua tabela de usuários
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
    
        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        } else {
            return false;
        }
    
        mysqli_stmt_close($stmt);
    }
    

    function loginUser($db, $email, $password){
        // Verifica se os dados de login correspondem ao do administrador
        if ($email === "admin@gmail.com" && $password === "admin") {
            // Inicia sessão para admin
            session_start();
            $_SESSION["userid"] = "admin"; // Atribua um identificador único para a sessão do admin
            $_SESSION["useruid"] = "admin"; // Atribua o nome de usuário para a sessão
            header("location: ../admin.dashboard.php"); // Redireciona para o dashboard do admin
            exit();
        }
    
        // Se não for o admin, continua com o processo normal de login
        $userExists = userExists($db, $email, $email);
    
        if ($userExists === false) {
            header("location: ../login.php?error=emailnotfound");
            exit();
        }
    
        // Obtenha a senha armazenada no banco de dados
        $storedPassword = $userExists["Senha"];
    
        // Verifica a senha fornecida com a senha armazenada
        if (!password_verify($password, $storedPassword)) {
            // Se a senha não corresponder, redirecione para a página de login com um erro
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        
        // Inicia sessão para usuário normal
        session_start();
        $_SESSION["userid"] = $userExists["ID"];
        $_SESSION["useruid"] = $userExists["Email"];
        header("location: ../index.php?error=none");
        exit();
}    

function emptyInputProfile($db, $nome, $email, $telefone)
{
    $userId = $_SESSION["userid"];

    $sql = "SELECT * FROM Clientes WHERE ID = :userid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userid', $userId, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $user = array();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $user = array(
            'nome' => $row['Nome'],
            'email' => $row['Email'],
            'telefone' => $row['Telefone'],
            'imagem_perfil' => $row['Perfil']
        );
    }

    if (userExistsProfile($db, $userId, $nome, $email, $telefone) !== false) {
        header("location: ../editProfile.php?error=userexists2");
        exit();
    }

    if (empty($nome)) {
        $nome = $user['Nome'];
    }

    if (empty($email)) {
        $email = $user['Email'];
    }

    if (empty($telefone)) {
        $telefone = $user['Telefone'];
    }

    $imagem_perfil = $user['Perfil'];

    updateUser($db, $userId, $nome, $email, $telefone, $imagem_perfil);
    return false;
}

    function userExistsProfile($db, $ID, $email, $telefone){
    $sql = "SELECT * FROM Clientes WHERE (email = :Email OR telefone = :Telefone) AND ID != :ID";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        $errorMessage = $db->lastErrorMsg();  // Obter mensagem de erro específica do SQLite
        header("location: ../editProfile.php?error=stmtfailed&message=" . urlencode($errorMessage));
        exit();
    }

    $stmt->bindParam(':Email', $email, SQLITE3_TEXT);
    $stmt->bindParam(':Telefone', $telefone, SQLITE3_TEXT);
    $stmt->bindParam(':ID', $ID, SQLITE3_INTEGER);

    $result = $stmt->execute();

    $row = $result->fetchArray(SQLITE3_ASSOC);

    $stmt->close();

    if ($row) {
        // Usuário com o mesmo username ou phoneNumber já existe, mas não é o próprio usuário
        return $row;
    } else {
        // Nenhum conflito, pode atualizar o perfil
        return false;
    }
}

function updateImage($db, $ID, $imagem_perfil_caminho)
{
    $sql = "UPDATE Clientes SET Perfil = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        header("location: ../editProfile.php?error=stmtfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->bindParam(1, $imagem_perfil_caminho, SQLITE3_TEXT);
    $stmt->bindParam(2, $ID, SQLITE3_INTEGER);

    $result = $stmt->execute();

    if (!$result) {
        header("location: ../editProfile.php?error=stmtexecutionfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->close();
}

function updateImageProduct($db, $ID, $imagem_perfil_caminho)
{
    $sql = "UPDATE Produtos SET Imagem = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        header("location: ../editProduct.php?error=stmtfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->bindParam(1, $imagem_perfil_caminho, SQLITE3_TEXT);
    $stmt->bindParam(2, $ID, SQLITE3_INTEGER);

    $result = $stmt->execute();

    if (!$result) {
        header("location: ../editProduct.php?error=stmtexecutionfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->close();
}

function updateUser($db, $ID, $nome, $email, $telefone)
{
    $sql = "UPDATE Clientes SET Nome = ?, Email = ?, Telefone = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        header("location: ../editProfile.php?error=stmtfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->bindParam(1, $nome, SQLITE3_TEXT);
    $stmt->bindParam(3, $email, SQLITE3_TEXT);
    $stmt->bindParam(2, $telefone, SQLITE3_TEXT);
    $stmt->bindParam(4, $ID, SQLITE3_INTEGER);

    $result = $stmt->execute();

    if (!$result) {
        header("location: ../editProfile.php?error=stmtexecutionfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->close();

    header("location: ../editProfile.php?error=none");
    exit();
}
function createOrder($db, $clienteID, $userid) {
    $status = 0; // Se você deseja definir o status aqui, não é necessário passá-lo como parâmetro
    $dataHora = date('Y-m-d'); // Formato correto para DateTime

    // Consulta SQL para obter o nome do cliente
    $sql_cliente = "SELECT Nome FROM Clientes WHERE ID = ?";
    $stmt_cliente = $db->prepare($sql_cliente);
    $stmt_cliente->bindParam(1, $clienteID, SQLITE3_INTEGER);
    
    $result_cliente = $stmt_cliente->execute();
    if (!$result_cliente) {
        die("Erro ao consultar o nome do cliente: " . $db->lastErrorMsg());
    }

    $row = $result_cliente->fetchArray(SQLITE3_ASSOC);
    if (!$row) {
        die("Cliente com ID $clienteID não encontrado.");
    }
    
    $nomeCliente = $row['Nome'];

    // Consulta SQL para inserir o pedido
    $sql_pedido = "INSERT INTO Pedidos (ClienteID, Nome, Email, DataPedida) VALUES (?, ?, ?, ?)";
    $stmt_pedido = $db->prepare($sql_pedido);
    
    if (!$stmt_pedido) {
        die("Erro na preparação da declaração para inserir o pedido: " . $db->lastErrorMsg());
    }

    // Bind dos parâmetros para a inserção do pedido
    $stmt_pedido->bindParam(1, $clienteID, SQLITE3_INTEGER);
    $stmt_pedido->bindParam(2, $nomeCliente, SQLITE3_TEXT);
    $stmt_pedido->bindParam(3, $userid, SQLITE3_TEXT); // Supondo que você tenha um $email para vincular aqui
    $stmt_pedido->bindParam(4, $dataHora, SQLITE3_TEXT); // Mudado para SQLITE3_FLOAT se Total pode ser decimal

    if (!$stmt_pedido->execute()) {
        die("Erro na execução da declaração para inserir o pedido: " . $db->lastErrorMsg());
    }

    $lastId = $db->lastInsertRowID();

    // Não precisa fechar o stmt em SQLite3, mas se estiver usando PDO: $stmt_pedido = null;

    return $lastId;
}

function getProductIdByName($db, $nomeProduto)
{
    $nomeProduto = trim($nomeProduto);
    $sql = "SELECT ID FROM Produtos WHERE Nome = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da declaração: " . $db->lastErrorMsg());
    }

    $stmt->bindParam(1, $nomeProduto, SQLITE3_TEXT);
    $result = $stmt->execute();
    if (!$result) {
        die("Erro na execução da declaração: " . $db->lastErrorMsg());
    }

    $row = $result->fetchArray(SQLITE3_ASSOC);

    if ($row === false) {
        echo "Produto não encontrado para o nome: $nomeProduto<br>";
        $stmt->close();
        return null;
    }

    $idProduto = $row['ID']; // Corrigido para retornar o ID do produto, não o nome
    $stmt->close();

    return $idProduto;
}


function createOrderLine($db, $encomendaId, $productsInCart){
    // Preparação da declaração fora do loop
    $sql = "INSERT INTO ItensPedido (PedidoID, ProdutoID, Quantidade, PreçoUni) VALUES (?, ?, ?, (SELECT Preço FROM Produtos WHERE ID = ?))";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        echo "Erro: Preparação da declaração falhou.<br>";
        return false;
    }

    foreach ($productsInCart as $index => $item) {
        // Verifique se todas as informações necessárias estão presentes
        if (!isset($item['title'], $item['quantity'])) {
            echo "Erro: Variáveis necessárias ausentes em um item do carrinho<br>";
            continue; // Pule para a próxima iteração do loop
        }

        $produtoNome = $item['title'];
        $quantidade = $item['quantity'];

        $idProduto = getProductIdByName($db, $produtoNome);
        echo "ID do Produto para $produtoNome: $idProduto<br>";

        if ($idProduto === null) {
            continue;
        }

        // Bind dos parâmetros usando variáveis
        $stmt->bindValue(1, $encomendaId, SQLITE3_INTEGER);
        $stmt->bindValue(2, $idProduto, SQLITE3_INTEGER);
        $stmt->bindValue(3, $quantidade, SQLITE3_INTEGER);
        $stmt->bindValue(4, $idProduto, SQLITE3_INTEGER); // O mesmo ID do produto para a subconsulta

        // Execute a declaração dentro do loop
        $result = $stmt->execute();

        if (!$result) {
            echo "Erro: Execução da declaração falhou para o item: $produtoNome" . $db->lastErrorMsg();
        }
    }

    $stmt->close();
    return $encomendaId;
}

function getRecentUsers($db, $limit = 5) {
    $sql = "SELECT ID, Nome, Email, dataRegisto, Perfil FROM Clientes ORDER BY dataRegisto DESC LIMIT ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        return false; // Ou trate o erro conforme sua lógica de aplicação
    }

    // No SQLite3, os índices dos parâmetros começam em 1
    $stmt->bindValue(1, $limit, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $recentUsers = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $recentUsers[] = $row;
    }
    
    return $recentUsers;
}

function contarProdutos($db) {
    $sql = "SELECT COUNT(*) AS total FROM Produtos";
    $result = $db->query($sql);
    $row = $result->fetchArray();
    return $row['total'];
}

function contarClientes($db) {
    $sql = "SELECT COUNT(*) AS total FROM Clientes";
    $result = $db->query($sql);
    $row = $result->fetchArray();
    return $row['total'];
}

function contarPedidos($db) {
    $sql = "SELECT COUNT(*) AS total FROM Pedidos";
    $result = $db->query($sql);
    $row = $result->fetchArray();
    return $row['total'];
}


function getRecentOrders($db, $limit = 5) {
    $sql = "SELECT ID, ClienteID, Email, DataPedida FROM Pedidos ORDER BY DataPedida DESC LIMIT ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        return []; // Ou trate o erro conforme sua lógica de aplicação
    }

    // No SQLite3, os índices dos parâmetros começam em 1
    $stmt->bindValue(1, $limit, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $recentOrders  = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $recentOrders[] = $row;
    }
    
    return $recentOrders;
}

function paginationProducts($db, $currentPage = 1, $rowsPerPage = 5) {
    // Contar o total de produtos
    $result = $db->query('SELECT COUNT(*) as count FROM Produtos');
    $row = $result->fetchArray();
    $totalProducts = $row['count'];

    // Calcular o total de páginas
    $totalPages = ceil($totalProducts / $rowsPerPage);

    // Calcular o índice do primeiro produto na página
    $offset = ($currentPage - 1) * $rowsPerPage;

    // Consulta SQL para recuperar produtos da página atual
    $sql = "SELECT * FROM Produtos ORDER BY ID LIMIT $rowsPerPage OFFSET $offset";
    $result = $db->query($sql);

    $products = [];
    while ($product = $result->fetchArray(SQLITE3_ASSOC)) {
        $products[] = $product;
    }

    return ['products' => $products, 'totalPages' => $totalPages];
}

function paginationClientes($db, $currentPage = 1, $rowsPerPage = 5) {
    // Contar o total de clientes
    $result = $db->query('SELECT COUNT(*) as count FROM Clientes');
    $row = $result->fetchArray();
    $totalClients = $row['count'];

    // Calcular o total de páginas
    $totalPages = ceil($totalClients / $rowsPerPage);

    // Calcular o índice do primeiro cliente na página
    $offset = ($currentPage - 1) * $rowsPerPage;

    // Consulta SQL para recuperar clientes da página atual
    $sql = "SELECT * FROM Clientes ORDER BY ID LIMIT $rowsPerPage OFFSET $offset";
    $result = $db->query($sql);

    $clientes = [];
    while ($cliente = $result->fetchArray(SQLITE3_ASSOC)) {
        $clientes[] = $cliente;
    }

    return ['clientes' => $clientes, 'totalPages' => $totalPages];
}

function getMostSoldProduct($db) {
    $sql = "SELECT Produtos.Nome, Produtos.Imagem, SUM(ItensPedido.Quantidade) as TotalVendido
            FROM ItensPedido
            JOIN Produtos ON ItensPedido.ProdutoID = Produtos.ID
            GROUP BY ItensPedido.ProdutoID
            ORDER BY TotalVendido DESC
            LIMIT 1";
    
    $result = $db->query($sql);
    
    // Verifica se o resultado contém pelo menos uma linha
    if ($row = $result->fetchArray()) {
        // Retorna o nome, a quantidade total vendida e a imagem do produto mais vendido
        return ['nome' => $row['Nome'], 'imagem' => $row['Imagem'], 'totalVendido' => $row['TotalVendido']];
    } else {
        // Retorna null se não houver vendas ou ocorrer um erro
        return null;
    }
}

function getLeastSoldProduct($db) {
    $sql = "SELECT Produtos.Nome, Produtos.Imagem, SUM(ItensPedido.Quantidade) as TotalVendido
            FROM ItensPedido
            JOIN Produtos ON ItensPedido.ProdutoID = Produtos.ID
            GROUP BY ItensPedido.ProdutoID
            ORDER BY TotalVendido ASC
            LIMIT 1";
    
    $result = $db->query($sql);
    
    // Verifica se o resultado contém pelo menos uma linha
    if ($row = $result->fetchArray()) {
        return ['nome' => $row['Nome'], 'imagem' => $row['Imagem'], 'totalVendido' => $row['TotalVendido']];
    } else {
        // Retorna null se não houver vendas ou ocorrer um erro
        return null;
    }
}

function addProduto($db, $nome, $preco, $desc, $stock, $imagem_produto_caminho){
    $sql = "INSERT INTO Produtos (Nome, Preço, Descrição, Stock, Imagem) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        header("location: ../admin.products.php?error=stmtfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->bindValue('1', $nome, SQLITE3_TEXT);
    $stmt->bindValue('2', $preco, SQLITE3_TEXT);
    $stmt->bindValue('3', $desc, SQLITE3_TEXT);
    $stmt->bindValue('4', $stock, SQLITE3_TEXT);
    $stmt->bindValue('5', $imagem_produto_caminho, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result) {
        header("location: ../admin.products.php?error=none");
    } else {
        echo "Erro ao inserir o produto no banco de dados: " . $stmt->error;
        header("location: ../admin.products.php?error=stmtfailed" . $db->lastErrorMsg());
    }
    exit();
}

function getClientes($db) {
    $sql = "SELECT ID, Nome, Email, Telefone FROM Clientes ORDER BY ID";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        return []; // Ou trate o erro conforme sua lógica de aplicação
    }

    // No SQLite3, os índices dos parâmetros começam em 1
    $result = $stmt->execute();

    $clientes = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $clientes[] = $row;
    }
    
    return $clientes;
}

function apagarCliente($db, $cliente_id) {
    // Verificar se o ID é um número válido
    if (!filter_var($cliente_id, FILTER_VALIDATE_INT)) {
        return false; // Se o ID não for válido, retorna falso
    }

    // Query para apagar o cliente
    $sql = "DELETE FROM Clientes WHERE ID = :id";
    $stmt = $db->prepare($sql);

    if ($stmt === false) {
        return false; // Se a preparação da declaração falhar, retorna falso
    }

    // Vincular o parâmetro (no SQLite3, a vinculação é feita com bindValue)
    $stmt->bindValue(':id', $cliente_id, SQLITE3_INTEGER);

    // Executar a query
    if ($stmt->execute()) {
        return true; // Se a exclusão for bem-sucedida, retorna verdadeiro
    } else {
        return false; // Se a execução da query falhar, retorna falso
    }
}

function addUser($db, $nome, $email, $senha, $telefone, $cargo, $imagem_perfil_caminho) {
    // Obtém a data atual no formato do banco de dados
    $dataRegisto = date('Y-m-d');

    // Prepara a declaração SQL para inserir um novo usuário
    $sql = "INSERT INTO Clientes (Nome, Email, Senha, Telefone, `role`, dataRegisto, Perfil) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    // Verifica se a preparação da declaração SQL foi bem sucedida
    if (!$stmt) {
        header("location: ../addClientes.php?error=stmtfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    // Liga os parâmetros à declaração SQL

    $stmt->bindValue('1', $nome, SQLITE3_TEXT);
    $stmt->bindValue('2', $email, SQLITE3_TEXT);
    $stmt->bindValue('3', $senha, SQLITE3_TEXT);
    $stmt->bindValue('4', $telefone, SQLITE3_TEXT);
    $stmt->bindValue('5', $cargo, SQLITE3_TEXT);
    $stmt->bindValue('6', $dataRegisto, SQLITE3_TEXT);
    $stmt->bindValue('7', $imagem_perfil_caminho, SQLITE3_TEXT);
    $result = $stmt->execute();

    // Executa a declaração SQL
    if ($result) {
        header("location: ../admin.clientes.php?error=none");
    } else {
        echo "Erro ao inserir o cliente na base de dados: " . $stmt->error;
        header("location: ../admin.clientes.php?error=stmtfailed" . $db->lastErrorMsg());
    }
    exit();
    // Fecha a declaração SQL
}

// Função para obter os dados de um cliente pelo ID
function getClienteById($db, $cliente_id) {
    // Prepare a consulta SQL para selecionar o cliente com base no ID
    $sql = "SELECT * FROM Clientes WHERE ID = ?";
    $stmt = $db->prepare($sql);
    
    // Vincule o parâmetro do ID ao statement
    $stmt->bindValue(1, $cliente_id, SQLITE3_INTEGER);
    $result=$stmt->execute();
    
    // Obtenha o resultado da consulta
    $cliente = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $cliente = $row;
    }

    if (!empty($cliente)) {
        return $cliente;
    } else {
        return false; // Se não encontrar nenhum cliente com o ID fornecido
    }
}

function updateProfileImage($conn, $cliente_id, $caminho) {
    $sql = "UPDATE Clientes SET Perfil = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        error_log("Failed to prepare the SQL statement: " . $conn->error);
        return false;
    }

    $stmt->bindParam(1, $caminho);
    $stmt->bindParam(2, $cliente_id);

    if (!$stmt->execute()) {
        error_log("Failed to execute the statement: " . $stmt->error);
        return false;
    }

    return true;
}

function getOrders($db, $limit = 5) {
    $sql = "SELECT p.ID, p.ClienteID, c.Nome AS NomeCliente, p.Email, p.DataPedida 
            FROM Pedidos p
            INNER JOIN Clientes c ON p.ClienteID = c.ID
            ORDER BY p.ID DESC
            LIMIT ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        // Trate o erro conforme necessário
        return [];
    }

    // No SQLite3, os índices dos parâmetros começam em 1
    $stmt->bindValue(1, $limit, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $orders  = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $orders[] = $row;
    }
    
    return $orders;
}


function fetchOrders($db, $searchTerm) {
    $sql = "SELECT ID, ClienteID, Nome, Email, DataPedida FROM Pedidos WHERE ID = :searchTerm";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':searchTerm', $searchTerm, SQLITE3_TEXT);
    $result = $stmt->execute();

    $orders = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $orders[] = $row;
    }

    return $orders;
}

function paginationPedidos($db, $currentPage = 1, $rowsPerPage = 5) {
    // Contar o total de clientes
    $result = $db->query('SELECT COUNT(*) as count FROM Pedidos');
    $row = $result->fetchArray();
    $totalPedidos = $row['count'];

    // Calcular o total de páginas
    $totalPages = ceil($totalPedidos / $rowsPerPage);

    // Calcular o índice do primeiro cliente na página
    $offset = ($currentPage - 1) * $rowsPerPage;

    // Consulta SQL para recuperar clientes da página atual
    $sql = "SELECT * FROM Pedidos ORDER BY ID LIMIT $rowsPerPage OFFSET $offset";
    $result = $db->query($sql);

    $pedidos = [];
    while ($pedido = $result->fetchArray(SQLITE3_ASSOC)) {
        $pedidos[] = $pedido;
    }

    return ['pedidos' => $pedidos, 'totalPages' => $totalPages, 'currentPage' => $currentPage];
}

function atualizarProduto($db, $id, $nome, $preco, $descricao, $stock, $imagem_perfil_caminho) {
    // Preparando a declaração SQL para atualização
    $stmt = $db->prepare("UPDATE Produtos SET Nome = ?, Preço = ?, Descrição = ?, Stock = ?, Imagem = ? WHERE ID = ?");
    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $preco);
    $stmt->bindParam(3, $descricao);
    $stmt->bindParam(4, $stock);
    $stmt->bindParam(5, $imagem_perfil_caminho);
    $stmt->bindParam(6, $id);

    // Executando a declaração
    $stmt->execute();

    // Fechando a declaração e a conexão
    $stmt->close();
}

// Função para obter os detalhes de um produto pelo ID
function obterProdutoPorId($db, $id) {
    $stmt = $db->prepare("SELECT * FROM Produtos WHERE ID = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    // Verifica se encontrou um produto com o ID especificado
    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        return $row;
    } else {
        return null; // Retorna null se o produto não for encontrado
    }
}

function deleteProduct($db, $id) {
    // Prepare a instrução SQL para excluir o produto pelo ID
    $sql = "DELETE FROM Produtos WHERE ID = :id";
    
    // Prepare a instrução
    $stmt = $db->prepare($sql);
    if ($stmt) {
        // Bind o parâmetro ID
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        
        // Execute a instrução
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } else {
        // Se houver um erro ao preparar a instrução SQL
        return false;
    }
}


function isClientInUse($db, $cliente_id) {
    // Prepare a instrução SQL para verificar se o cliente está em uso
    $sql = "SELECT COUNT(*) FROM Pedidos WHERE ClienteID = :clientId";
    
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bindValue(':clientId', $cliente_id, SQLITE3_INTEGER);
        
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_NUM);
        
        // Se o contador for maior que 0, o cliente está em uso
        return $row[0] > 0;
    } else {
        // Se houver um erro ao preparar a instrução SQL
        return false;
    }
}



function inserirMensagem($db, $idCliente, $assunto, $mensagem) {
    try {
        $dataHora = date('Y-m-d'); // Formato correto para DateTime
        
        // Buscar o ID do assunto na tabela Assuntos
        $stmtAssunto = $db->prepare('SELECT IdAssunto FROM Assuntos WHERE NomeAssunto = :nomeAssunto');
        $stmtAssunto->bindValue(':nomeAssunto', $assunto, SQLITE3_TEXT); // Bind de valor para SQLite3
        $resultAssunto = $stmtAssunto->execute();

        // Verificar se o assunto foi encontrado
        if ($row = $resultAssunto->fetchArray(SQLITE3_ASSOC)) {
            $idAssunto = $row['IdAssunto'];
        } else {
            // Caso não encontre o assunto na tabela
            throw new Exception("Assunto '$assunto' não encontrado na tabela de Assuntos.");
        }

        // Preparar a declaração SQL para inserção de dados na tabela Mensagens
        $stmt = $db->prepare('INSERT INTO Mensagem (IdCliente, Mensagem, IdAssunto, DataMensagem) VALUES (:idCliente, :mensagem, :idAssunto, :dataMensagem)');
        $stmt->bindValue(':idCliente', $idCliente, SQLITE3_INTEGER);
        $stmt->bindValue(':mensagem', $mensagem, SQLITE3_TEXT);
        $stmt->bindValue(':idAssunto', $idAssunto, SQLITE3_INTEGER);
        $stmt->bindValue(':dataMensagem', $dataHora, SQLITE3_TEXT); // SQLite3 usa TEXT para datas

        // Executar a declaração SQL
        $result = $stmt->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($result) {
            // Retorna o ID da última mensagem inserida
            return $db->lastInsertRowID();
        } else {
            return false; // Retorna false se ocorrer algum erro na inserção
        }

    } catch (Exception $e) {
        echo "Erro ao inserir mensagem no banco de dados: " . $e->getMessage();
        return false;
    }
}

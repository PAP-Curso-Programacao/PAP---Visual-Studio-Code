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
        if(!preg_match("/^[a-zA-Z0-9_ ]*$/", $nome)){
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

    function emptyInputProfile($nome, $telefone, $email){
    $result = false;

    // Verificar se todos os campos estão vazios
    if (empty($nome) && empty($telefone) && empty($email)) {
        $result = true;
    }

    return $result;
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

function updateUser($db, $ID, $morada){
    
    $sql = "UPDATE Clientes SET Morada = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        header("location: ../editProfile.php?error=stmtfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    // Bind dos parâmetros usando variáveis
    $stmt->bindParam(1, $morada, SQLITE3_TEXT);
    $stmt->bindParam(2, $ID, SQLITE3_INTEGER);  

    $result = $stmt->execute();

    if (!$result) {
        header("location: ../editProfile.php?error=stmtexecutionfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    $stmt->close();

    // Após o fechamento da declaração, você pode redirecionar
    header("location: ../editProfile.php?error=none");
    exit();
}

function createOrder($db, $clienteID, $userid) {
    $status = 0; // Se você deseja definir o status aqui, não é necessário passá-lo como parâmetro
    $dataHora = date('Y-m-d'); // Formato correto para DateTime

    // Correção na consulta SQL para corresponder ao schema fornecido
    $sql = "INSERT INTO Pedidos (ClienteID, Email, Status, Data) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da declaração: " . $db->lastErrorMsg());
    }

    // Bind dos parâmetros
    $stmt->bindParam(1, $clienteID, SQLITE3_INTEGER);
    $stmt->bindParam(2, $userid, SQLITE3_TEXT); // Supondo que você tenha um $email para vincular aqui
    $stmt->bindParam(3, $status, SQLITE3_INTEGER);
    $stmt->bindParam(4, $dataHora, SQLITE3_TEXT); // Mudado para SQLITE3_FLOAT se Total pode ser decimal

    if (!$stmt->execute()) {
        die("Erro na execução da declaração: " . $db->lastErrorMsg());
    }

    $lastId = $db->lastInsertRowID();

    // Não precisa fechar o stmt em SQLite3, mas se estiver usando PDO: $stmt = null;

    return $lastId;
}

function createOrderLine($db, $encomendaId, $productsInCart)
{
    // Preparação da declaração fora do loop
    $sql = "INSERT INTO ItensPedido (PedidoID, ProdutoID, Quantidade, PreçoUni) VALUES (?, ?, ?, (SELECT Preço FROM Produtos WHERE ID = ?))";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        echo "Erro: Preparação da declaração falhou.<br>";
        return false;
    }

    foreach ($productsInCart as $item) {
        // Verifique se todas as informações necessárias estão presentes
        if (!isset($item['id'], $item['title'], $item['quantity'])) {
            echo "Erro: Variáveis necessárias ausentes em um item do carrinho<br>";
            continue; // Pule para a próxima iteração do loop
        }

        $produtoID = $item['id'];
        $quantidade = $item['quantity'];

        // Bind dos parâmetros usando variáveis
        $stmt->bindValue(1, $encomendaId, SQLITE3_INTEGER);
        $stmt->bindValue(2, $produtoID, SQLITE3_INTEGER);
        $stmt->bindValue(3, $quantidade, SQLITE3_INTEGER);
        $stmt->bindValue(4, $produtoID, SQLITE3_INTEGER); // O mesmo ID do produto para a subconsulta

        // Execute a declaração dentro do loop
        $result = $stmt->execute();

        if (!$result) {
            echo "Erro: Execução da declaração falhou para o item: $produtoID.<br>";
            continue; // Pule para a próxima iteração do loop
        }
    }

    return true; // Se chegar aqui, todos os itens foram inseridos com sucesso
}

function getRecentUsers($db, $limit = 5) {
    $sql = "SELECT Nome, Email, dataRegisto FROM Clientes ORDER BY dataRegisto DESC LIMIT ?";
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

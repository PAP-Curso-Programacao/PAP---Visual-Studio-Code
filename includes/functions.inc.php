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

    function userExists($db, $nome, $email){   
        $sql = "SELECT * FROM Clientes WHERE Nome = ? OR Email = ?;";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
    
        $stmt->bindValue(1, $nome, SQLITE3_TEXT);
        $stmt->bindValue(2, $email, SQLITE3_TEXT);
        $result = $stmt->execute();
    
        if ($row = $result->fetchArray()) {
            return $row;
        } else {
            return false;
        }
    }
    

    function createUser($db, $nome, $email, $password){
        $sql = "INSERT INTO Clientes (Nome, Email, Senha) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
    
        $stmt->bindValue(1, $nome, SQLITE3_TEXT);
        $stmt->bindValue(2, $email, SQLITE3_TEXT);
        $stmt->bindValue(3, $password, SQLITE3_TEXT);
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

    function loginUser($db, $email, $password){
    $userExists = userExists($db, $email, $email);

    if ($userExists === false) {
        exit();
    }

    // Obtenha a senha armazenada no banco de dados
    $storedPassword = $userExists["Senha"];

    // Compare a senha fornecida com a senha armazenada (sem hash)
    if ($password !== $storedPassword) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    session_start();
    $_SESSION["userid"] = $userExists["ID"];
    $_SESSION["useruid"] = $userExists["Email"];
    header("location: ../index.php");
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

function updateUser($db, $ID, $nome, $email, $morada, $telefone){
    
    $sql = "UPDATE Clientes SET Nome = ?, Email = ?, Morada = ?, Telefone = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        header("location: ../editProfile.php?error=stmtfailed&msg=" . $db->lastErrorMsg());
        exit();
    }

    // Bind dos parâmetros usando variáveis
    $stmt->bindParam(1, $nome, SQLITE3_TEXT);
    $stmt->bindParam(2, $email, SQLITE3_TEXT);
    $stmt->bindParam(3, $morada, SQLITE3_TEXT);
    $stmt->bindParam(4, $telefone, SQLITE3_TEXT);
    $stmt->bindParam(5, $ID, SQLITE3_INTEGER);  

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
?>
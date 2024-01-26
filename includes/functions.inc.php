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
        $sql = "INSERT INTO Clientes (Nome, Email, Senha,Morada,Telefone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
    
        $stmt->bindValue(1, $nome, SQLITE3_TEXT);
        $stmt->bindValue(2, $email, SQLITE3_TEXT);
        $stmt->bindValue(3, $password, SQLITE3_TEXT);
        $stmt->bindValue(4, "o", SQLITE3_TEXT);
        $stmt->bindValue(5, "ola", SQLITE3_TEXT);
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
?>
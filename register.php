<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Pagina registar</title>
</head>
<body>
    <section class="form-container">
        <form method="POST">
            <h1>Registar agora</h1>
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" placeholder="Enter your email" required>
            <input type="password" placeholder="Enter your password" required>
            <input type="password" placeholder="Confirm your password" required>
            <input type="submit" placeholder="Register now" class="btn">
            <p>Ja tem uma conta?<a href="login.php">Login now</a></p>
        </form>
    </section>
</body>
</html>
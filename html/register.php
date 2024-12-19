<?php
require "../php/conexao.php";
session_start();
if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $sql = "INSERT INTO USER (USERNAME, EMAIL, SENHA) VALUES ('$username', '$email', '$senha')";
    if (mysqli_query($conexao, $sql)) {
        $_SESSION["login"] = $email;
        $_SESSION["senha"] = $senha;
        header("Location: index.php");
    } else {
        $erro = "Erro ao registrar usuário";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Registrar</title>
</head>

<body>
    <main>
        <h1>Registrar</h1>
        <form action="register.php" method="POST">
            <label for="username">Nome de usuário:</label>
            <input type="text" name="username" id="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <button type="submit" name="register">Registrar</button>
            <?php if (isset($erro)) { echo "<p>$erro</p>"; } ?>
        </form>
    </main>
</body>

</html>

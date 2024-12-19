<?php
require "../php/conexao.php";
session_start();
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
    $query = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($query) > 0) {
        $_SESSION["login"] = $email;
        $_SESSION["senha"] = $senha;
        header("Location: index.php");
    } else {
        $erro = "Email ou senha incorretos";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register-login.css">
    <title>Fazer login</title>
</head>

<body>
    <main>
        <div class="main-content">
            <h1 class="titulo">Fazer Login</h1>
            <form action="login.php" method="POST" class="form">
                <div class="input-group">
                    <label for="email" class="label">Email</label>
                    <input type="email" class="input" name="email" id="email" required>
                </div>
                <div class="input-group">
                    <label for="senha" class="label">Senha</label>
                    <input type="password" class="input" name="senha" id="senha" required>
                </div>
                <div class="input-group">
                    <button type="submit" class="submit" name="login">Entrar</button>
                </div>
                <?php if (isset($erro)) { echo "<p style='font-family: Poppins, sans-serif; color: orange;'>$erro</p>"; } ?>
            </form>
            <div class="link-registrar">
                <p style="font-family: 'Poppins', sans-serif; color: #fff;">
                    Não tem uma conta? 
                    <a href="register.php" style="color: #fff;">Registre-se</a>
                </p>
            </div>
        </div>
    </main>
</body>

</html>
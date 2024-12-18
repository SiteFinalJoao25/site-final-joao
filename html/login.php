<?php
// Inclui o arquivo 'conexao.php' para estabelecer a conexão com o banco de dados
require "../php/conexao.php";

// Inicia uma nova sessão ou retoma a sessão existente
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define o conjunto de caracteres como UTF-8 -->
    <meta charset="UTF-8">

    <!-- Define a compatibilidade com dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Inclui a folha de estilo externa -->
    <link rel="stylesheet" href="../css/register-login.css">

    <!-- Define o título da página -->
    <title>Fazer login</title>
</head>

<body>
    <main>
        <div class="main-content">
            <!-- Título da página -->
            <h1 class="titulo">Fazer Login</h1>

            <!-- Formulário de login -->
            <form action="<?php echo $_SERVER[
                "PHP_SELF"
            ]; ?>" method="post" class="form">
                <!-- Campo de entrada para o email -->
                <div class="input-group">
                    <label for="email" class="label">Email</label>
                    <input type="email" class="input" name="email" id="email">
                </div>

                <!-- Campo de entrada para a senha -->
                <div class="input-group">
                    <label for="senha" class="label">Senha</label>
                    <input type="password" class="input" name="senha" id="senha">
                </div>

                <!-- Botão de submissão -->
                <div class="input-group">
                    <input type="submit" class="submit" name="log_usuario" value="Entrar">
                </div>
            </form>

            <!-- Link para a página de registro -->
            <div class="link-registrar">
                <p style="font-family: 'Poppins', sans-serif; color: #fff;">
                    Não tem uma conta? 
                    <a href="register.php" style="color: #fff;">Registre-se</a>
                </p>
            </div>

            <?php // Verifica se o formulário foi submetido
            if (isset($_POST["log_usuario"])) {
                // Captura os dados do formulário
                $login = $_POST["email"];
                $senha = $_POST["senha"];

                // Query SQL para verificar as credenciais no banco de dados
                $sql = "SELECT * FROM USER WHERE EMAIL = '$login' AND SENHA = '$senha'";
                $query = mysqli_query($conexao, $sql);

                // Verifica se há algum registro correspondente
                if (mysqli_num_rows($query) > 0) {
                    // Salva os dados do usuário na sessão
                    $_SESSION["login"] = $login;
                    $_SESSION["senha"] = $senha;

                    // Redireciona para a página inicial
                    header("Location: index.php");
                } else {

                    // Remove os dados da sessão caso as credenciais estejam incorretas
                    unset($_SESSION["login"]);
                    unset($_SESSION["senha"]);
                    ?>

            <!-- Mensagem de erro exibida ao usuário -->
            <p style="font-family: 'Poppins', sans-serif; color: orange;">Usuário ou senha incorreta</p>

            <?php
                }
            } ?>
        </div>
    </main>
</body>

</html>
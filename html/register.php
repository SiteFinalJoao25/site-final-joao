<?php
// Inclui o arquivo de conexão com o banco de dados
require "../php/conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link para o arquivo CSS do formulário de registro/login -->
    <link rel="stylesheet" href="../css/register-login.css">
    <title>Criar conta</title>
</head>

<body>
    <main>
        <div class="main-content">
            <h1 class="titulo">Criar Conta</h1>
            <!-- Formulário para criar conta -->
            <form action="<?php echo $_SERVER[
                "PHP_SELF"
            ]; ?>" class="form" method="post">
                <!-- Campo para o nome de usuário -->
                <div class="input-group">
                    <label for="usuario" class="label">Usuário</label>
                    <input type="text" class="input" name="usuario" id="usuario" required>
                </div>
                <!-- Campo para o email -->
                <div class="input-group">
                    <label for="email" class="label">Email</label>
                    <input type="email" class="input" name="email" id="email" required>
                </div>
                <!-- Campo para a senha -->
                <div class="input-group">
                    <label for="senha" class="label">Senha</label>
                    <input type="password" class="input" name="senha" id="senha" required>
                </div>
                <!-- Campo para a data de nascimento -->
                <div class="input-group">
                    <label for="nasc" class="label">Data de Nascimento</label>
                    <input type="date" class="input" name="nasc" id="nasc" required>
                </div>
                <!-- Opções para selecionar o sexo -->
                <div class="input-group">
                    <label for="" class="label">Sexo</label>
                    <label for="fem" class="label">Feminino <input type="radio" class="input" name="sexo" id="fem"
                            value="F" checked></label>
                    <label for="masc" class="label">Masculino <input type="radio" class="input" name="sexo" id="masc"
                            value="M"></label>
                </div>
                <!-- Botão para enviar o formulário -->
                <div class="input-group">
                    <input type="submit" class="submit" name="add_usuario" value="Registrar">
                </div>
                <!-- Link para redirecionar ao login caso o usuário já tenha uma conta -->
                <div class="link-registrar">
                    <p style="font-family: 'Poppins', sans-serif; color: #fff;">Já tem uma conta? <a href="login.php"
                            style="color: #fff;">Faça login</a></p>
                </div>
            </form>

            <?php // Verifica se o botão de adicionar usuário foi clicado
            if (isset($_POST["add_usuario"])) {
                $usuario = $_POST["usuario"]; // Obtém o nome de usuário
                $email = $_POST["email"]; // Obtém o email
                $senha = md5($_POST["senha"]); // Obtém a senha
                $nasc = $_POST["nasc"]; // Obtém a data de nascimento
                $sexo = $_POST["sexo"]; // Obtém o sexo

                // Verifica se o nome de usuário já existe no banco
                $sql = "SELECT USERNAME FROM USER WHERE USERNAME = '$usuario'";
                $query = mysqli_query($conexao, $sql);

                if (mysqli_num_rows($query) > 0) { ?>
            <p style="font-family: 'Poppins', sans-serif; color: orange;">Já existe um usuario de nome <?php echo $usuario; ?>.
            </p>
            <?php } else {// Verifica se o email já está em uso
                    $sql = "SELECT EMAIL FROM USER WHERE EMAIL = '$email'";
                    $query = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($query) > 0) { ?>
            <p style="font-family: 'Poppins', sans-serif; color: orange;">Já existe um usuario com esse email.</p>
            <?php } else {// Insere o novo usuário no banco de dados
                        $sql = "INSERT INTO USER (USERNAME, EMAIL, SENHA, DATA_NASC, SEXO) VALUES ('$usuario', '$email', '$senha', '$nasc', '$sexo')";
                        mysqli_query($conexao, $sql);

                        if (mysqli_affected_rows($conexao) > 0) {
                            // Redireciona para a página de login em caso de sucesso
                            header("Location: login.php");
                        } else {
                            echo "erro ao adicionar usuario";
                        }}}
            } ?>
        </div>
    </main>
</body>

</html>

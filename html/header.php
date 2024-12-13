<?php 
  // Inicia uma sessão para manter os dados do usuário
  session_start();

  // Inclui o arquivo de conexão com o banco de dados
  require '../php/conexao.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link para o arquivo CSS específico do cabeçalho -->
    <link rel="stylesheet" href="../css/header.css">
    <title>Document</title>
</head>

<body>
    <header class="cabecalho">
        <div class="header_left">
            <!-- Link para a página inicial com o logotipo -->
            <a href="index.php"><img class="logo" src="../imagens/logo_vision.svg" alt="logo"></a>
            
            <!-- Barra de navegação com links para diferentes categorias de produtos -->
            <nav class="navbar">
                <a href="produtos.php" class="navbar_link">ÓCULOS</a>
                <a href="produtos.php" class="navbar_link">PULSEIRAS</a>
                <a href="produtos.php" class="navbar_link">RELÓGIOS</a>
                <a href="produtos.php" class="navbar_link">PERFUMES</a>
                <?php 
                  // Verifica se o usuário está logado para exibir o link de "Minhas Compras"
                  if(isset($_SESSION['login']) && isset($_SESSION['senha'])) {
                ?>
                <a href="compras.php" class="navbar_link">MINHAS COMPRAS</a>
                <?php 
                  }
                ?>
            </nav>
        </div>

        <div class="header-right">
            <div class="logado">
                <?php
                // Exibe uma saudação com o nome do usuário logado
                if (isset($_SESSION["login"]) && isset($_SESSION["senha"])) {
                    $email = $_SESSION['login'];
                    $senha = $_SESSION['senha'];

                    // Consulta para buscar o nome do usuário no banco de dados
                    $sql = "SELECT USERNAME FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
                    $query = mysqli_query($conexao, $sql);
                    $arrayNome = mysqli_fetch_array($query);
                    $nome = $arrayNome['USERNAME'];
                    echo "Olá! $nome!";
                } else {
                    // Caso o usuário não esteja logado, exibe o link para a página de login
                    echo '<a href="login.php">Fazer Login</a>';
                }
                ?>
            </div>
            <div class="novoproduto">
                <?php
                // Verifica se o usuário é administrador para exibir o botão de adicionar produto
                if(isset($_SESSION["login"]) == "admin" && $_SESSION["senha"] == "admin") {
                ?>
                <a href="../php/cadastrar_prod.php" title="Adicionar produto ao banco de dados">
                    <img src="../imagens/adicionar-produto.svg" alt="logout-img" width="25px" height="25px">
                </a>
                <?php
                }
                ?>
            </div>
            <div class="logout">
                <?php
                // Exibe o botão de logout caso o usuário esteja logado
                if (isset($_SESSION['login']) && $_SESSION['senha']) {
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" title="Encerrar sessão">
                    <button type="submit" name="logout" class="logout-button">
                        <img src="../imagens/logout.svg" alt="logout-img" width="25px" height="25px">
                    </button>
                </form>
                <?php
                }
                ?>
            </div>

            <!-- Exibe o botão do carrinho apenas se o usuário estiver logado -->
            <?php 
              if(isset($_SESSION['login']) && isset($_SESSION['senha'])) {
            ?>
            <a href="carrinho.php" class="link-sacola" title="Acessar carrinho">
                <img src="../imagens/sacola.svg" alt="" width="25px" height="25px">
            </a>
            <?php 
              }
            ?>
        </div>

        <!-- Processa o logout e encerra a sessão do usuário -->
        <?php 
            if (isset($_POST["logout"])) {
                session_destroy(); // Encerra a sessão
                header('Location: login.php'); // Redireciona para a página de login
            }
        ?>
    </header>
</body>

</html>

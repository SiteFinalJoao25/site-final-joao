<?php
session_start();
require "../php/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <title>Document</title>
</head>

<body>
    <header class="cabecalho">
        <div class="header_left">
            <a href="index.php"><img class="logo" src="../imagens/logo_vision.svg" alt="logo"></a>
            <nav class="navbar">
                <a href="produtos.php?cat=1" class="navbar_link">ÓCULOS</a>
                <a href="produtos.php?cat=2" class="navbar_link">RELÓGIOS</a>
                <a href="produtos.php?cat=3" class="navbar_link">PERFUMES</a>
                <a href="produtos.php?cat=4" class="navbar_link">COLARES</a>
                <a href="produtos.php" class="navbar_link">TODOS OS PRODUTOS</a>
                <?php if (isset($_SESSION["login"]) && isset($_SESSION["senha"])) { ?>
                <a href="compras.php" class="navbar_link">MINHAS COMPRAS</a>
                <?php } ?>
            </nav>
        </div>
        <div class="barra-pesquisa">
            <form action="result.php" method="POST">
                <input type="text" name="strBusca" class="input-pesquisa">
                <button type="submit" name="pesquisa" class="button-pesquisa"><img src="../imagens/search.svg" alt="" width="30px"></button>
            </form>
        </div>
        <div class="header-right">
            <div class="logado">
                <?php if (isset($_SESSION["login"]) && isset($_SESSION["senha"])) {
                    $email = $_SESSION["login"];
                    $senha = $_SESSION["senha"];
                    $sql = "SELECT USERNAME FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
                    $query = mysqli_query($conexao, $sql);
                    $arrayNome = mysqli_fetch_array($query);
                    $nome = $arrayNome["USERNAME"];
                    echo "Olá! $nome!";
                } else {
                    echo '<a href="login.php">Fazer Login</a>';
                } ?>
            </div>
            <div class="novoproduto">
                <?php if (
                    isset($_SESSION["login"]) == "admin" &&
                    $_SESSION["senha"] == "admin"
                ) { ?>
                <a href="../php/cadastrar_prod.php" title="Adicionar produto ao banco de dados">
                    <img src="../imagens/adicionar-produto.svg" alt="logout-img" width="25px" height="25px">
                </a>
                <?php } ?>
            </div>
            <div class="logout">
                <?php if (isset($_SESSION["login"]) && $_SESSION["senha"]) { ?>
                <form action="<?php echo $_SERVER[
                    "PHP_SELF"
                ]; ?>" method="POST" title="Encerrar sessão">
                    <button type="submit" name="logout" class="logout-button">
                        <img src="../imagens/logout.svg" alt="logout-img" width="25px" height="25px">
                    </button>
                </form>
                <?php } ?>
            </div>
            <?php if (
                isset($_SESSION["login"]) &&
                isset($_SESSION["senha"])
            ) { ?>
            <a href="carrinho.php" class="link-sacola" title="Acessar carrinho">
                <img src="../imagens/sacola.svg" alt="" width="25px" height="25px">
            </a>
            <?php } ?>
        </div>
        <?php if (isset($_POST["logout"])) {
            session_destroy();
            header("Location: login.php");
        } ?>
    </header>
</body>

</html>

<?php
require "conexao.php";
session_start();
if (!isset($_SESSION["login"]) && !isset($_SESSION["senha"])) {
    header("Location: ../html/naologado.php");
    if (
        $_SESSION["login"] != "teste@teste.com" ||
        $_SESSION["senha"] != "admin"
    ) {
        header("Location: ../html/naologado.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cad_alt_del.css">
    <title>Cadastrar Produtos</title>
</head>

<body>
    <h1>Cadastrar produto</h1>
    <form action="acoes.php" method="POST">
        <!-- nome do produto -->
        <label for="nome">Nome</label>
        <input type="text" name="nomeprod" id="nome">
        <br>
        <!-- descrição do produto -->
        <label for="descr">Descrição</label>
        <input type="text" name="descprod" id="descr">
        <br>
        <!-- valor -->
        <label for="valor">Valor R$</label>
        <input type="number" name="valor" id="valor" step=".01">
        <br>
        <!-- imagem do produto -->
        <label for="imagem">Imagem (URL)</label>
        <input type="text" name="imagem" id="imagem">
        <br>
        <input type="submit" value="Cadastrar" name="cadastrar_produto">
    </form>
</body>

</html>
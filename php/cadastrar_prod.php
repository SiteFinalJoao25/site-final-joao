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
<html lang="pt-br">

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
        <label for="imagem">Imagem</label>
        <input type="file" name="imagem" id="imagem">
        <br>
        <!-- categoria -->
        <label for="categoria">Cód. Categoria</label>
        <input type="number" name="categoria" id="categoria">
        <br>
        <input type="submit" value="Cadastrar" name="cadastrar_produto">
        <a href="../html/produtos.php" class="voltar">Voltar</a>
    </form>

    <h3>Guia de categorias</h3>
    <ul>
        <?php 
            $sql = "SELECT * FROM CATEGORIA";
            $query = mysqli_query($conexao, $sql);
            while ($categoria = mysqli_fetch_assoc($query)) {
        ?>
        <li>Categoria <?php echo $categoria['DESC_CAT']?>: #<?php echo $categoria['ID_CATEGORIA']?></li>
        <?php 
            }
        ?>
    </ul>
</body>

</html>
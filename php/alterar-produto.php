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
    <title>Alterar Produtos</title>
</head>

<body>
    <h1>Alterar produto</h1>
    <?php
    $idProd = $_GET["id"];
    $sql = "SELECT * FROM PRODUTO WHERE ID_PROD = $idProd";
    $query = mysqli_query($conexao, $sql);
    $arrayProduto = mysqli_fetch_array($query);
    ?>
    <form action="acoes.php" method="POST" enctype="multipart/form-data">
        <!-- nome do produto -->
        <label for="nome">Nome</label>
        <input type="text" name="nomeprod" id="nome" value="<?php echo $arrayProduto["PROD_NAME"]; ?>">
        <br>
        <!-- descrição do produto -->
        <label for="descr">Descrição</label>
        <input type="text" name="descprod" id="descr" value="<?php echo $arrayProduto["PROD_DESC"]; ?>">
        <br>
        <!-- valor -->
        <label for="valor">Valor R$</label>
        <input type="number" name="valor" id="valor" step=".01" value="<?php echo $arrayProduto["VALOR"]; ?>">
        <br>
        <!-- imagem do produto -->
        <label for="imagem">Imagem</label>
        <input type="file" name="imagem" id="imagem" accept="image/*">
        <input type="hidden" name="imagem_atual" value="<?php echo $arrayProduto["PROD_IMAGE"]; ?>">
        <br>
        <label for="categoria">Cód. Categoria</label>
        <input type="number" name="categoria" id="categoria" value="<?php echo $arrayProduto["FK_ID_CATEGORIA"]; ?>">
        <br>
        <input type="hidden" name="id" id="id" value="<?php echo $_GET["id"]; ?>">
        <input type="submit" value="Alterar" name="alterar_produto">
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
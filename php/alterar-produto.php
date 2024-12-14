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
    <form action="acoes.php" method="POST">
        <!-- nome do produto -->
        <label for="nome">Nome</label>
        <input type="text" name="nomeprod" id="nome" value="<?php echo $arrayProduto[
            "PROD_NAME"
        ]; ?>">
        <br>
        <!-- descrição do produto -->
        <label for="descr">Descrição</label>
        <input type="text" name="descprod" id="descr" value="<?php echo $arrayProduto[
            "PROD_DESC"
        ]; ?>">
        <br>
        <!-- valor -->
        <label for="valor">Valor R$</label>
        <input type="number" name="valor" id="valor" step=".01" value="<?php echo $arrayProduto[
            "VALOR"
        ]; ?>">
        <br>
        <!-- imagem do produto -->
        <label for="imagem">Imagem (URL)</label>
        <input type="text" name="imagem" id="imagem" value="<?php echo $arrayProduto[
            "PROD_IMAGE"
        ]; ?>">
        <br>
        <input type="hidden" name="id" id="id" value="<?php echo $_GET[
            "id"
        ]; ?>">
        <input type="submit" value="Alterar" name="alterar_produto">
    </form>
</body>

</html>
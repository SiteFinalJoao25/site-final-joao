<?php
require "../php/conexao.php";
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != "admin") {
    header("Location: naologado.php");
}
if (isset($_POST["alterar"])) {
    $idProd = $_POST["idProd"];
    $nomeProd = $_POST["nomeProd"];
    $valorProd = $_POST["valorProd"];
    $descProd = $_POST["descProd"];
    $sql = "UPDATE PRODUTO SET PROD_NAME = '$nomeProd', VALOR = '$valorProd', DESCRICAO = '$descProd' WHERE ID_PROD = $idProd";
    if (mysqli_query($conexao, $sql)) {
        header("Location: produtos.php");
    } else {
        $erro = "Erro ao alterar produto";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/alterar-produto.css">
    <title>Alterar Produto</title>
</head>

<body>
    <?php include "header.php"; ?>
    <main>
        <h1>Alterar Produto</h1>
        <?php
        if (isset($_GET["id"])) {
            $idProd = $_GET["id"];
            $sql = "SELECT * FROM PRODUTO WHERE ID_PROD = $idProd";
            $query = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($query) > 0) {
                $produto = mysqli_fetch_assoc($query);
                $nomeProd = $produto['PROD_NAME'];
                $valorProd = $produto['VALOR'];
                $descProd = $produto['DESCRICAO'];
        ?>
        <form action="alterar-produto.php" method="POST">
            <input type="hidden" name="idProd" value="<?php echo $idProd ?>">
            <label for="nomeProd">Nome do Produto:</label>
            <input type="text" name="nomeProd" id="nomeProd" value="<?php echo $nomeProd ?>" required>
            <label for="valorProd">Valor do Produto:</label>
            <input type="text" name="valorProd" id="valorProd" value="<?php echo $valorProd ?>" required>
            <label for="descProd">Descrição do Produto:</label>
            <textarea name="descProd" id="descProd" required><?php echo $descProd ?></textarea>
            <button type="submit" name="alterar">Alterar</button>
            <?php if (isset($erro)) { echo "<p>$erro</p>"; } ?>
        </form>
        <?php
            } else {
                echo "<p>Produto não encontrado</p>";
            }
        } else {
            echo "<p>ID do produto não fornecido</p>";
        }
        ?>
    </main>
</body>

</html>
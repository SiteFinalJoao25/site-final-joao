<?php
require "conexao.php";
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != "admin") {
    header("Location: ../html/naologado.php");
}
if (isset($_POST["cadastrar"])) {
    $nomeProd = $_POST["nomeProd"];
    $valorProd = $_POST["valorProd"];
    $descProd = $_POST["descProd"];
    $categoria = $_POST["categoria"];
    $imagem = $_FILES["imagem"]["name"];
    $target_dir = "../imagens/img_produtos/";
    $target_file = $target_dir . basename($imagem);
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);
    $sql = "INSERT INTO PRODUTO (PROD_NAME, VALOR, DESCRICAO, CATEGORIA, PROD_IMAGE) VALUES ('$nomeProd', '$valorProd', '$descProd', '$categoria', '$imagem')";
    if (mysqli_query($conexao, $sql)) {
        header("Location: ../html/produtos.php");
    } else {
        $erro = "Erro ao cadastrar produto";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastrar_prod.css">
    <title>Cadastrar Produto</title>
</head>

<body>
    <?php include "../html/header.php"; ?>
    <main>
        <h1>Cadastrar Produto</h1>
        <form action="cadastrar_prod.php" method="POST" enctype="multipart/form-data">
            <label for="nomeProd">Nome do Produto:</label>
            <input type="text" name="nomeProd" id="nomeProd" required>
            <label for="valorProd">Valor do Produto:</label>
            <input type="text" name="valorProd" id="valorProd" required>
            <label for="descProd">Descrição do Produto:</label>
            <textarea name="descProd" id="descProd" required></textarea>
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" required>
                <option value="1">ÓCULOS</option>
                <option value="2">RELÓGIOS</option>
                <option value="3">PERFUMES</option>
                <option value="4">COLARES</option>
            </select>
            <label for="imagem">Imagem do Produto:</label>
            <input type="file" name="imagem" id="imagem" required>
            <button type="submit" name="cadastrar">Cadastrar</button>
            <?php if (isset($erro)) { echo "<p>$erro</p>"; } ?>
        </form>
    </main>
</body>

</html>
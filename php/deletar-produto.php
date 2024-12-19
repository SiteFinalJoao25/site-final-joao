<?php
require "conexao.php";
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != "admin") {
    header("Location: ../html/naologado.php");
}
if (isset($_GET["id"])) {
    $idProd = $_GET["id"];
    $sql = "DELETE FROM PRODUTO WHERE ID_PROD = $idProd";
    if (mysqli_query($conexao, $sql)) {
        header("Location: ../html/produtos.php");
    } else {
        $erro = "Erro ao deletar produto";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/deletar_prod.css">
    <title>Deletar Produto</title>
</head>

<body>
    <?php include "../html/header.php"; ?>
    <main>
        <h1>Deletar Produto</h1>
        <?php if (isset($erro)) { echo "<p>$erro</p>"; } ?>
    </main>
</body>

</html>
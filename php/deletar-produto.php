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
    <title>Deletar Produtos</title>
</head>

<body>
    <h1>Deletar produto</h1>
    <form action="acoes.php" method="POST">
        <input type="hidden" name="id" id="id" value="<?php echo $_GET[
            "id"
        ]; ?>">
        <input type="submit" value="deletar" name="deletar_produto">
        <a href="../html/produtos.php" class="voltar">Voltar</a>
    </form>
</body>

</html>
<?php
require "../php/conexao.php";
session_start();
if (!isset($_SESSION["login"]) && !isset($_SESSION["senha"])) {
    header("Location: naologado.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nota.css">
    <title>Compra finalizada</title>
</head>
<body>
    <main>
        <h1>Obrigado por comprar conosco!</h1>
        <?php
        //pegando o id do usuário
        $email = $_SESSION["login"];
        $senha = $_SESSION["senha"];
        // Consulta para obter o ID do usuário logado
        $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
        $query = mysqli_query($conexao, $sql);
        $arrayId = mysqli_fetch_array($query);
        $userId = $arrayId["USER_ID"];

        $idCompra = $_GET["idCompra"];
        //COMPRA.ID_COMPRA
        //COMPRA.FORMA_PAGAMENTO
        //COMPRA.TOTAL_COMPRA
        //ITENS_COMPRA.COUNT(ID_ITEM_COMPRA) WHERE FK_ID_COMRPA = $idCompra

        //SELECIONA A FORMA DE PAGAMENTO E O TOTAL DA COMPRA
        $sql = "SELECT FORMA_PAGAMENTO, TOTAL_COMPRA FROM COMPRA WHERE ID_COMPRA = $idCompra";
        $query = mysqli_query($conexao, $sql);
        $arrayNF = mysqli_fetch_assoc($query);
        $formaPag = $arrayNF["FORMA_PAGAMENTO"];
        $totalCompra = number_format($arrayNF["TOTAL_COMPRA"], 2, ",", ".");

        //SELECIONA A QUANTIDADE DE ITENS;
        $sql = "SELECT SUM(FK_QUANT) AS QUANTITENS FROM ITENS_COMPRA WHERE FK_ID_COMPRA = $idCompra";
        $query = mysqli_query($conexao, $sql);
        $arrayQuant = mysqli_fetch_assoc($query);
        $quanItens = $arrayQuant["QUANTITENS"];
        ?>
        <div class="info">
            <p><strong>ID da compra: </strong> <?php echo $idCompra; ?></p>
            <p><strong>Forma de pagamento: </strong><?php echo $formaPag; ?></p>
            <p><strong>Total: </strong>R$<?php echo $totalCompra; ?></p>
            <p><strong>Número de itens: </strong><?php echo $quanItens; ?></p>
        </div>
        <div class="botoes">
            <a href="index.php" class="voltar">Voltar para o início</a>
            <a href="compras.php" class="compras">Minhas compras</a>
        </div>

    </main>
</body>
</html>
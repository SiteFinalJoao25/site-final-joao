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
        $email = $_SESSION["login"];
        $senha = $_SESSION["senha"];
        $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
        $query = mysqli_query($conexao, $sql);
        $arrayId = mysqli_fetch_array($query);
        $userId = $arrayId["USER_ID"];

        $idCompra = $_GET["idCompra"];
        $sql = "SELECT * FROM COMPRA WHERE ID_COMPRA = $idCompra AND FK_CARR_USER_ID = $userId";
        $query = mysqli_query($conexao, $sql);
        $compra = mysqli_fetch_array($query);
        $timestamp = $compra['HORA_COMPRA'];
        $dateTime = new DateTime($timestamp);
        $data = $dateTime->format('d-m-Y');
        $hora = $dateTime->format('H:i');
        ?>
        <div class="nota">
            <p>ID Compra: <?php echo $compra["ID_COMPRA"]; ?></p>
            <p>Data: <?php echo $data ?></p>
            <p>Hora: <?php echo $hora?></p>
            <p>Total: R$<?php echo number_format($compra["TOTAL_COMPRA"], 2, ",", "."); ?></p>
        </div>
        <div class="itens">
            <h2>Itens da compra</h2>
            <table>
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Preço Unitário</th>
                        <th>Quantidade</th>
                        <th>Total Item (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM ITENS_COMPRA, PRODUTO WHERE FK_NUM_COMPRA = $idCompra AND ID_PROD = ID_PRODUTO";
                    $itens = mysqli_query($conexao, $sql);
                    while ($item = mysqli_fetch_assoc($itens)) {
                        $img = $item['PROD_IMAGE']; 
                        $imgProduto = "../imagens/img_produtos/$img";
                        $nomeProd = $item['PROD_NAME'];
                        $valorProd = $item['FK_VALOR'];
                        $quantProd = $item['FK_QUANT'];
                    ?>
                    <tr>
                        <td><img src="<?php echo $imgProduto ?>" alt="Imagem produto" width="100px"></td>
                        <td><?php echo $nomeProd ?></td>
                        <td>R$<?php echo number_format($valorProd, 2, ",", ".") ?></td>
                        <td><?php echo $quantProd ?></td>
                        <td>R$<?php echo number_format($valorProd*$quantProd, 2, ",", ".") ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
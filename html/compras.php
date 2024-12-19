<?php
require "../php/conexao.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras</title>
    <link rel="stylesheet" href="../css/compras.css">
</head>

<body>
    <?php
    include "header.php";
    if (!isset($_SESSION["login"]) && !isset($_SESSION["senha"])) {
        header("Location: naologado.php");
    }
    ?>
    <main>
        <h1>Minhas compras</h1>
        <div class="compras-cards-container">
            <?php
            $email = $_SESSION["login"];
            $senha = $_SESSION["senha"];
            $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
            $query = mysqli_query($conexao, $sql);
            $arrayId = mysqli_fetch_array($query);
            $userId = $arrayId["USER_ID"];
            $sql = "SELECT * FROM COMPRA WHERE FK_CARR_USER_ID = $userId";
            $compras = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($compras) > 0) {
                while ($compra = mysqli_fetch_assoc($compras)) {
                    $numeroCompra = $compra["FK_NUM_COMPRA"]; ?>
                <div class="container_tabela">
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
                            $sql = "SELECT * FROM ITENS_COMPRA, PRODUTO WHERE FK_NUM_COMPRA = $numeroCompra AND ID_PROD = ID_PRODUTO";
                            $itens = mysqli_query($conexao, $sql);
                            if (mysqli_num_rows($itens) > 0) {
                                while ($item = mysqli_fetch_assoc($itens)) {
                                    $img = $item['PROD_IMAGE']; 
                                    $imgProduto = "../imagens/img_produtos/$img";
                                    $nomeProd = $item['PROD_NAME'];
                                    $valorProd = $item['FK_VALOR'];
                                    $quantProd = $item['FK_QUANT'];
                                ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $imgProduto ?>" alt="Imagem produto" width="100px">
                                </td>
                                <td><?php echo $nomeProd ?></td>
                                <td>R$<?php echo  number_format($valorProd, 2, ",", ".") ?></td>
                                <td><?php echo $quantProd ?></td>
                                <td>R$<?php echo number_format($valorProd*$quantProd, 2, ",", ".") ?></td>
                            </tr>
                            <?php }
                            }
                            $timestamp = $compra['HORA_COMPRA'];
                            $dateTime = new DateTime($timestamp);
                            $data = $dateTime->format('d-m-Y');
                            $hora = $dateTime->format('H:i');
                            ?>
                        </tbody>
                    </table>
                    <div class="info_compra">
                        <p>ID Compra: <?php echo $compra["ID_COMPRA"]; ?></p>
                        <p>Data: <?php echo $data ?></p>
                        <p>Hora: <?php echo $hora?></p>
                        <p>Total: R$<?php echo number_format($compra["TOTAL_COMPRA"], 2, ",", "."); ?></p>
                        <a href="notafiscal.php?idCompra=<?php echo $compra["ID_COMPRA"]; ?>">Ver nota fiscal</a>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>Nenhuma compra foi feita ainda</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>
<?php
require "../php/conexao.php";
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/result.css">
    <title>Resultados da Pesquisa</title>
</head>

<body>
    <?php include "header.php"; ?>
    <main>
        <h1>Resultados da Pesquisa</h1>
        <div class="resultados-container">
            <?php
            if (isset($_POST["pesquisa"])) {
                $strBusca = $_POST["strBusca"];
                $sql = "SELECT * FROM PRODUTO WHERE PROD_NAME LIKE '%$strBusca%'";
                $query = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($query) > 0) {
                    while ($produto = mysqli_fetch_assoc($query)) {
                        $img = $produto['PROD_IMAGE'];
                        $imgProduto = "../imagens/img_produtos/$img";
                        $nomeProd = $produto['PROD_NAME'];
                        $valorProd = $produto['VALOR'];
                        $idProd = $produto['ID_PROD'];
            ?>
            <div class="produto">
                <img src="<?php echo $imgProduto ?>" alt="Imagem produto">
                <h3><?php echo $nomeProd ?></h3>
                <p>R$<?php echo number_format($valorProd, 2, ",", ".") ?></p>
                <a href="visualizar.php?id=<?php echo $idProd ?>" class="btn">Ver mais</a>
            </div>
            <?php
                    }
                } else {
                    echo "<p>Nenhum produto encontrado</p>";
                }
            }
            ?>
        </div>
    </main>
</body>

</html>
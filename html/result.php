<?php 
    require '../php/conexao.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da pesquisa</title>
</head>
<body>
    <?php 
        include 'header.php';

        if (isset($_POST['pesquisa'])) {
            $pesquisa = $_POST['strBusca'];
        }
    ?>
    <main style="padding-top: 100px;" >
        <h1>Resultados para: <?php echo $pesquisa?></h1>
        <?php 

            //FAZENDO O SELECT DA BUSCA
            $sql = "SELECT * FROM PRODUTO WHERE PROD_NAME LIKE '%$pesquisa%' OR PROD_DESC LIKE '%$pesquisa%'";
            $results = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($results) > 0) {
                while ($result = mysqli_fetch_assoc($results)) {
                
                $prodImg = $result['PROD_IMAGE'];
                $prodName = $result['PROD_NAME'];
                $prodValor = $result['VALOR'];
            ?>

                <div class="cardResult">
                    <img src="../imagens/img_produtos/<?php echo $prodImg ?>.jpg" alt="" width="200px">
                    <p><?php echo $prodName ?></p>
                    <p><?php echo $prodValor ?></p>
                </div>

            <?php 
                }
            } else {
                echo "Nenhum produto encontrado";
            }

        ?>
    </main>
</body>
</html>
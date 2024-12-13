<?php
  require '../php/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/logo_branca.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/produtos.css">
    <title>Produtos</title>
</head>

<body>
    <?php 
        include 'header.php';
    ?>

    <main style=" position: relative; top: 70px;">
        <div class="container-produtos">

            <?php
                $sql = "SELECT * FROM PRODUTO";
                $produtos = mysqli_query($conexao, $sql);
                if(mysqli_num_rows($produtos) > 0) {
                    while ($produto = mysqli_fetch_assoc($produtos)) {
                ?>
                <div class="container-card-alt">
                    <a href="visualizar.php?id=<?php echo $produto['ID_PROD']; ?>" class="card-produto">
                        <img src="../imagens/img_produtos/<?php echo $produto['PROD_IMAGE']?>.jpg" class="img-produto" width="210px" height="250px">
                        <p class="produto-texto"><?php echo  $produto['PROD_NAME']?></p>
                        <p class="produto-preco">R$<?php echo  $produto['VALOR']?></p>
                    </a>
                    <div class="acoesProd">
                        <?php
                            if(isset($_SESSION['login']) && isset($_SESSION['senha'])) {
                                if($_SESSION['login'] == "teste@teste.com" && $_SESSION['senha'] == "admin" ){
                        ?>
                            <a href="../php/alterar-produto.php?id=<?php echo $produto['ID_PROD']?>" class="alterar">Alterar</a>
                            <a href="../php/deletar-produto.php?id=<?php echo $produto['ID_PROD']?>" class="deletar">Deletar</a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php
                    }
                } else {
                echo "nenhum produto encontrado";
                }
            ?>

        </div>
    </main>
</body>
</html>
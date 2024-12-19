<?php
require "../php/conexao.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/visualizar.css">
    <title>Visualizar Produto</title>
</head>

<body>

    <?php // Inclui o cabeçalho compartilhado
    include "header.php"; ?>

    <main>
        <?php // Verifica se um ID foi enviado via GET
        if (isset($_GET["id"])) {
            $idProd = $_GET["id"];
            $sql = "SELECT * FROM PRODUTO WHERE ID_PROD = $idProd";
            $query = mysqli_query($conexao, $sql);

            // Verifica se há resultados
            if (mysqli_num_rows($query) > 0) {
                // Obtém os dados do produto como um array
                $produto = mysqli_fetch_assoc($query);
                $img = $produto['PROD_IMAGE'];
                $imgProduto = "../imagens/img_produtos/$img";
                $nomeProd = $produto['PROD_NAME'];
                $valorProd = $produto['VALOR'];
                $descProd = $produto['DESCRICAO'];
        ?>
        <!-- Se o produto foi encontrado, exibe seus detalhes -->
        <div class="produto-container">
            <!-- Imagem do produto -->
            <img src="<?php echo $imgProduto ?>" alt="Imagem produto">
            <div class="produto-info">
                <h1><?php echo $nomeProd ?></h1>
                <p>R$<?php echo number_format($valorProd, 2, ",", ".") ?></p>
                <p><?php echo $descProd ?></p>
                <!-- Formulário para adicionar o produto ao carrinho -->
                <form action="../php/acoes.php" method="POST">
                    <input type="hidden" name="idProd" value="<?php echo $idProd ?>">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" name="quantidade" id="quantidade" value="1" min="1">
                    <button type="submit" name="adicionarCarrinho">Adicionar ao Carrinho</button>
                </form>
            </div>
        </div>
        <?php
            } else {
                // Mensagem de erro caso o produto não seja encontrado
                echo "<p>Produto não encontrado</p>";
            }
        } else {
            echo "<p>ID do produto não fornecido</p>";
        }
        ?>
    </main>

</body>

</html>

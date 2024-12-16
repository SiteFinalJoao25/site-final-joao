<?php
// Inclui o arquivo de conexão com o banco de dados
require "../php/conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/visualizar.css">
    <title>Ver produto</title>
</head>

<body>

    <?php // Inclui o cabeçalho compartilhado
    include "header.php"; ?>

    <main>
        <?php // Verifica se um ID foi enviado via GET
        if (isset($_GET["id"])) {
            // Evita injeções SQL usando `mysqli_real_escape_string`
            $produto_id = mysqli_real_escape_string($conexao, $_GET["id"]);
            // Consulta SQL para buscar o produto pelo ID
            $sql = "SELECT * FROM PRODUTO WHERE ID_PROD = $produto_id";
            $query = mysqli_query($conexao, $sql);

            // Verifica se há resultados
            if (mysqli_num_rows($query) > 0) {
                // Obtém os dados do produto como um array
                $PRODUTO = mysqli_fetch_array($query); ?>
        <!-- Se o produto foi encontrado, exibe seus detalhes -->
        <div class="container-visualizar">
            <!-- Imagem do produto -->
            <img src="../imagens/img_produtos/<?php echo $PRODUTO[
                "PROD_IMAGE"
            ]; ?>.jpg" alt="Imagem do produto" class="img-visualizar">
            <div class="textos-visualizar">
                <div class="textos-top">
                    <!-- Nome do produto -->
                    <h3 class="nome-produto"><?php echo $PRODUTO[
                        "PROD_NAME"
                    ]; ?></h3>
                    <!-- Descrição do produto -->
                    <p class="descricao-produto"><?php echo $PRODUTO[
                        "PROD_DESC"
                    ]; ?></p>
                    <!-- Preço do produto -->
                    <p class="valor-produto">R$<?php echo $PRODUTO[
                        "VALOR"
                    ]; ?></p>
                </div>

                <!-- Formulário para adicionar o produto ao carrinho -->
                <form action="../php/acoes.php" method="post">
                    <!-- Botão para adicionar ao carrinho -->
                    <button type="submit" class="botao-adicionar" name="add_cart"
                        value="<?php echo $PRODUTO[
                            "ID_PROD"
                        ]; ?>">Adicionar ao carrinho</button>
                    <!-- Campo para selecionar a quantidade -->
                    <input type="number" class="quantidade" value="1" name="quant" max="200">
                </form>
            </div>

            <?php
            } else {
                // Mensagem de erro caso o produto não seja encontrado
                echo "Produto não encontrado";
            }
        } ?>
        </div>
        <!-- Botão para voltar à página de produtos -->
        <a href="produtos.php" class="voltar">Voltar</a>
    </main>

</body>

</html>

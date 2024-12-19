<?php
require "../php/conexao.php";
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/logo_branca.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/index.css">
    <title>Vision</title>
</head>

<body>
    <?php include "header.php"; ?>
    <main>
        <section class="banner">
            <h1>Bem-vindo à nossa loja</h1>
            <p>Encontre os melhores produtos aqui</p>
        </section>
        <section class="produtos">
            <h2>Produtos em Destaque</h2>
            <div class="produtos-container">
                <?php
                $sql = "SELECT * FROM PRODUTO LIMIT 4";
                $query = mysqli_query($conexao, $sql);
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
                <?php } ?>
            </div>
        </section>
        <div class="container_cards">
            <div class="card">
                <p class="titulo_card">ÓCULOS</p>
                <p class="desconto">20<span class="porcentagem">%</span><span class="off">OFF</span></p>
                <p class="tempo_limitado">TEMPO LIMITADO</p>
                <a href="produtos.php?cat=1" class="botao_compra">COMPRAR</a>
            </div>
            <div class="card" style="padding: 0px;">
                <img src="../imagens/oculos1.png" alt="" width="100%">
            </div>
            <div class="card">
                <p class="titulo_card" id="titulo_card_2">COLARES</p>
                <p class="desconto">15<span class="porcentagem">%</span><span class="off">OFF</span></p>
                <p class="tempo_limitado">TEMPO LIMITADO</p>
                <a href="produtos.php?cat=4" class="botao_compra">COMPRAR</a>
            </div>
            <div class="card" style="padding: 0px;">
                <img src="../imagens/pulseira1.png" alt="" width="100%">
            </div>
        </div>
        <section class="colecao">
            <div class="img-relogio"></div>
            <div class="conteiner_textos">
                <h1 class="titulo_colecao">NOVA COLEÇÃO</h1>
                <p class="texto-colecao">
                    A nova coleção de relógios é um verdadeiro deleite para os apaixonados por elegância e precisão.
                    Cada peça é meticulosamente projetada para oferecer não apenas estilo, mas também funcionalidade
                    excepcional. Os detalhes refinados e a sofisticação dos materiais garantem uma experiência única
                    para quem busca o melhor em acessórios.
                </p>
                <a href="produtos.php" class="botao_colecao">VEJA MAIS</a>
            </div>
        </section>
    </main>
</body>

</html>
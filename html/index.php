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
                <p class="titulo_card" id="titulo_card_2">PULSEIRAS <br>E COLARES</p>
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
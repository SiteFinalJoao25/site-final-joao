<?php
// Inclui o arquivo de conexão com o banco de dados para estabelecer a comunicação
require "../php/conexao.php"; ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
    <!-- Configurações de codificação e responsividade -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Ícone exibido na aba do navegador -->
    <link rel="shortcut icon" href="../imagens/logo_branca.png" type="image/x-icon">
    <!-- Estilo específico da página de carrinho -->
    <link rel="stylesheet" href="../css/carrinho.css">
    <title>Carrinho</title>
</head>

<body>
    <?php
    // Inclui o cabeçalho do site e verifica se o usuário está logado.
    // Caso contrário, redireciona para a página de "não logado".
    include "header.php";
    if (!isset($_SESSION["login"]) && !isset($_SESSION["senha"])) {
        header("Location: naologado.php");
    }
    ?>
    <main>
        <?php 
            // Recupera as credenciais do usuário na sessão
            $email = $_SESSION["login"];
            $senha = $_SESSION["senha"];
            // Consulta para obter o ID do usuário logado
            $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
            $query = mysqli_query($conexao, $sql);
            $arrayId = mysqli_fetch_array($query);
            $userId = $arrayId["USER_ID"];
            ?>
            <?php
            //SELECIONA OS PRODUTOS DO CARRINHO DESSE USUÁRIO E VERIFICA SE ESTÁ VAZIO
            $sql = "SELECT * FROM CARRINHO WHERE CARR_USER_ID = $userId";
            $query = mysqli_query($conexao, $sql);
            if(mysqli_num_rows($query) > 0) {
        ?>
        <div class="cart-table-container">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Seu Carrinho</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Recupera as credenciais do usuário na sessão
                    $email = $_SESSION["login"];
                    $senha = $_SESSION["senha"];
                    // Consulta para obter o ID do usuário logado
                    $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
                    $query = mysqli_query($conexao, $sql);
                    $arrayId = mysqli_fetch_array($query);
                    $userId = $arrayId["USER_ID"];
                    ?>
                    <?php
                    //SELECIONA OS PRODUTOS DO CARRINHO DESSE USUÁRIO E VERIFICA SE ESTÁ VAZIO
                    $sql = "SELECT * FROM CARRINHO WHERE CARR_USER_ID = $userId";
                    $query = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($query) > 0) {
                        //SELECIONANDO OS DADOS NECESSÁRIOS PARA MOSTRAR OS PRODUTOS
                        $sql = "SELECT * FROM CARRINHO, PRODUTO WHERE FK_ID_PROD = ID_PROD AND CARR_USER_ID = $userId";
                        $itens = mysqli_query($conexao, $sql);
                        while ($item = mysqli_fetch_assoc($itens)) {

                            $prodImage = $item["PROD_IMAGE"];
                            $prodName = $item["PROD_NAME"];
                            $prodQuant = $item["QUANT"];
                            $prodValor = $item["VALOR"];
                            $prodId = $item["FK_ID_PROD"];
                            $idPosCart = $item["PROD_CART_ID"];
                            ?>
                    <tr>
                        <td><img src="../imagens/img_produtos/<?php echo $prodImage?>" alt="" class="imgCart"></td>
                        <td><?php echo "<a href='visualizar.php?id=$prodId' class='nomeProd'>$prodName</a>"; ?></td>
                        <td>
                            <form action="../php/acoes.php?idPosCart=<?php echo $idPosCart; ?>" method="POST" class="formquant">
                                <!-- Campo para alterar a quantidade do produto -->
                                <input type="number" name="produto_<?php echo $idPosCart; ?>" title="produto_<?php echo $prodId; ?>" style="width: 40px;" value="<?php echo $prodQuant; ?>" min="0" class="inputQuant">
                                <button type="submit" name="updateQuant" class="updateQuant"><img src="../imagens/updateQuant.svg" alt="" width="20px"></button>
                            </form>
                        </td>
                        <!-- Exibe o valor total para a quantidade do produto -->
                        <td>R$<?php echo number_format(
                            $prodValor * $prodQuant,
                            2,
                            ",",
                            "."
                        ); ?></td>
                        <td>
                            <form action="../php/acoes.php" method="GET">
                                <!-- Botão para excluir o item do carrinho -->
                                <button type="submit" name="delete_cart_item" value="<?php echo $idPosCart; ?>"><img src="../imagens/lixeira.svg" alt="" width="20px"></button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<h3>Seu carrinho está vazio!</h3>";
                    }
                    ?>

                </tbody>
            </table>
            <div class="total">
                <?php
                // Calcula o valor total dos itens no carrinho
                $sql = "SELECT SUM(VALOR*QUANT) TOTAL FROM CARRINHO WHERE CARR_USER_ID = $userId";
                $query = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($query) > 0) {
                    $arrayTotal = mysqli_fetch_array($query);
                    $total = number_format($arrayTotal["TOTAL"], 2, ",", ".");
                }
                ?>
                <!-- Exibe o valor total calculado -->
                <p class="total-text"> Total: R$<?php echo $total; ?> </p>
            </div>
        </div>

        <div class="botoes">
            <!-- Botão para voltar à página de produtos -->
            <a href="produtos.php" class="voltar">Continuar comprando</a>
            <form action="../php/acoes.php" method="POST" class="form-finalizar" >
                <!-- Seleção da forma de pagamento -->
                <select name="formaPag" id="formaPag" required>
                    <option value="">Selecionar Forma de pagamento</option>
                    <option value="PIX">PIX</option>
                    <option value="Cartão de Crédito">Cartão de crédito</option>
                    <option value="Cartão de Débito">Cartão de Crédito</option>
                    <option value="boleto">Boleto</option>
                    <option value="transferencia">transferência Bancária</option>
                </select>
                <!-- Botão para finalizar a compra -->
                <button type="submit" class="voltar" name="finalizar-compra">Finalizar Compra</button>
            </form>
        </div>
        <?php 
            } else {
        ?>
            <div class="vazio">
                <h1>Ainda não há nada aqui...</h1>
                <a href="index.php">Procurar produtos</a>
            </div>
        <?php     
            }
        ?>
    </main>
</body>

</html>

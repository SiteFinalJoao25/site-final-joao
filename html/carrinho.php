<?php
// Inclui o arquivo de conexão com o banco de dados para estabelecer a comunicação
require '../php/conexao.php'; 
?>
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
        include 'header.php';
        if(!isset($_SESSION['login']) && !isset($_SESSION['senha'])) {
            header('Location: naologado.php');
        }
    ?>
    <main>
        <div class="cart-table-container">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Ação</th>
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

                    // Seleciona os itens do carrinho associados ao usuário, agrupando por produto
                    $sql = "SELECT  
                                PROD_CART_ID, 
                                FK_ID_PROD, 
                                ID_PROD, 
                                PROD_NAME, 
                                SUM(CARRINHO.VALOR) AS TOTAL, 
                                CARRINHO.VALOR AS PRECO, 
                                SUM(QUANT) AS QUANT, 
                                QUANT AS QUANTIDADE 
                            FROM CARRINHO, PRODUTO 
                            WHERE ID_PROD = FK_ID_PROD AND CARR_USER_ID = $userId 
                            GROUP BY FK_ID_PROD";
                    $itens = mysqli_query($conexao, $sql);
                    if(mysqli_num_rows($itens) > 0) {
                        // Itera sobre os itens retornados e exibe cada um como uma linha na tabela
                        foreach($itens as $item) {
                    ?>
                    <tr>
                        <td><?php echo  $item['PROD_NAME'] ?></td>
                        <td>
                            <?php 
                            // ID do item atual para referência em formulários
                            $iditem = $item['PROD_CART_ID'];
                            ?>
                            <form action="<?php echo  $_SERVER['PHP_SELF'] ?>" method="POST">
                                <!-- Campo para alterar a quantidade do produto -->
                                <input type="number" name="produto_<?php echo $iditem?>" title="produto_<?php echo $item['PROD_CART_ID']?>" style="width: 40px;" value="<?php echo $item['QUANTIDADE'] ?>" min="1">
                                <input type="submit" value="Atualizar" name="updateQuant">
                            </form>
                            <?php 
                            // Atualiza a quantidade do item no banco de dados quando o formulário é submetido
                            if(isset($_POST['updateQuant'])) {
                                if(isset($_POST["produto_$iditem"])) {
                                    $newQuant = $_POST["produto_$iditem"];
                                    $sql = "UPDATE CARRINHO SET QUANT = $newQuant WHERE PROD_CART_ID = $iditem";
                                    mysqli_query($conexao, $sql);
                                    // Atualiza a página para refletir as mudanças
                                    echo "<script>window.location.href='carrinho.php';</script>";
                                }
                            }
                            ?>
                        </td>
                        <!-- Exibe o valor total para a quantidade do produto -->
                        <td>R$<?php echo $item['PRECO']*$item['QUANTIDADE']?></td>
                        <td>
                            <form action="../php/acoes.php" method="GET">
                                <!-- Botão para excluir o item do carrinho -->
                                <button type="submit" name="delete_cart_item" value="<?php echo $item['PROD_CART_ID'] ?>">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        // Exibe uma mensagem caso o carrinho esteja vazio
                        echo "<h3 style='text-align: center;'>Seu carrinho está vazio!</h3>";
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
                    $total = $arrayTotal['TOTAL'];
                }
                ?>
                <!-- Exibe o valor total calculado -->
                <p class="total-text"> Total: R$<?php echo $total ?> </p>
            </div>
        </div>

        <div class="botoes">
            <!-- Botão para voltar à página de produtos -->
            <a href="produtos.php" class="voltar">Voltar</a>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <!-- Seleção da forma de pagamento -->
                <select name="formaPag" id="formaPag">
                    <option value="PIX">PIX</option>
                    <option value="Cartão de Crédito">Cartão de crédito</option>
                    <option value="boleto">Boleto</option>
                </select>
                <!-- Botão para finalizar a compra -->
                <button type="submit" class="voltar" name="finalizar">Finalizar Compra</button>
            </form>
            <?php
            // Finaliza a compra: atualiza o número de compras, insere os dados na tabela de compras e limpa o carrinho
            if(isset($_POST['finalizar'])) {

                // Verifica se tem algum item dentro do carrinho
                $sql = "SELECT * FROM CARRINHO WHERE CARR_USER_ID = $userId";
                $query = mysqli_query($conexao, $sql);
                if(mysqli_num_rows($query) > 0) {
                    $sql = "SELECT NUM_COMPRAS FROM USER WHERE USER_ID = $userId";
                    $query = mysqli_query($conexao, $sql);
                    $arrayNumCompras = mysqli_fetch_array($query);
                    $numCompras = $arrayNumCompras['NUM_COMPRAS'] + 1;
    
                    // Atualiza o número total de compras realizadas pelo usuário
                    $sql = "UPDATE USER SET NUM_COMPRAS = $numCompras WHERE USER_ID = $userId";
                    mysqli_query($conexao, $sql);
    
                    // Recupera o total da compra para registro
                    $sql = "SELECT SUM(VALOR*QUANT) AS TOTAL FROM CARRINHO WHERE CARR_USER_ID = $userId";
                    $query = mysqli_query($conexao, $sql);
                    $arrayTotal = mysqli_fetch_array($query);
                    $totalCompra = $arrayTotal['TOTAL'];
    
                    $formaPag = $_POST['formaPag'];
                    // Insere os dados da compra na tabela de compras
                    $sql = "INSERT INTO COMPRA (TOTAL_COMPRA, FK_CARR_USER_ID, NUM_COMPRA, FORMA_PAGAMENTO) VALUES ($totalCompra, $userId, $numCompras, '$formaPag')";
                    mysqli_query($conexao, $sql);
    
                    // Seleciona os itens do carrinho para inserir na tabela de itens da compra
                    $sql = "SELECT FK_ID_PROD, VALOR AS PRECO, QUANT FROM CARRINHO WHERE CARR_USER_ID = $userId";
                    $itens = mysqli_query($conexao, $sql);
                    foreach($itens as $item) {
                        $itemCompra = $item['FK_ID_PROD'];
                        $valorprod = $item['PRECO'];
                        $quantCompra = $item['QUANT'];
    
                        // Remove os itens do carrinho após a compra
                        $sql = "DELETE FROM CARRINHO WHERE CARR_USER_ID = $userId";
                        mysqli_query($conexao, $sql);
    
                        // Registra os itens na tabela de itens da compra
                        $sql = "INSERT INTO ITENS_COMPRA (ID_PRODUTO, QUANT, FK_VALOR, NUM_COMPRA) VALUES ($itemCompra, $quantCompra, $valorprod, $numCompras)";
                        mysqli_query($conexao, $sql);
    
                        // Redireciona para a página de nota fiscal se a operação for bem-sucedida
                        if (mysqli_affected_rows($conexao) > 0) {
                            echo "<script>window.location.href='notafiscal.php?id=$numCompras';</script>";  
                        } else {
                            // Exibe erros do banco de dados, se existirem
                            echo mysqli_error($conexao);
                        }
                    }
                    // Limpa o estado do formulário para evitar reenvio
                    unset($_POST['finalizar']);
                } else {
                    echo "<p><a href='produtos.php'>Adicione </a>algum item no carrinho antes de comprar.</p>";
                }


            }
            ?>
        </div>
    </main>
</body>

</html>

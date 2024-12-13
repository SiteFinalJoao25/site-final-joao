<?php 
    // Inclui o arquivo de conexão com o banco de dados
    require '../php/conexao.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras</title>
    <!-- Importa o arquivo CSS específico para a página -->
    <link rel="stylesheet" href="../css/compras.css">
</head>

<body>
    <?php
        // Inclui o cabeçalho da página
        include 'header.php';

        // Verifica se o usuário está logado
        if(!isset($_SESSION['login']) && !isset($_SESSION['senha'])) {
            // Redireciona o usuário para uma página de acesso negado caso não esteja logado
            header('Location: naologado.php');
        }
    ?>
    <main>
        <h1>Minhas compras</h1>
        <div class="compras-cards-container">
            <?php 
                // Obtém o email e a senha do usuário para identificar o usuário logado
                $email = $_SESSION["login"];
                $senha = $_SESSION["senha"];

                // Consulta para buscar o ID do usuário logado
                $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
                $query = mysqli_query($conexao, $sql);
                $arrayId = mysqli_fetch_array($query);
                $userId = $arrayId["USER_ID"]; // ID do usuário logado

                // Consulta para buscar as compras do usuário
                $sql = "SELECT * FROM COMPRA WHERE FK_CARR_USER_ID = $userId";
                $compras = mysqli_query($conexao, $sql);

                // Verifica se o usuário possui compras
                if(mysqli_num_rows($compras) > 0) {
                    // Itera sobre cada compra encontrada
                    foreach($compras as $compra) {
                        $numeroCompra = $compra['NUM_COMPRA'];   
            ?>
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
                                // Consulta para buscar os itens da compra e informações do produto
                                $sql = "SELECT * FROM ITENS_COMPRA, PRODUTO WHERE NUM_COMPRA = $numeroCompra AND ID_PROD = ID_PRODUTO";
                                $itens = mysqli_query($conexao, $sql);

                                // Verifica se existem itens na compra
                                if(mysqli_num_rows($itens) > 0) {
                                    // Itera sobre cada item encontrado
                                    foreach($itens as $item) {
                            ?>
                            <tr>
                                <td>
                                    <!-- Exibe a imagem do produto -->
                                    <img src="<?php echo $item['PROD_IMAGE'] ?>" alt="Imagem produto" width="100px">
                                </td>
                                <!-- Exibe as informações do produto -->
                                <td><?php echo $item['PROD_NAME'] ?></td>
                                <td>R$<?php echo $item['FK_VALOR'] ?></td>
                                <td><?php echo $item['QUANT'] ?></td>
                                <td>R$<?php echo $item['FK_VALOR'] * $item ['QUANT']?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <div class="info_compra">
                        <!-- Exibe as informações da compra -->
                        <p>Compra <?php echo $compra['NUM_COMPRA'] ?></p>
                        <p>Data <?php echo $compra['HORA_COMPRA'] ?></p>
                        <p>Total: R$<?php echo $compra['TOTAL_COMPRA'] ?></p>
                        <!-- Link para a nota fiscal -->
                        <a href="notafiscal.php?id=<?php echo $compra['NUM_COMPRA'] ?>">Ver nota fiscal</a>
                    </div>
                </div>

            <?php 
                    }
                } else {
                    // Caso o usuário não tenha realizado nenhuma compra
                    echo "<p>Nenhuma compra foi feita ainda</p>";
                }
            ?>
        </div>
    </main>
</body>

</html>
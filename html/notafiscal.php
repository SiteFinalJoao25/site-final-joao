<?php 
    require '../php/conexao.php';
    session_start();
    if(!isset($_SESSION['login']) && !isset($_SESSION['senha'])) {
        header('Location: naologado.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nota.css">
    <title>Compra finalizada</title>
</head>
<body>
    <main>
        <h1>Obrigado por comprar conosco!</h1>
        <div class="info">
            <?php 
                $email = $_SESSION["login"];
                $senha = $_SESSION["senha"];
                $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
                $query = mysqli_query($conexao, $sql);
                $arrayId = mysqli_fetch_array($query);
                $userId = $arrayId["USER_ID"]; // ESTE É O ID DO USER

                $numCompra = $_GET['id'];
                //SELECIONANDO A QUANTIDADE DE ITENS
                $sql = "SELECT SUM(QUANT) FROM ITENS_COMPRA WHERE NUM_COMPRA = $numCompra";
                $query = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($query) > 0) {
                    $arrayQuant = mysqli_fetch_array($query);
                    $quant = $arrayQuant['SUM(QUANT)'];
                }

                //SELECIONANDO O TOTAL
                $sql = "SELECT TOTAL_COMPRA, FORMA_PAGAMENTO FROM COMPRA WHERE NUM_COMPRA = $numCompra";
                $query = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($query) > 0) {
                    $arrayTot = mysqli_fetch_array($query);
                    $total = $arrayTot['TOTAL_COMPRA'];
                    $formaPag = $arrayTot['FORMA_PAGAMENTO'];
                }
                
            ?>
            <p><strong>ID da compra: </strong> <?php echo $numCompra ?></p>
            <p><strong>Forma de pagamento: </strong><?php echo $formaPag ?></p>
            <p><strong>Total: </strong>R$<?php echo $total ?></p>
            <p><strong>Número de itens: </strong><?php echo $quant ?></p>
        </div>
        <div class="botoes">
            <a href="index.php" class="voltar">Voltar para o início</a>
            <a href="compras.php" class="compras">Minhas compras</a>
        </div>

    </main>
</body>
</html>
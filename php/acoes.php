<?php
require "conexao.php";
session_start();

if (!isset($_SESSION["login"]) && !isset($_SESSION["senha"])) {
    header("Location: ../html/naologado.php");
}


if (isset($_POST["add_cart"])) {
    $produto_id = $_POST["add_cart"];
    $sql = "SELECT * FROM PRODUTO WHERE ID_PROD = $produto_id";

    $query = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($query) > 0) {
        $produto = mysqli_fetch_array($query);
        $nome = $produto["PROD_NAME"];
        $quant = $_POST["quant"];
        $valor = $produto["VALOR"];

        if (isset($_SESSION["login"]) && isset($_SESSION["senha"])) {
            //SELECIONANDO O ID DO USUÁRIO
            $email = $_SESSION["login"];
            $senha = $_SESSION["senha"];
            $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
            $query = mysqli_query($conexao, $sql);
            $arrayId = mysqli_fetch_array($query);
            $userId = $arrayId["USER_ID"];

            //SE O PRODUTO JÁ TIVER SIDO ADICIONADO POR ESSE USUÁRIO, O CARRINHO SÓ AUMENTA A QUANTIDADE
            $sql = "SELECT QUANT FROM CARRINHO WHERE FK_ID_PROD = $produto_id AND CARR_USER_ID = $userId";
            $query = mysqli_query($conexao, $sql);
            $arrayQuant = mysqli_fetch_array($query);
            if (mysqli_num_rows($query) > 0) {
                $quantBD = $arrayQuant["QUANT"];
                $newQuant = $quant + $quantBD;
                $sql = "UPDATE CARRINHO SET QUANT = $newQuant, COMPRADO = '0' WHERE FK_ID_PROD = $produto_id";
                mysqli_query($conexao, $sql);
                header("Location: ../html/carrinho.php");
            } else {
                $sql = "INSERT INTO CARRINHO (CARR_USER_ID, QUANT, FK_ID_PROD, VALOR, COMPRADO) VALUES ($userId, $quant, $produto_id, $valor, '0')";
                mysqli_query($conexao, $sql);

                if (mysqli_affected_rows($conexao) > 0) {
                    echo "item adicionado com sucesso.";
                    header("Location: ../html/carrinho.php");
                } else {
                    echo "item não foi adicionado.";
                }
            }
        } else {
            header("Location: ../html/naologado.php");
        }
    }
}

if (isset($_GET["delete_cart_item"])) {
    $idPosCart = $_GET["delete_cart_item"];

    $sql = "UPDATE CARRINHO SET QUANT = 0, COMPRADO = '1' WHERE PROD_CART_ID = $idPosCart";
    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        header("Location: ../html/carrinho.php");
    } else {
        echo "item não foi deletado.";
    }
}

if (isset($_POST["cadastrar_produto"])) {
    // Pegando as informações do formulário
    $nomeproduto = $_POST["nomeprod"];
    $descproduto = $_POST["descprod"];
    $valorprod = $_POST["valor"];
    $imagemprod = $_POST["imagem"];
    $categProd = $_POST["categoria"];

    //Inserindo as informações no banco de dados
    $sql = "INSERT INTO PRODUTO (PROD_NAME, PROD_DESC, VALOR, PROD_IMAGE, FK_ID_CATEGORIA) VALUES ('$nomeproduto', '$descproduto', $valorprod, '$imagemprod', $categProd)";
    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        echo "Produto adicionado com sucesso";
        header("Location: cadastrar_prod.php");
    } else {
        echo "Erro ao adicionar o produto";
    }
}


if (isset($_POST["alterar_produto"])) {
    $nomeProd = $_POST['nomeprod'];
    $descprod = $_POST['descprod'];
    $valorprod = $_POST['valor'];
    $imagemprod = $_POST['imagem'];
    $categProd = $_POST['categoria'];
    $idprod = $_POST['id'];

    $sql = "UPDATE PRODUTO SET PROD_NAME = '$nomeProd', PROD_DESC = '$descprod', VALOR = $valorprod, PROD_IMAGE = '$imagemprod', FK_ID_CATEGORIA = $categProd WHERE ID_PROD = $idprod";
    mysqli_query($conexao, $sql);
    if (mysqli_affected_rows($conexao) > 0) {
        header("Location: ../html/produtos.php");
    } else {
        echo "Erro ao alterar: " . mysqli_error($conexao);
    }
}

if (isset($_POST["updateQuant"])) {
    //PEGANDO O ID DO ITEM
    $idPosCart = $_GET["idPosCart"];
    if (isset($_POST["produto_$idPosCart"])) {
        $newQuant = $_POST["produto_$idPosCart"];
        echo $newQuant;
        $sql = "UPDATE CARRINHO SET QUANT = $newQuant WHERE PROD_CART_ID = $idPosCart";
        mysqli_query($conexao, $sql);
        if (mysqli_affected_rows($conexao) > 0) {
            header("Location: ../html/carrinho.php");
        } else {
            echo "erro ao atualizar";
        }
    }
}

if (isset($_POST["deletar_produto"])) {
    // Pegando as informações do formulário

    $idProduto = $_POST["id"];

    //Inserindo as informações no banco de dados
    $sql = "DELETE FROM PRODUTO WHERE ID_PROD = $idProduto";
    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        echo "Produto deletado com sucesso";
        header("Location: deletar-produto.php");
    } else {
        echo "Erro ao deletar o produto: ". mysqli_error($conexao);
    }
}




if (isset($_POST["finalizar-compra"])) {


    //pegando o id do usuário
    $email = $_SESSION["login"];
    $senha = $_SESSION["senha"];
    // Consulta para obter o ID do usuário logado
    $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
    $query = mysqli_query($conexao, $sql);
    $arrayId = mysqli_fetch_array($query);
    $userId = $arrayId["USER_ID"];

    // Verifica se tem algum item dentro do carrinho
    $sql = "SELECT * FROM CARRINHO WHERE CARR_USER_ID = $userId AND COMPRADO = 0";
    $query = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($query) > 0) {
        $sql = "SELECT NUM_COMPRAS FROM USER WHERE USER_ID = $userId";
        $query = mysqli_query($conexao, $sql);
        $arrayNumCompras = mysqli_fetch_array($query);
        $numCompras = $arrayNumCompras["NUM_COMPRAS"] + 1;

        // Atualiza o número total de compras realizadas pelo usuário
        $sql = "UPDATE USER SET NUM_COMPRAS = $numCompras WHERE USER_ID = $userId";
        mysqli_query($conexao, $sql);

        //PEGA O TOTAL DO CARRINHO PARA REGISTRAR
        $sql = "SELECT SUM(VALOR*QUANT) TOTAL FROM CARRINHO WHERE CARR_USER_ID = $userId";
        $query = mysqli_query($conexao, $sql);
        $arrayTotal = mysqli_fetch_array($query);
        $totalCompra = $arrayTotal["TOTAL"];

        //PEGANDO A FORMA DE PAGAMENTO
        $formaPag = $_POST["formaPag"];

        //INSERE OS DADOS NA TABELA DE COMPRAS
        $sql = "INSERT INTO COMPRA (TOTAL_COMPRA, FK_NUM_COMPRA, FK_CARR_USER_ID, FORMA_PAGAMENTO) VALUES ($totalCompra, $numCompras, $userId, '$formaPag')";
        mysqli_query($conexao, $sql);

        // Seleciona os itens do carrinho para inserir na tabela de itens da compra
        $sql = "SELECT * FROM CARRINHO WHERE CARR_USER_ID = $userId AND COMPRADO = '0'";
        $itens = mysqli_query($conexao, $sql);
        while ($item = mysqli_fetch_assoc($itens)) {
            $idPosCart = $item["PROD_CART_ID"];
            //userId
            $quant = $item["QUANT"];
            $idProduto = $item["FK_ID_PROD"];
            $valor = $item["VALOR"];
            $comprado = $item["COMPRADO"];

            //ALTERA O STATUS "COMPRADO" DO ITEM DO CARRINHO PARA 1, PARA QUE ELE NÃO APAREÇA NO CARRINHO
            $sql = "UPDATE CARRINHO SET COMPRADO = '1', QUANT = 0 WHERE PROD_CART_ID = $idPosCart";
            mysqli_query($conexao, $sql);

            //PUXA O ID DA COMPRA
            $sql = "SELECT ID_COMPRA FROM COMPRA WHERE FK_NUM_COMPRA = $numCompras AND FK_CARR_USER_ID = $userId";
            $query = mysqli_query($conexao, $sql);
            $arrayIdCompra = mysqli_fetch_assoc($query);
            $idCompra = $arrayIdCompra["ID_COMPRA"];

            //REGISTRA OS ITENS NA TEBELA ITENS_COMPRA
            $sql = "INSERT INTO ITENS_COMPRA (ID_PRODUTO, FK_QUANT, FK_NUM_COMPRA, FK_PROD_CART_ID, FK_ID_COMPRA, FK_VALOR) VALUES ($idProduto, $quant, $numCompras, $idPosCart, $idCompra, $valor)";
            mysqli_query($conexao, $sql);

            //MANDA PARA A PÁGINA DE NOTA FISCAL SE A OPERAÇÃO FOR BEM SUCEDIDA
            if (mysqli_affected_rows($conexao) > 0) {
                header("Location: ../html/notafiscal.php?idCompra=$idCompra");
            } else {
                echo "Algo deu errado: " . mysqli_error($conexao);
            }
        }
    } else {
        echo "Adicione um item antes de comprar. <a href='../html/produtos.php'>Comprar Produtos</a>";
    }
}

?>

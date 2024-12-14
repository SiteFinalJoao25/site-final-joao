<?php 
    require 'conexao.php';
    session_start();

    if(!isset($_SESSION['login']) && !isset($_SESSION['senha'])) {
        header('Location: ../html/naologado.php');
    }


    $email= isset ($_POST['email']) ? $_POST['email']: false;
    $passaword= isset ($_POST['password']) ? $_POST['password']: false;

    $_SESSION['cart']=array();
    // header('location:index.php');
    // if( $email=="joao@123" && $passaword=="123")
    // {
    //       header('location:index1.php');
    // }
    // else 
    // {
	// unset ($_SESSION['cart']);
	// header('location:login.html?op=1');
	// }
	


    if (isset($_POST['add_cart'])) {
      $produto_id = $_POST['add_cart'];
      $sql = "SELECT * FROM PRODUTO WHERE ID_PROD = $produto_id";
      
      $query = mysqli_query($conexao, $sql);
      
      if (mysqli_num_rows($query) > 0) {
        $produto = mysqli_fetch_array($query);
        $nome = $produto['PROD_NAME'];
        $quant = $_POST['quant'];
        $valor = $produto['VALOR'];

        if(isset($_SESSION['login']) && isset($_SESSION['senha'])) {
            //SELECIONANDO O ID DO USUÁRIO
            $email = $_SESSION["login"];
            $senha = $_SESSION["senha"];
            $sql = "SELECT * FROM USER WHERE EMAIL = '$email' AND SENHA = '$senha'";
            $query = mysqli_query($conexao, $sql);
            $arrayId = mysqli_fetch_array($query);
            $userId = $arrayId["USER_ID"];
    
            //SE O PRODUTO JÁ TIVER SIDO ADICIONADO POR ESSE USUÁRIO, O CARRINHO SÓ AUMENTA A QUANTIDADE
            $sql = "SELECT FK_ID_PROD, QUANT FROM CARRINHO WHERE FK_ID_PROD = $produto_id";
            $query = mysqli_query($conexao, $sql);
            $arrayQuant = mysqli_fetch_array($query);
            if(mysqli_num_rows($query) > 0) {
                $quantBD = $arrayQuant['QUANT'];
                $newQuant = $quant + $quantBD;
                $sql = "UPDATE CARRINHO SET QUANT = $newQuant WHERE FK_ID_PROD = $produto_id";
                mysqli_query($conexao,$sql);
                header('Location: ../html/carrinho.php');
            } else {
                $sql = "INSERT INTO CARRINHO (CARR_USER_ID, QUANT, FK_ID_PROD, VALOR) VALUES ($userId, $quant, $produto_id, $valor)";
                mysqli_query($conexao, $sql);
        
                if(mysqli_affected_rows($conexao) > 0) {
                    echo "item adicionado com sucesso.";
                    header('Location: ../html/carrinho.php');
                } else {
                    echo "item não foi adicionado.";
                } 
            }
        } else {
            header('Location: ../html/naologado.php');
        }


      }
      }




      if(isset($_GET['delete_cart_item'])) {
        

        $idPosCart = $_GET['delete_cart_item'];

        $sql = "DELETE FROM CARRINHO WHERE PROD_CART_ID = $idPosCart";
        mysqli_query($conexao, $sql);
        
        if(mysqli_affected_rows($conexao) > 0) {
            header('Location: ../html/carrinho.php');
        } else {
            echo "item não foi deletado.";
        }


    }

    if(isset($_POST["cadastrar_produto"])) {
        // Pegando as informações do formulário
        $nomeproduto = $_POST["nomeprod"];
        $descproduto = $_POST["descprod"];
        $valorprod = $_POST["valor"];
        $imagemprod = $_POST["imagem"];

        //Inserindo as informações no banco de dados
        $sql = "INSERT INTO PRODUTO (PROD_NAME, PROD_DESC, VALOR, PROD_IMAGE) VALUES ('$nomeproduto', '$descproduto', $valorprod, '$imagemprod')";
        mysqli_query($conexao, $sql);

        if (mysqli_affected_rows($conexao) > 0) {
            echo "Produto adicionado com sucesso";
            header('Location: ../html/produtos.php');
        } else {
            echo "Erro ao adicionar o produto";
        }
        

    }
    if(isset($_POST["alterar_produto"])) {
        // Pegando as informações do formulário
        $nomeproduto = $_POST["nomeprod"];
        $descproduto = $_POST["descprod"];
        $valorprod = $_POST["valor"];
        $imagemprod = $_POST["imagem"];

        $idProduto = $_POST['id'];

        //Inserindo as informações no banco de dados
        $sql = "UPDATE PRODUTO SET PROD_NAME = '$nomeproduto', PROD_DESC = '$descproduto', VALOR = $valorprod, PROD_IMAGE = '$imagemprod' WHERE ID_PROD = $idProduto";
        mysqli_query($conexao, $sql);

        if (mysqli_affected_rows($conexao) > 0) {
            echo "Produto alterado com sucesso";
            header('Location: ../html/produtos.php');
        } else {
            echo "Erro ao alterado o produto";
        }
        

    }

    if(isset($_POST['updateQuant'])) {
        //PEGANDO O ID DO ITEM
        $idPosCart = $_GET['idPosCart'];
        if(isset($_POST["produto_$idPosCart"])) {
            $newQuant = $_POST["produto_$idPosCart"];
            echo $newQuant;
            $sql = "UPDATE CARRINHO SET QUANT = $newQuant WHERE PROD_CART_ID = $idPosCart";
            mysqli_query($conexao, $sql);
            if(mysqli_affected_rows($conexao) > 0) {
                header('Location: ../html/carrinho.php');
            } else {
                echo "erro ao atualizar";
            }
        }
    }

    if(isset($_POST["deletar_produto"])) {
        // Pegando as informações do formulário
        $nomeproduto = $_POST["nomeprod"];
        $descproduto = $_POST["descprod"];
        $valorprod = $_POST["valor"];
        $imagemprod = $_POST["imagem"];

        $idProduto = $_POST['id'];

        //Inserindo as informações no banco de dados
        $sql = "DELETE FROM PRODUTO WHERE ID_PROD = $idProduto";
        mysqli_query($conexao, $sql);

        if (mysqli_affected_rows($conexao) > 0) {
            echo "Produto deletado com sucesso";
            header('Location: ../html/produtos.php');
        } else {
            echo "Erro ao deletar o produto";
        }
        

    }

    

 ?>
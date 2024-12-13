<?php
  date_default_timezone_set('America/Sao_Paulo'); 
  session_start(); 
  if(!isset($_SESSION['carrinho'])){ 
    $_SESSION['carrinho'] = array(); 
  } 
  
  if(isset($_GET['acao'])){  
   
    //ADICIONAR CARRINHO 
    if($_GET['acao'] == 'add'){ 
      $id = $_GET['id']; 
      if(!isset($_SESSION['carrinho'][$id]))
        $_SESSION['carrinho'][$id] = 1; 
      else  
        $_SESSION['carrinho'][$id] += 1; 
	  header("location: carrinho.php");
      }  
	  
	 //REMOVER DO CARRINHO
	 if($_GET['acao']=='dell') {
		$id = $_GET['id']; 
		unset($_SESSION['carrinho'][$id]);
		 header("location: carrinho.php");
		}
		
	//ALTERAR QUANTIDADE 
    if($_GET['acao'] == 'up'){ 
	 if(isset($_POST['prod']))
      if(is_array($_POST['prod'])){ 
        foreach($_POST['prod'] as $id => $qtd){
            if(!empty($qtd) and  $qtd <> 0)
              $_SESSION['carrinho'][$id] = $qtd;
            else
              unset($_SESSION['carrinho'][$id]);    
        }
      }
    }
		
		
   }              
   
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="container mt-3">
<?php
     if(count($_SESSION['carrinho'])==0)
	 {
	       echo '<div class="text-center">Carrinho Vazio Retornar <a href="principal.php"> Clique aqui para Voltar </a>';
	 }
	 else
	 {
        include_once("conexao.php");
		echo ' <div class="card bg-primary text-white">
				<div class="card-body text-center">
				     <h4>Carrinho de Compras</h4>
				</div>
			  </div><br>';
		echo '<table class="table table-striped">
				<thead>
				  <tr>
					<th><center>Imagem</center></th>
					<th><center>Nome</center></th>
					<th><center>Preço</center></th>
					<th><center>Quantidade</center></th>
					<th><center>Total Item</center></th>
					<th><center>Remover</center></th>
				  </tr>
				</thead>
				<tbody>';
				$total = 0;
		echo '<form action="?acao=up" method="post">';
		foreach($_SESSION['carrinho'] as $id => $qtd)
	    {
		   $sql = "select * from produto where idproduto = $id";
		   if ($result = $conexao -> query($sql))
		   {
			   $linha     = $result -> fetch_assoc();
			   $nome      = $linha['nome'];
			   $preco     = $linha['preco'];
			   $imagem    = $linha['imagem'];
			   $precounit = $preco * $qtd;
			   $total += $precounit;
			   echo '<tr>';
			   echo '<td><center><img src="img/'.$imagem.'" width="100px" height="100px"></center></td>';
			    echo '<td><center>'.$nome.'</center></td>';
			   echo '<td><center> R$ '.number_format($preco,2,',','.').'</center></td>';
			   echo '<td><center>
			   <div class="form-group">				
			   <input type="number" class="form-control text-center" min="0" max="1000" name="prod['.$id.']" value="'.$qtd.'" >
			</div>
			   
			   </center></td>';
			   echo '<td><center> R$ '.number_format($precounit,2,',','.').'</center></td>';
			   echo '<td><center><a href="?id='.$id.'&acao=dell"><img src="img/del.png"></a></center></td>';
			   echo '</tr>';  
		   }		   
	    }
		echo '<tr>
		      <td><center><h6>Total</h6></center></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td><center><strong>'.number_format($total,2,',','.').'</strong></center></td>
			  <td></td>			  
			  </tr>';
			  
	    
				echo'<tr>';
				echo'<td colspan="3">';
				echo '<div class="d-grid">';
				echo'<a href="principal.php" type="button" class="btn btn-primary">Continuar Comprando</a>
				  </div>';
				echo'</td>';
				echo'<td colspan="3">';
				echo '<div class="d-grid">';
				echo'<button type="submit" class="btn btn-primary btn-block">Atualizar Carrinho</button>';
				echo '</div>';
				echo'</td>';
				echo'</tr>';
				
		
		echo '</tbody>
		       </table>
			   </form>';
			   
			   echo '<br>';
			   echo '  <div class="card bg-primary text-white">
    <div class="card-body text-center">Forma de Pagamento</div>
  </div>';
			echo '   
			<br>
			<form action="finalizar.php" method="post">
			<select class="form-select" name="forma" required>
			  <option value="">Selecione a Forma de Pagamento</option>
			  <option value="PIX">PIX</option>
			  <option value="CARTAO DE CREDITO">CARTÃO DE CRÉDITO</option>
			  <option value="CARTAO DE DEBITO">CARTÃO DE DÉBITO</option>
			  <option value="BOLETO">BOLETO</option>
			</select>';
      echo '<br>';
	  echo '<div class="d-grid">';
	  echo'<button type="submit" class="btn btn-primary">Finalizar Venda</a>
	        </form>
				  </div>';
			  
	    $conexao ->close();
	 }
	 
	 ?>

<br />

</div>
</body>
</html>
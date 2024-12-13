<!DOCTYPE php>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
</head>
<?php
$servername="mysql.escola25dejulho.com.br";
$username="escola25dejulh68";
$password="turma421";
$bd="escola25dejulh68";

//a classe query executa o SQL

//criando conexão
$conexao = new mysqli ($servername , $username, $password , $bd);

//checando conexão
if($conexao->connect_error){
    die ("Falha na Conexão" . $conexao->connect_error);
}
//echo "Conexão Efetuada com sucesso.<p>";
?>
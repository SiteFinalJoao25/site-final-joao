<!DOCTYPE php>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
</head>
<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "loja";
$conexao = mysqli_connect($servidor, $usuario, $senha, $dbname);
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>

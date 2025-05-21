<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "pi2";
$port = 3306;

$conexao = mysqli_connect($host,$user,$password,$database);

// if ($conexao)
// {
//     echo "Conexão realizada com sucesso! <br>";
// } else
// {
//     die ("Erro de conexão: " . mysqli_connect_error());
// }

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

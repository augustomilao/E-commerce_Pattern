<?php
// Variáveis e Conexão com o banco de dados
$servername = 'localhost';
$database = 'ecom';
$username = 'root';
$password = '';
$conn = new mysqli($servername, $username, $password, $database);

// Chequa Conexão
if ($conn->connect_error) {
  die("Erro de Conexão: " . $conn->connect_error);
}

?>
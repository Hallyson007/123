<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lojaeletronica";


// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Definir o conjunto de caracteres para UTF-8
$conn->set_charset("utf8mb4");

// Agora você pode usar a variável $conn para executar consultas no banco de dados



// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber os dados do formulário
$id = $_POST['id'];
$modelo = $_POST['modelo'];
$preco_mensal = $_POST['preco_mensal'];
$preco_avista = $_POST['preco_avista'];
$imagem_url = $_POST['imagem_url'];

// Preparar a query SQL
$sql = "INSERT INTO celulares (ID, Modelo, PrecoMensal, PrecoAVista, ImagemURL)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isdds", $id, $modelo, $preco_mensal, $preco_avista, $imagem_url);

// Executar a query SQL
if ($stmt->execute()) {
    echo "Novo registro criado com sucesso";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

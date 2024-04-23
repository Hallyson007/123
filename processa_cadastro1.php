<?php
// processa_cadastro.php
session_start();
$host = "localhost"; // ou o endereço do seu servidor de banco de dados
$usuario = "root";
$senha = "";
$dbname = "eletronico";

// Cria conexão
$conn = new mysqli($host, $usuario, $senha, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];

// Prepara a inserção no banco de dados para o cliente
$stmt_cliente = $conn->prepare("INSERT INTO clientes (nome, email) VALUES (?, ?)");
$stmt_cliente->bind_param("ss", $nome, $email);

// Executa a inserção do cliente
if ($stmt_cliente->execute()) {
    // Recupera o ID do cliente inserido
    $cliente_id = $stmt_cliente->insert_id;

    // Prepara a inserção no banco de dados para os produtos
    $stmt_produto = $conn->prepare("INSERT INTO pedidos (cliente_id, produto_nome, produto_preco) VALUES (?, ?, ?)");

    // Verifica se existem produtos no carrinho
    if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
        foreach ($_SESSION['carrinho'] as $id => $produto) {
            $stmt_produto->bind_param("iss", $cliente_id, $produto['nome'], $produto['preco']);
            $stmt_produto->execute();
        }
    }

    echo "Compra realizada com sucesso!";
    // Aqui você pode redirecionar para uma página de sucesso ou processar o pagamento
} else {
    echo "Erro: " . $stmt_cliente->error;
}

// Fecha as conexões
$stmt_cliente->close();
$stmt_produto->close();
$conn->close();

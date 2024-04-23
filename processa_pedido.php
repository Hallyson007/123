<?php
session_start();
include 'conexao.php'; // Inclui o arquivo de conexão ao banco de dados

// Verifica se há produtos no carrinho
if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
    // Prepara a query para inserir o pedido
    $query = "INSERT INTO Pedidos (cliente_id, produto_id, quantidade) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Processa cada produto no carrinho
    foreach ($_SESSION['carrinho'] as $produto_id => $detalhes) {
        $cliente_id = 1; // Substitua pelo ID do cliente autenticado
        $quantidade = $detalhes['quantidade'];
        $stmt->bind_param("iii", $cliente_id, $produto_id, $quantidade);
        $stmt->execute();
    }

    // Limpa o carrinho após processar o pedido
    unset($_SESSION['carrinho']);

    echo "Pedido realizado com sucesso!";
} else {
    echo "Seu carrinho está vazio.";
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
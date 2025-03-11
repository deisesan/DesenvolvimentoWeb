<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "estoque";
$conn = new mysqli($servername, $username, $password, $dbname);

$id = intval($_POST['id']);

$sql = "SELECT produto, saldo, preco_compra FROM produto WHERE codigo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $dados = $result->fetch_assoc();
    echo json_encode(["success" => true, "produto" => $dados['produto'], "saldo" =>
    $dados['saldo'], "preco_compra" => $dados['preco_compra']]);
} else {
    echo json_encode(["success" => false, "message" => "Item não encontrado"]);
}

$stmt->close();
$conn->close();

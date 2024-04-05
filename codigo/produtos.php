<?php
require_once "CreateDb.php";
$db = new CreateDb();
$conn = $db->getConnection();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . "<br>";
        echo "Imagem: " . $row["imagem"] . "<br>";
        echo "Nome: " . $row["nome"] . "<br>";
        echo "Preço: " . $row["preco"] . "<br>";
        echo "Quantidade: " . $row["quantidade"] . "<br>";
        echo "Descricao: " . $row["descricao"] . "<br><br>";
     
    }
} else {
    echo "Nenhum produto encontrado.";
}

$conn->close();
?>

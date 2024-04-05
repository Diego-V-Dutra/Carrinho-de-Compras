<?php
session_start();

if (isset($_POST['numero_cartao']) && isset($_POST['data_validade']) && isset($_POST['cvv'])) {
    $numero_cartao = $_POST['numero_cartao'];
    $data_validade = $_POST['data_validade'];
    $cvv = $_POST['cvv'];

    if (empty($numero_cartao) || strlen($numero_cartao) < 16) {        
        header("Location: carrinho.php");
        exit();
    } else if (empty($cvv) || strlen($cvv) < 3) {
        header("Location: carrinho.php");
        exit();
    } else if (empty($data_validade) || strlen($data_validade) < 4) {
        header("Location: carrinho.php");
        exit();
    } else {
        unset($_SESSION['carrinho']);
        header("Location: carrinho.php");
        exit();
    }
} else {
    header("Location: carrinho.php");
    exit();
}
?>

    
    

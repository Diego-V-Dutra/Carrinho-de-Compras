<?php
session_start();
require_once "CreateDb.php";
$db = new CreateDb();
$conn = $db->getConnection();
if (isset($_POST["produto_id"]) && isset($_POST["quantidade"])) {
    $produto_id = $_POST["produto_id"];
    $quantidade = $_POST["quantidade"];

    if (!isset($_SESSION["carrinho"])) {
        $_SESSION["carrinho"] = array();
    }

    if (isset($_SESSION["carrinho"][$produto_id])) {   
        $_SESSION["carrinho"][$produto_id] += $quantidade;
    } else {
        $_SESSION["carrinho"][$produto_id] = $quantidade;
    }

    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>

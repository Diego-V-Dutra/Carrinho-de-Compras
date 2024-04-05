<?php
session_start();
require_once "CreateDb.php";
$db = new CreateDb();
$conn = $db->getConnection();
if(!isset($_SESSION["carrinho"])){}else {
    $produto_ids = array_keys($_SESSION["carrinho"]);
}

if (!empty($produto_ids)) {
    $sql = "SELECT * FROM produtos WHERE id IN (" . implode(",", $produto_ids) . ")";
    $result = $conn->query($sql);

    $produtos = array();
    $preco_total = 0;
    $quantidade_total = 0;
 
    while ($row = $result->fetch_assoc()) {
        $produto_id = $row["id"];
        $quantidade = $_SESSION["carrinho"][$produto_id];

        $row["quantidade"] = $quantidade;
        $row["preco_produto"] = $row["preco"] * $quantidade;

        $produtos[] = $row;

        $quantidade_total += $quantidade;
        $preco_total += $row["preco_produto"];
    }
} 


if (isset($_GET["remover"]) && !empty($_GET["remover"])) {
    $produto_id = $_GET["remover"];
    unset($_SESSION["carrinho"][$produto_id]);
    header("Location: carrinho.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrinho</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <?php
        require_once ('header.php');
    ?>
    <div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6>Meu carrinho</h6>
                <hr>
        <?php
        $preco_total = 0;
        foreach ($produtos as $produto) {
            $preco_produto = $produto["preco"] * $produto["quantidade"]; 
            $preco_total += $preco_produto; 
            ?>
              <form action="carrinho.php?remover=<?php echo $produto["id"]; ?>" method="post" class="cart-items">
                    <div class="border rounded">
                        <div class="row bg-white">
                            <div class="col-md-3 pl-0">
                                <img src="<?php echo $produto["imagem"]; ?>" alt="Image1" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <h5 class="pt-2"> <?php echo $produto["nome"]; ?></h5>
                                <small class="text-secondary\"><?php echo $produto["descricao"]; ?></small>
                                <h5 class="pt-2">   R$ <?php echo $preco_produto; ?></h5>
                                <button type="submit" class="btn btn-danger mx-2" name="remove">Remover</button>
                            </div>
                            <div class="col-md-3 py-5">
                                <div>
                                    <h5>Quantidade:</h5>
                                    <?php echo $produto["quantidade"];?>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>                                                                
        <?php } ?>       
        </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">       
        <div class="pt-4">
                    <h6>DETALHES DE PREÇO</h6>
                    <hr>
                    <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                            if (isset($_SESSION['carrinho'])){                               
                                echo "<h6>Preço: ($quantidade_total unidades)</h6>";
                            }else{
                                echo "<h6>Preço: (0 unidades)</h6>";
                            }
                        ?>
                         <h6>Taxa de entrega:</h6>
                        <hr>
                        <h6>Preço total:</h6>
                    </div>
                    <div class="col-md-6">
                        <h6>$<?php echo $preco_total; ?></h6>
                        <h6 class="text-success">Grátis</h6>
                        <hr>
                        <h6>$<?php
                            echo $preco_total;
                            ?></h6>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>   
    <div class="container">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCartao">
            Finalizar Compra
        </button>

        <div class="modal fade" id="modalCartao" tabindex="-1" role="dialog" aria-labelledby="modalCartaoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCartaoLabel">Cartão de Crédito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="processar_compra.php" method="post">
                            <div class="form-group">
                                <label for="numero_cartao">Número do Cartão:</label>
                                <input type="text" class="form-control" id="numero_cartao" name="numero_cartao" required>
                            </div>
                            <div class="form-group">
                                <label for="data_validade">Data de Validade:</label>
                                <input type="text" class="form-control" id="data_validade" name="data_validade" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV:</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Concluir Compra</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        
    <?php
    if (isset($_GET["compra"]) && $_GET["compra"] === "sucesso") {
        echo "<p>Compra concluída com sucesso!</p>";
        $_SESSION["carrinho"] = array();
    }
    ?>
    <script type="text/javascript" src="script.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

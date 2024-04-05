<?php
session_start();

require_once("CreateDb.php");
$db = new CreateDb();

$conn = $db->getConnection();

$sql = "SELECT * FROM produtos";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Loja Virtual</title>   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require ("header.php"); ?>
    <div class="container">
        <div class="row text-center py-5">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow">
                        <div>
                        <img src="<?php echo $row["imagem"]; ?>" alt="Image1" class="img-fluid">

                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["nome"]; ?></h5>
                            <h6>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </h6>
                            <p class="card-text">
                               <?php echo $row["descricao"];?>
                            </p>
                            <h5>                                
                                <span class="price">R$ <?php echo $row["preco"]; ?></td></span>
                            </h5>
                            
                            <form action="adicionar_carrinho.php" method="POST">
                                <input type="hidden" name="produto_id" value="<?php echo $row["id"]; ?>">
                                <input type="number" name="quantidade" value="1" min="1">
                                <input type="submit" value="Adicionar ao carrinho" class="btn btn-warning my-3" name="add">
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile;?>   
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="index.php" class="navbar-brand">
            <h3 class="px-5">
                <i class="fas fa-shopping-basket"></i> Shopping Cart
            </h3>
        </a>
        <button class="navbar-toggler"
            type="button"
                data-toggle="collapse"
                data-target = "#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mr-auto"></div>
            <div class="navbar-nav">
                <a href="carrinho.php" class="nav-item nav-link active">
                    <h5 class="px-5 cart">
                        <i class="fas fa-shopping-cart"></i> Carrinho
                        <?php
                        if(!isset($_SESSION["carrinho"])){}else{
                            $produto_ids = array_keys($_SESSION["carrinho"]);
                        }

                        $quantidade_total = 0;

                        if (empty($produto_ids)) {
                            $produtos = array();
                        } else {
                            $sql = "SELECT * FROM produtos WHERE id IN (" . implode(",", $produto_ids) . ")";
                            $Result = $conn->query($sql);

                            $produtos = array();

                            while ($row = $Result->fetch_assoc()) {
                                $row["quantidade"] = $_SESSION["carrinho"][$row["id"]];
                                $produtos[] = $row;

                                $quantidade_total += $row["quantidade"];
                            }
                        }
                        echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$quantidade_total</span>";
                        ?>
                    </h5>
                </a>
            </div>
        </div>

    </nav>
</header>
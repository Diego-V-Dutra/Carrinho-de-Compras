<?php

class CreateDb
{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $conn;

    public function __construct(
        $dbname = "loja_virtual",
        $tablename = "produtos",
        $servername = "localhost",
        $username = "root",
        $password = ""
    ) {
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;

        $this->conn = mysqli_connect($servername, $username, $password);
   
        $createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
        
        mysqli_select_db($this->conn, $dbname);

        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        $tableExists = false;
        $tableCheckQuery = "SHOW TABLES LIKE '$tablename'";
        $tableCheckResult = mysqli_query($this->conn, $tableCheckQuery);

        if (mysqli_num_rows($tableCheckResult) > 0) {
            $tableExists = true;
        }

        if (!$tableExists) {
            $createTableQuery = "CREATE TABLE $tablename (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100),
                preco DECIMAL(10, 2),
                quantidade INT,
                descricao varchar(100),
                imagem varchar(100)
            )";          
            $insertDataQuery = "INSERT INTO $tablename (nome, preco, quantidade, descricao, imagem) VALUES
                ('Notebook Acer', 2999.99, 1, 'I5 8gb 256gb Ssd 15,6 Cinza', 'https://http2.mlstatic.com/D_NQ_NP_2X_781644-MLA53158468639_012023-F.webp'),
                ('Samsung Galaxy A03s', 1235.99, 1, 'Dual SIM 64 GB preto 4 GB RAM', 'https://http2.mlstatic.com/D_Q_NP_822006-MLA48160649416_112021-P.webp'),
                ('Monitor Gamer LG', 959.99, 1, '22mp410-b 21,5 Full Hd 75hz 5ms Hdmi Va Freesync', 'https://http2.mlstatic.com/D_NQ_NP_611126-MLA52286550419_112022-O.webp'),
                ('Smartphone Samsung Galaxy A14', 989.99, 1, 'Dual 6.6 128gb Preto 4gb Ram', 'https://http2.mlstatic.com/D_Q_NP_836188-MLB69376913224_052023-AB.webp')";
        }
    }
    public function getConnection()
    {
        return $this->conn;
    }
}
?>



<?php
class Vaga {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrarVaga($localizacao, $preco, $disponibilidade) {
        $query = "INSERT INTO vagas (localizacao, preco, disponibilidade) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $localizacao, $preco, $disponibilidade);
        return $stmt->execute();
    }
}
?>

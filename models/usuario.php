<?php

require_once('../config/conexao.php');
class usuario {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar(){

        $result = $this->conn->query("SELECT * FROM clientes");
        $users = array();
        while ($row = $result->fetch_assoc()) {
        $users[] = $row;
        }
        return $users;

    }

    public function listarId($id){

        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return $user;

    }

    public function inserir($nome, $email, $telefone) {

        $stmt = $this->conn->prepare("INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $telefone);
        $stmt->execute();
        $id_inserido = $stmt->insert_id; // Id inserido após o cadastro

        // Consulta SELECT para recuperar os dados do usuário inserido
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id_inserido);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        // Retornar usuário cadastrado
        echo json_encode($resultado);

    }

    public function atualizar($id, $nome, $email, $telefone) {

        $stmt = $this->conn->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $email, $telefone, $id);
        $stmt->execute();

        // Consulta SELECT para recuperar os dados do usuário inserido
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        // Retornar usuário cadastrado
        echo json_encode($resultado);

    }

    public function excluir($id) {

        $stmt = $this->conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

}



?>

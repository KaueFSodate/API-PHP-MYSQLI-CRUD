<?php

require_once "../models/usuario.php";


class usuarioController {
private $usuario;

public function __construct($usuario) {
  global $conn;
  $this->usuario = new usuario($conn);
}

  public function mostrar() {
    $usuarios = $this->usuario->listar();
    return json_encode($usuarios);
  }

  public function buscarPorId($id) {
    $usuarios = $this->usuario->listarId($id);
    return json_encode($usuarios);

  }

  public function inserir($dados) {
    $nome = $dados['nome'];
    $email = $dados['email'];
    $telefone = $dados['telefone'];
    $this->usuario->inserir($nome, $email, $telefone);
  }

  public function atualizar($id, $dados) {
    $nome = $dados['nome'];
    $email = $dados['email'];
    $telefone = $dados['telefone'];
    $this->usuario->atualizar($id, $nome, $email, $telefone);

  }

  public function remover($id) {
    $alterações = $this->usuario->excluir($id);
    return json_encode(array('alterações' => $alterações));
  }
}
?>
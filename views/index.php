<?php

// incluir o arquivo de configuração da aplicação
require_once '../config/conexao.php';

require_once '../models/usuario.php';

require_once '../controller/usuarioController.php';

$usuario = new usuario($conn);

// Criação da instância do controlador
$controller = new usuarioController($usuario);

// Definição das rotas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!empty($_GET['id'])) {
        echo $controller->buscarPorId($_GET['id']);
        } else {
        echo $controller->mostrar();
        }
        
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados = json_decode(file_get_contents("php://input"), true);
    return $controller->inserir($dados);

} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $dados = json_decode(file_get_contents("php://input"), true);
    $id = $_GET['id'];
    return $controller->atualizar($id, $dados);

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    echo $controller->remover($id);

}


?>

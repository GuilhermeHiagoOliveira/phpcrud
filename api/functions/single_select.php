<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../database.php';
include_once '../users.php';

$database = new Database();
$db = $database->getConnection();
$item = new Users($db);
$item->id = isset($_GET['id']) ? $_GET['id'] : die();
$item->getUser();
if ($item->nome != null) {

    $user_arr = array(
        "ID" => $item->id,
        "DataHoraCadastro" => $item->datahoracadastro,
        "Codigo" => $item->codigo,
        "Nome" => $item->nome,
        "CPF_CNPJ" => $item->cpfcnpj,
        "CEP" => $item->cep,
        "Logradouro" => $item->logradouro,
        "Numero" => $item->numero,
        "Bairro" => $item->bairro,
        "Cidade" => $item->cidade,
        "UF" => $item->uf,
        "Complemento" => $item->complemento,
        "Fone" => $item->fone,
        "Limitecredito" => $item->limitecredito,
        "Validade" => $item->validade
    );

    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    echo json_encode("User not found.");
}

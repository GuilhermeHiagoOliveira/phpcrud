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

$timezone = new DateTimeZone('America/Sao_Paulo');
$datetime = new DateTime('now', $timezone);

$keys = ['nome', 'cpfcnpj', 'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'uf', 'complemento', 'fone', 'limitecredito', 'validade'];

$item->id = isset($_GET['id']) ? $_GET['id'] : die();
$item->datahoracadastro = $datetime->format('Y-m-d H:i:s');

foreach ($keys as $k){
    if(isset($_GET[$k])){
        $item->$k = $_GET[$k];
    }
}

if ($item->updateUser()) {
    echo json_encode("User data updated.");
} else {
    echo json_encode("Data could not be updated");
}

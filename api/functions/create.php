<?php

header("Access-Control-Allow-Origin: *");
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

$bytes_number = 7;
$bytes_result = random_bytes($bytes_number);
$code = strtoupper(bin2hex($bytes_result));

$item->datahoracadastro = $datetime->format('Y-m-d H:i:s');
$item->codigo = $code;

$keys = ['nome', 'cpfcnpj', 'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'uf', 'complemento', 'fone'];

foreach ($keys as $k){
    if (isset($_GET[$k])){
        $item->$k = $_GET[$k];
    }
}

if ($item->createUser()) {
    echo 'User created successfully.';
} else {
    echo 'User could not be created.';
}

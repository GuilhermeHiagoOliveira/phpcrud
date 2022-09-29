<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../database.php';
include_once '../users.php';
$database = new Database();

$db = $database->getConnection();
$items = new Users($db);
$items->search = isset($_GET['search']) ? $_GET['search'] : die();
$records = $items->searchUsers();
$itemCount = $records->num_rows;
if ($itemCount > 0 ){
    $userArr = array();
    $userArr["body"] = array();
    while($row = $records->fetch_assoc()){
        array_push($userArr["body"], $row);
    }
    echo json_encode($userArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
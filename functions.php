<?php
include_once './db.php';

if (isset($_POST['function'])) {
    $function = $_POST['function'];

    if ($function == 'storeUser') {

        // Generate Code
        $bytes_number = 7;
        $bytes_result = random_bytes($bytes_number);
        $code = strtoupper(bin2hex($bytes_result));
        //  -----------

        $timezone = new DateTimeZone('America/Sao_Paulo');
        $datetime = new DateTime('now', $timezone);
        
        $data = [
            'name' => $_POST['name'],
            'cpfcnpj' => $_POST['cpfcnpj'],
            'cep' => $_POST['cep'],
            'street' => $_POST['street'],
            'number' => $_POST['number'],
            'district' => $_POST['district'],
            'city' => $_POST['city'],
            'uf' => $_POST['uf'],
            'complement' => $_POST['complement'],
            'phone' => $_POST['phone'],
            'creditlimit' => 0,
            'validity' => '2022-01-01',
            'created_at' => $datetime->format('Y-m-d H:i:s'),
            'code' => $code
        ];

        storeUser($data, $conn);
    }

    if ($function == 'deleteUser') {
        $id = $_POST['id'];
        deleteUser($id, $conn);
    }

    if ($function == 'findUser') {
        $id = $_POST['id'];
        findUser($id, $conn);
    }

    if ($function == 'editUser') {

        $data = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'cpfcnpj' => $_POST['cpfcnpj'],
            'cep' => $_POST['cep'],
            'street' => $_POST['street'],
            'number' => $_POST['number'],
            'district' => $_POST['district'],
            'city' => $_POST['city'],
            'uf' => $_POST['uf'],
            'complement' => $_POST['complement'],
            'phone' => $_POST['phone'],
            'creditlimit' => $_POST['creditlimit'],
            'validity' => $_POST['validity']
        ];
        editUser($data, $conn);
    }
}


function storeUser($data, $conn)
{
    $query = "INSERT INTO users (DataHoraCadastro, Codigo, Nome, CPF_CNPJ, CEP, Logradouro, Numero, Bairro, Cidade, UF, Complemento, Fone, LimiteCredito, Validade) VALUES ('" . $data['created_at'] . "', '" . $data['code'] . "', '" . $data['name'] . "','" . $data['cpfcnpj'] . "','" . $data['cep'] . "','" . $data['street'] . "','" . $data['number'] . "','" . $data['district'] . "','" . $data['city'] . "','" . $data['uf'] . "','" . $data['complement'] . "','" . $data['phone'] . "','" . $data['creditlimit'] . "','" . $data['validity'] . "')";
    $storeUser = $conn->prepare($query);
    $storeUser->execute();
}

function deleteUser($id, $conn)
{
    $query = "DELETE FROM users WHERE ID = " . $id;
    $deleteUser = $conn->prepare($query);
    $deleteUser->execute();
}

function findUser($id, $conn)
{
    $query = "SELECT * FROM users where ID = " . $id;
    $findUser = $conn->prepare($query);
    $findUser->execute();
    $user = $findUser->fetch(PDO::FETCH_ASSOC);
    echo json_encode($user);
}

function editUser($data, $conn)
{
    $query = "UPDATE users SET Nome = '" . $data['name'] . "', CPF_CNPJ = '" . $data['cpfcnpj'] . "', CEP = '" . $data['cep'] . "', Logradouro = '" . $data['street'] . "', Numero = '" . $data['number'] . "', Bairro = '" . $data['district'] . '", Cidade = "' . $data['city'] . "', UF = '" . $data['uf'] . "', Complemento = '" . $data['complement'] . "', Fone = '" . $data['phone'] . "', LimiteCredito = '" . $data['creditlimit'] . "', Validade = '" . $data['validity'] . "' WHERE ID = " . $data['id'];
    $storeUser = $conn->prepare($query);
    $storeUser->execute();
}

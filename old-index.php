<?php
include_once "./db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quality - Sign Up</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <main class="d-flex justify-content-center align-items-center">
        <div class="card d-flex p-5 text-center">
            <h1> Quality - CRUD</h1>
            <hr>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                Cadastrar Usuário
            </button>

            <div class="d-flex mt-3 mb-3">
                <form class="input-group border rounded d-flex align-items-center" action="" method="post">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" height="30" width="30">

                        <path d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z" />
                    </svg>
                    <input class="form-control" type="search" name="search" id="search">
                    <input class="btn btn-info" type="submit" name="submit" value="Procurar">
                </form>
            </div>

            <?php
            if (isset($_POST['submit'])) {
                //  Codigo, Nome, Cidade, CEP
                $search = $_POST['search'];
                $query = "SELECT * FROM users WHERE Codigo = '". $search . "' OR Nome LIKE '%" . $search . "%' OR Cidade LIKE '%" . $search . "%' OR CEP = '%" . $search . "%'";
                $users = $conn->prepare($query);
                $users->execute();
            } else {
                $query = "SELECT * FROM users";
                $users = $conn->prepare($query);
                $users->execute();
            }
            if ($users and $users->rowCount() != 0) {
            ?>
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Crédito</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <th scope="row"><span class="d-flex"><?= $row['ID']; ?></span></th>
                                <td>
                                    <p class="m-0 d-flex"><b class="me-1">Data Cadastrada: </b><?= date('d/m/Y H:i:s', strtotime($row['DataHoraCadastro'])); ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Código: </b><?= $row['Codigo']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Nome: </b><?= $row['Nome']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">CPF/CNPJ: </b><?= $row['CPF_CNPJ']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Fone: </b><?= $row['Fone']; ?></p>
                                </td>
                                <td>
                                    <p class="m-0 d-flex"><b class="me-1">Rua: </b><?= $row['Logradouro']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Número: </b><?= $row['Numero']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Bairro: </b><?= $row['Bairro']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Cidade: </b><?= $row['Cidade']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">UF: </b><?= $row['UF']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Complemento: </b><?= $row['Complemento']; ?></p>
                                </td>
                                <td>
                                    <p class="m-0 d-flex"><b class="me-1">Limite de Crédito: </b><?= $row['LimiteCredito']; ?></p>
                                    <p class="m-0 d-flex"><b class="me-1">Validade: </b> <?= date('d/m/Y', strtotime($row['Validade'])); ?></p>
                                </td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUser(<?= $row['ID']; ?>)" class="btn btn-primary">Editar</button>
                                    <button onclick="deleteUser(<?= $row['ID']; ?>)" class="btn btn-danger">Excluir</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "<p style='color: #ff0000;'>Nenhum usuário encontrado!";
            }
            ?>
        </div>
    </main>


    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="d-flex justify-content-center align-items-center">
            <div class="modal-dialog d-flex">
                <div class="modal-content d-flex p-5 text-center">
                    <h1 class="mb-3">Cadastro de Usuários</h1>
                    <form onsubmit="return handleForm()">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Nome" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="cpfcnpj" placeholder="CPF ou CNPJ" data-mask-for-cpf-cnpj required>
                            <input type="text" class="form-control" id="cep" placeholder="CEP" data-mask-for-cep required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="street" placeholder="Logradouro" disabled required>
                            <input type="number" class="form-control" id="number" placeholder="Número" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="district" placeholder="Bairro" disabled required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="city" placeholder="Cidade" disabled required>
                            <input type="text" class="form-control" id="uf" placeholder="UF" disabled required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="complement" placeholder="Complemento">
                            <input type="text" class="form-control" id="phone" placeholder="Fone" data-mask-for-fone required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="d-flex justify-content-center align-items-center">
            <div class="modal-dialog d-flex">
                <div class="modal-content d-flex p-5 text-center">
                    <h1 class="mb-3">Editar Usuário</h1>
                    <form onsubmit="return handleEditForm()">
                        <div class="input-group mb-3">
                            <input type="hidden" id="edit-id">
                            <input type="text" class="form-control" id="edit-name" placeholder="Nome" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="edit-cpfcnpj" placeholder="CPF ou CNPJ" data-mask-for-cpf-cnpj required>
                            <input type="text" class="form-control" id="edit-cep" placeholder="CEP" data-mask-for-cep required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="edit-street" placeholder="Logradouro" disabled required>
                            <input type="number" class="form-control" id="edit-number" placeholder="Número" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="edit-district" placeholder="Bairro" disabled required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="edit-city" placeholder="Cidade" disabled required>
                            <input type="text" class="form-control" id="edit-uf" placeholder="UF" disabled required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="edit-complement" placeholder="Complemento">
                            <input type="text" class="form-control" id="edit-phone" placeholder="Fone" data-mask-for-fone required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control me-1" id="edit-creditlimit" placeholder="Limite de Crédito">
                            <input type="date" class="form-control" id="edit-validity" placeholder="Validade">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Editar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loader -->
    <div id="loader" class="d-flex justify-content-center align-items-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Jquery and Jquery Mask-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CPF / CNPJ Validator -->
    <script src="./src/validateCpfCnpj.js"></script>

    <!-- Custom JS -->
    <script src="./src/script.js"></script>
</body>

</html>
// Data masks -------------------------------------

$(document).on('keydown', '[data-mask-for-cpf-cnpj]', function (e) {
    var digit = e.key.replace(/\D/g, '');
    var value = $(this).val().replace(/\D/g, '');
    var size = value.concat(digit).length;
    $(this).mask((size <= 11) ? '000.000.000-00' : '00.000.000/0000-00');
});

$(document).on('keydown', '[data-mask-for-cep]', function () {
    $(this).mask('00000-000');
});

$(document).on('keydown', '[data-mask-for-fone]', function (e) {
    var digit = e.key.replace(/\D/g, '');
    var value = $(this).val().replace(/\D/g, '');
    var size = value.concat(digit).length;
    $(this).mask((size <= 10) ? '(00)0000-0000' : '(00)00000-0000');
});

$('#edit-creditlimit').mask("00000000.00", {reverse: true});

// ---------------------------------------------

// CPF CNPJ Validator --------------------------

$("#cpfcnpj").blur(function () {
    if (valida_cpf_cnpj(document.getElementById('cpfcnpj').value)) {
        document.getElementById('cpfcnpj').style.border = '1px solid rgb(206, 212, 218)';
    } else {
        alert('CPF ou CNPJ inválido!');
        document.getElementById('cpfcnpj').style.border = '2px solid red';
    }
});

$("#edit-cpfcnpj").blur(function () {
    if (valida_cpf_cnpj(document.getElementById('edit-cpfcnpj').value)) {
        document.getElementById('edit-cpfcnpj').style.border = '1px solid rgb(206, 212, 218)';
    } else {
        alert('CPF ou CNPJ inválido!');
        document.getElementById('edit-cpfcnpj').style.border = '2px solid red';
    }
});

// ----------------------------------------------

// Via Cep --------------------------------------

function clean_form() {
    $("#street").val("");
    $("#district").val("");
    $("#city").val("");
    $("#uf").val("");
}

$("#cep").blur(function () {
    var cep = $(this).val().replace(/\D/g, '');
    if (cep != "") {
        var validateCep = /^[0-9]{8}$/;
        if (validateCep.test(cep)) {
            $("#loader").css("visibility", "visible")
            $("#street").val("...");
            $("#district").val("...");
            $("#city").val("...");
            $("#uf").val("...");

            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (data) {

                if (!("erro" in data)) {
                    $("#street").val(data.logradouro);
                    $("#district").val(data.bairro);
                    $("#city").val(data.localidade);
                    $("#uf").val(data.uf);
                    $("#loader").css("visibility", "hidden")
                    document.getElementById('cep').style.border = '1px solid rgb(206, 212, 218)';
                } else {
                    clean_form();
                    alert("CEP não encontrado.");
                    $("#loader").css("visibility", "hidden")
                    document.getElementById('cep').style.border = '2px solid red';
                }
            });
        }
        else {
            clean_form();
            alert("Formato de CEP inválido.");
            $("#loader").css("visibility", "hidden")
            document.getElementById('cep').style.border = '2px solid red';
        }
    }
    else {
        clean_form();
        $("#loader").css("visibility", "hidden")
    }
});

function clean_form() {
    $("#edit-street").val("");
    $("#edit-district").val("");
    $("#edit-city").val("");
    $("#edit-uf").val("");
}

$("#edit-cep").blur(function () {
    var cep = $(this).val().replace(/\D/g, '');
    if (cep != "") {
        var validateCep = /^[0-9]{8}$/;
        if (validateCep.test(cep)) {
            $("#edit-loader").css("visibility", "visible")
            $("#edit-street").val("...");
            $("#edit-district").val("...");
            $("#edit-city").val("...");
            $("#edit-uf").val("...");

            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (data) {

                if (!("erro" in data)) {
                    $("#edit-street").val(data.logradouro);
                    $("#edit-district").val(data.bairro);
                    $("#edit-city").val(data.localidade);
                    $("#edit-uf").val(data.uf);
                    $("#loader").css("visibility", "hidden")
                    document.getElementById('cep').style.border = '1px solid rgb(206, 212, 218)';
                } else {
                    clean_form();
                    alert("CEP não encontrado.");
                    $("#loader").css("visibility", "hidden")
                    document.getElementById('cep').style.border = '2px solid red';
                }
            });
        }
        else {
            clean_form();
            alert("Formato de CEP inválido.");
            $("#loader").css("visibility", "hidden")
            document.getElementById('cep').style.border = '2px solid red';
        }
    }
    else {
        clean_form();
        $("#loader").css("visibility", "hidden")
    }
});

//  -------------------------------------------------------------

// Filter -------------------------------------------------------

// $("#search").blur(function () {
//     var search = $("#search").val();
//     $.ajax({
//         url: 'functions.php',
//         type: 'post',
//         data: {
//             function: "search",
//             search: search
//         },
//         success: function (data) {
//             console.log(data);
//         }
//     });
// });

// --------------------------------------------------------------

function handleForm() {
    $.ajax({
        url: 'functions.php',
        type: 'post',
        data: {
            function: "storeUser",
            name: $('#name').val(),
            cpfcnpj: $('#cpfcnpj').val(),
            cep: $('#cep').val(),
            street: $('#street').val(),
            number: $('#number').val(),
            district: $('#district').val(),
            city: $('#city').val(),
            uf: $('#uf').val(),
            complement: $('#complement').val(),
            phone: $('#phone').val()
        },
        success: function () {
            alert('Cadastrado com sucesso!');
            window.location.reload();
            return true;
        },
        error: function (request, status, error) {
            alert('error');
            return false;
        }
    });
}

function deleteUser(id) {
    $.ajax({
        url: 'functions.php',
        type: 'post',
        data: {
            function: "deleteUser",
            id: id
        },
        success: function () {
            alert('Usuário deletado com sucesso!');
            window.location.reload();
            return true;
        }
    });
}

function editUser(id) {
    $.ajax({
        url: 'functions.php',
        type: 'post',
        data: {
            function: "findUser",
            id: id
        },
        success: function (data) {
            data = JSON.parse(data);
            console.log(data['Nome']);
            $('#edit-id').val(data['ID']);
            $('#edit-name').val(data['Nome']);
            $('#edit-cpfcnpj').val(data['CPF_CNPJ']);
            $('#edit-cep').val(data['CEP']);
            $('#edit-street').val(data['Logradouro']);
            $('#edit-number').val(data['Numero']);
            $('#edit-district').val(data['Bairro']);
            $('#edit-city').val(data['Cidade']);
            $('#edit-uf').val(data['UF']);
            $('#edit-complement').val(data['Complemento']);
            $('#edit-phone').val(data['Fone']);
            $('#edit-validity').val(data['Validade']);
            $('#edit-creditlimit').val(data['LimiteCredito']);
        }
    });
}

function handleEditForm() {
    $.ajax({
        url: 'functions.php',
        type: 'post',
        data: {
            function: "editUser",
            id: $('#edit-id').val(),
            name: $('#edit-name').val(),
            cpfcnpj: $('#edit-cpfcnpj').val(),
            cep: $('#edit-cep').val(),
            street: $('#edit-street').val(),
            number: $('#edit-number').val(),
            district: $('#edit-district').val(),
            city: $('#edit-city').val(),
            uf: $('#edit-uf').val(),
            complement: $('#edit-complement').val(),
            phone: $('#edit-phone').val(),
            validity: $('#edit-validity').val(),
            creditlimit: $('#edit-creditlimit').val()
        },
        success: function () {
            alert('Usuário atualizado com sucesso!');
            window.location.reload();
            return true;
        },
        error: function (request, status, error) {
            alert('error');
            return false;
        }
    });
}
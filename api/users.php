<?php
class Users
{
    private $db;
    private $db_table = "users";
    private $columns = "ID, DataHoraCadastro, Codigo, Nome, CPF_CNPJ, CEP, Logradouro, Numero, Bairro, Cidade, UF, Complemento, Fone, LimiteCredito, Validade";
    private $keys = ['nome', 'cpfcnpj', 'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'uf', 'complemento', 'fone', 'limitecredito', 'validade'];

    public $id;
    public $datahoracadastro;
    public $codigo;
    public $nome;
    public $cpfcnpj;
    public $cep;
    public $logradouro;
    public $numero;
    public $bairro;
    public $cidade;
    public $uf;
    public $complemento;
    public $fone;
    public $limitecredito;
    public $validade;
    public $result;

    public $search;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUsers()
    {
        $query = "SELECT " . $this->columns . " FROM " . $this->db_table;
        $this->result = $this->db->query($query);
        return $this->result;
    }

    public function getUser()
    {
        $query = "SELECT " . $this->columns . " FROM " . $this->db_table . " WHERE ID = " . $this->id;
        $record = $this->db->query($query);
        $dataRow = $record->fetch_assoc();
        if ($dataRow) {
            $this->id = $dataRow['ID'];
            $this->datahoracadastro = $dataRow['DataHoraCadastro'];
            $this->codigo = $dataRow['Codigo'];
            $this->nome = $dataRow['Nome'];
            $this->cpfcnpj = $dataRow['CPF_CNPJ'];
            $this->cep = $dataRow['CEP'];
            $this->logradouro = $dataRow['Logradouro'];
            $this->numero = $dataRow['Numero'];
            $this->bairro = $dataRow['Bairro'];
            $this->cidade = $dataRow['Cidade'];
            $this->uf = $dataRow['UF'];
            $this->complemento = $dataRow['Complemento'];
            $this->fone = $dataRow['Fone'];
            $this->limitecredito = $dataRow['LimiteCredito'];
            $this->validade = $dataRow['Validade'];
        }
    }

    public function createUser()
    {
        $keys = ['datahoracadastro', 'codigo', 'nome', 'cpfcnpj', 'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'uf', 'complemento', 'fone'];
        foreach ($keys as $k) {
            $this->$k = htmlspecialchars(strip_tags($this->$k));
            if ($this->$k == '' || $this->$k == null) {
                if ($k != 'complemento') {
                    return false;
                }
            }
        }
        
        $query = "INSERT INTO " . $this->db_table . " SET DataHoraCadastro = '" . $this->datahoracadastro . "', Codigo = '" . $this->codigo . "', Nome = '" . $this->nome . "',
            CPF_CNPJ = '" . $this->cpfcnpj . "', CEP = '" . $this->cep . "', Logradouro = '" . $this->logradouro . "', Numero = '" . $this->numero . "', 
            Bairro = '" . $this->bairro . "', Cidade = '" . $this->cidade . "', UF = '" . $this->uf . "', Complemento = '" . $this->complemento . "', 
            Fone = '" . $this->fone . "'";

        // return $query;
        $this->db->query($query);

        if ($this->db->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser()
    {
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cpfcnpj = htmlspecialchars(strip_tags($this->cpfcnpj));
        $this->cep = htmlspecialchars(strip_tags($this->cep));
        $this->logradouro = htmlspecialchars(strip_tags($this->logradouro));
        $this->numero = htmlspecialchars(strip_tags($this->numero));
        $this->bairro = htmlspecialchars(strip_tags($this->bairro));
        $this->cidade = htmlspecialchars(strip_tags($this->cidade));
        $this->uf = htmlspecialchars(strip_tags($this->uf));
        $this->complemento = htmlspecialchars(strip_tags($this->complemento));
        $this->fone = htmlspecialchars(strip_tags($this->fone));
        $this->limitecredito = htmlspecialchars(strip_tags($this->limitecredito));
        $this->validade = htmlspecialchars(strip_tags($this->validade));

        $query = "UPDATE " . $this->db_table . " SET ";

        foreach ($this->keys as $k) {
            if ($this->$k != "" || $this->$k != null) {
                if ($k === "cep" or $k === "uf") {
                    $col = strtoupper($k);
                } else if ($k === "cpfcnpj") {
                    $col = "CPF_CNPJ";
                } else if ($k === "limitecredito") {
                    $col = "LimiteCredito";
                } else {
                    $col = ucfirst($k);
                }
                $query = $query . $col . " = '" . $this->$k . "',";
            }
        }
        $query = rtrim($query, ",")  . " WHERE ID = " . $this->id;


        $this->db->query($query);
        if ($this->db->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser()
    {
        $query = "DELETE FROM " . $this->db_table . " WHERE ID = " . $this->id;

        $this->db->query($query);
        if ($this->db->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function searchUsers()
    {
        $query = "SELECT " . $this->columns . " FROM " . $this->db_table . " WHERE Codigo = '" . $this->search . "' OR Nome LIKE '%" . $this->search . "%' OR Cidade LIKE '%" . $this->search . "%' OR CEP = '%" . $this->search . "%'";
        $this->result = $this->db->query($query);
        return $this->result;
        
    }
}

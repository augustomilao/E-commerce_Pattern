<?php
require_once '../connect.php';

class Usuario
{
    public $id;
    public $nome;
    public $telefone;
    public $CEP;
    public $CPF;
    public $email;
    public $data_criacao;
    public $senha;
    public $ultimo_acesso;

    // Verifica se já existe o CPF cadastrado
    public function verificaCPF($conn, $CPF)
    {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE CPF = ?");
        $stmt->bind_param("s", $CPF);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if($result == NULL){
            return false;
        }else{
            return true;
        }
    }

    // Verifica se já existe o E-mail cadastrado
    public function verificaEmail($conn,$email)
    {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if($result == NULL){
            return false;
        }else{
            return true;
        }
    }

    // Cria Usuário
    public function setUsuario($conn, $nome, $telefone, $CEP, $CPF, $email, $data_criacao, $senha, $ultimo_acesso){
        $usuario = new Usuario;

        $ok1 = $usuario->verificaCPF($conn, $CPF);
        if(!empty($ok1)){ return "CPF já cadastrado"; die;}
        $ok2 = $usuario->verificaEmail($conn,$email);
        if(!empty($ok2)){ return "E-mail já cadastrado"; die;}

        $senha = sha1($senha);
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, telefone, CEP, CPF, email, data_criacao, senha, ultimo_acesso) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nome, $telefone, $CEP, $CPF, $email, $data_criacao, $senha, $ultimo_acesso);
        $stmt->execute();
        return "Cadastrado";
    }

    // Busca Usuário se baseando em Email/CPF e Senha
    public function getUsuario($conn, $login, $senha){
        $senha = sha1($senha);
        $stmt = $conn->prepare("SELECT id, nome, telefone, CEP, CPF, email, data_criacao, ultimo_acesso FROM usuarios WHERE (email = ? OR CPF = ?) AND senha= ?");
        $stmt->bind_param("sss", $login, $login, $senha);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    // Atualiza ultimo acesso
    public function AtualizarAcesso($conn, $acesso, $id){
        $stmt = $conn->prepare("UPDATE usuarios SET ultimo_acesso = ? WHERE id = ?");
        $stmt->bind_param("si", $acesso, $id);
        $stmt->execute();
        return "Atualizado";
    }

}

$usuario = new Usuario;

$user = $usuario->AtualizarAcesso($conn,'HOJE','1');
var_dump($user);
?>
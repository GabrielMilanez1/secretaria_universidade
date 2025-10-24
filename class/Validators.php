<?php

require_once 'Utilidades.php';
require_once 'Cargo.php';

Class Validators
{
  public static function validaNome($nome)
  {
    $nome = strip_tags($nome);
    
    if (strlen($nome) >= 3 && strlen($nome) <= 30) {
      return $nome;
    }

    throw new \Exception('Nome inválido');
  }

  public static function validaDataNascimento($data_nascimento)
  {
    $data_nascimento = strip_tags($data_nascimento);

    $data_obj = \DateTime::createFromFormat('Y-m-d', $data_nascimento);
    if (!$data_obj || $data_obj->format('Y-m-d') !== $data_nascimento) {
        throw new \Exception('Data de nascimento inválida.');
    }

    $hoje = new \DateTime();
    if ($data_obj > $hoje) {
        throw new \Exception('A data de nascimento não pode ser uma data futura.');
    }

    return $data_nascimento;

  }

  public static function validaCpf($cpf)
  {
    $cpf = strip_tags(trim($cpf));
    
    $cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf_limpo) !== 11) {
        throw new \Exception('CPF inválido. Deve conter 11 dígitos.');
    }

    if (!Utilidades::validaCPF($cpf_limpo)) {
        throw new \Exception('CPF inválido.');
    }

    return $cpf_limpo;
  }

  public static function validaEmail($email)
  {
    $email_limpo = strip_tags(trim($email));

    if (!filter_var($email_limpo, FILTER_VALIDATE_EMAIL)) {
        throw new \Exception('O endereço de e-mail é inválido.');
    }

    $email_sanitizado = filter_var($email_limpo, FILTER_SANITIZE_EMAIL);
    
    return $email_sanitizado;
  }

  public static function validaSenha($senha_pura)
  {
      $senha_pura = strip_tags(trim($senha_pura));

      if (strlen($senha_pura) < 8 || strlen($senha_pura) > 255) {
          throw new \Exception('A senha deve ter no mínimo 8 e no máximo 255 caracteres.');
      }

      $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

      if (!preg_match($pattern, $senha_pura)) {
          throw new \Exception('A senha deve conter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos.');
      }

      return md5($senha_pura);
  }

  public static function validaIdCargo($id_cargo)
  {
    $id_limpo = filter_var($id_cargo, FILTER_SANITIZE_NUMBER_INT);

    if (filter_var($id_limpo, FILTER_VALIDATE_INT) === false || (int)$id_limpo <= 0) {
        throw new \Exception('ID do cargo inválido. Deve ser um número inteiro positivo.');
    }

    $cargos_disponiveis = Cargo::idsCargosDisponiveis();
    if (!in_array($id_limpo, $cargos_disponiveis)) {
        throw new \Exception('ID inválido.');
    }
    
    return (int)$id_limpo;
  }

  public static function validaNomeTurma($nome)
  {
    $nome = strip_tags($nome);

    if (strlen($nome) > 3 && strlen($nome) <= 50) {
      return $nome;
    }

    throw new \Exception('Nome da turma inválido. Deve ter mais de 3 caracteres e no máximo 50 caracteres.');
  }

  public static function validaDescricaoTurma($descricao)
  {
    $descricao = strip_tags($descricao);

    if (strlen($descricao) > 3 && strlen($descricao) <= 255){
        return $descricao;
    }

    throw new \Exception('Descrição da turma inválida. Deve ter mais de 3 caracteres e no máximo 255 caracteres.');
  }

  public static function validaId($id_turma)
  {
    $id_limpo = filter_var($id_turma, FILTER_SANITIZE_NUMBER_INT);

    return $id_limpo;
  }
  
}
<?php

require_once 'Cargo.php';

class Session
{

  private $id;
  private $email;
  private $nome;
  private $data_login;
  private $cargo;

  public function __construct()
  {
    $this->id = $_SESSION['id'] ?: '';
    $this->email = $_SESSION['email'] ?: '';
    $this->nome = $_SESSION['nome'] ?: '';
    $this->data_login = $_SESSION['data_login'] ?: '';
    $this->cargo = $_SESSION['cargo'] ?: '';
  }


  public function setId($id)
  {
    $this->id = $id;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  public function getNome()
  {
    return $this->nome;
  }

  public function setDataLogin($data_login)
  {
    $this->data_login = $data_login;
  }

  public function getDataLogin()
  {
    return $this->data_login;
  }

  public function setCargo($cargo)
  {
    $this->cargo = $cargo;
  }

  public function getCargo()
  {
    return $this->cargo;
  }

  public function usuarioLogado()
  {
    return isset($_SESSION['email']) && !empty($_SESSION['email']);
  }

  public function usuarioAdm()
  {
    return $this->cargo == Cargo::ADMINISTRADOR;
  }

  public function usuarioAluno()
  {
    return $this->cargo == Cargo::ALUNO;
  }

  public function save()
  {
    $_SESSION['id'] = $this->id;
    $_SESSION['email'] = $this->email;
    $_SESSION['nome'] = $this->nome;
    $_SESSION['data_login'] = $this->data_login;
    $_SESSION['cargo'] = $this->cargo;

    return $_SESSION;
  }


  
}
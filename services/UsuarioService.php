<?php

Class UsuarioService
{
  
  public static function login($email, $password)
  {
    $objusuario = new Usuario();
    $user = $objusuario->getByEmail($email);
  
    if ($user && $user['senha'] === (string) md5($password)) {

      $session = new Session();
      
      $session->setId($user['id']);
      $session->setEmail($user['email']);
      $session->setNome($user['nome']);
      $session->setDataLogin(date("d/m/Y - H:i:s"));
      $session->setCargo($user['id_cargo']);
      
      $session->save();

      session_write_close();

      return true;
    }

    return false;
  }
}
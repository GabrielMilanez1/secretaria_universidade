<?php

Class Utilidades
{
  public static function formatarCelular($numero)
  {
    $numero = preg_replace("/[^0-9]/", "", $numero);
    $numeroFormatado = '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 1) . ' ' . substr($numero, 3, 4) . '-' . substr($numero, 7, 4);
    
    return $numeroFormatado;
  }

  public static function formataNome($nome)
  {
    $nome_formatado = explode(' ', $nome)[0];
    $nome_formatado = strtolower($nome_formatado);
    $nome_formatado = ucfirst($nome_formatado);

    return $nome_formatado;
  }

  public static function formataDataBr($data) 
  {
    if (empty($data)) {
        return null;
    }
    return date('d/m/Y', strtotime($data));
  }

  public static function formataCpf($cpf)
  {
    // Remove qualquer caractere que não seja número
    $cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF limpo tem 11 dígitos
    if (strlen($cpf_limpo) === 11) {
        // Aplica a máscara de CPF
        return substr($cpf_limpo, 0, 3) . '.' . substr($cpf_limpo, 3, 3) . '.' . substr($cpf_limpo, 6, 3) . '-' . substr($cpf_limpo, 9, 2);
    }
    return null; // Retorna null se o CPF não tiver 11 dígitos válidos para formatação
  }

  public static function validaCPF($cpf) 
  {

    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

  }
  
}
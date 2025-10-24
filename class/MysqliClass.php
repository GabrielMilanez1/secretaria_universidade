<?php

require_once 'Config.php';

class MysqliClass
{

  private $server_name;
  private $username;
  private $password;
  private $db_name;
  private $mysqli_connection;
  private $conn;
  
  function __construct()
  {
    $this->server_name = Config::getServerName();
    $this->username = Config::getUsername();;
    $this->password = Config::getPassword();
    $this->db_name = Config::getDbName();

    $this->mysqli_connection = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
    $this->conn = mysqli_connect($this->server_name, $this->username, $this->password, $this->db_name);
  }

  public function getResultsQuery($query)
  {
    $result = mysqli_query($this->conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    } 
  }

  public function getConn()
  {
    return $this->conn;
  }

  public function getMysqliConnection()
  {
    return $this->mysqli_connection;
  }
  
}
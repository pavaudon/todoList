<?php

class Database {
  private $host= "localhost";
  private $dbname= "todolist";
  private $user= "root";
  private $password= "";

  public function getConnexion() {
    $conn = null;
    try {
      $conn = new PDO(
        "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
        $this->user,
        $this->password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (\PDOException  $e) {
      echo "Erreur de connexion : " . $e->getMessage();
    }
    return $conn;
  }
}
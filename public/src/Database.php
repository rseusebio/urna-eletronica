<?php
namespace Src;

/**
 * Classe responsavel por fazer 
 * a conexao com o banco de dados.
 */
class Database {

  private $dbConnection = null;

  public function __construct()
  {
    $host = $_ENV['DB_HOST'];
    $port = $_ENV['DB_PORT'];
    $db   = $_ENV['DB_DATABASE'];
    $user = $_ENV['DB_USERNAME'];
    $pass = $_ENV['DB_PASSWORD'];

    try {
      
      $this->dbConnection = new \PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
      $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    } catch (\PDOException $e) {

      print "Something wrong with connection" . " " . $e->getMessage() . " " . $e->getTraceAsString() . "\n";

    }
  }

  public function connet()
  {
    return $this->dbConnection;
  }
}
<?php
namespace Src;

class Database {

  private $dbConnection = null;

  public function __construct()
  {
    $host = $_ENV['DB_HOST'];
    $port = $_ENV['DB_PORT'];
    $db   = $_ENV['DB_DATABASE'];
    $user = $_ENV['DB_USERNAME'];
    $pass = $_ENV['DB_PASSWORD'];

    // print $host . ' ' . $port . ' ' . $db . ' ' . $user . ' ' . $pass . "\n";

    try {
      // $this->dbConnection = new \PDO(
      //     "mysql:host=$host;port=$port;dbname=$db",
      //     $user,
      //     $pass
      // );

      $this->dbConnection = new \PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
      
      // $this->dbConnection = mysqli_connect($host, $user, $pass, $db, $port);

      if (!$this->dbConnection) 
      {
        print "error: " . mysqli_connect_error() . "\n";
      }

      print "everything ok\n";

    } catch (\PDOException $e) {
      // exit($e->getMessage());

      print "Oh fuck" . " " . $e->getMessage() . " " . $e->getTraceAsString() . "\n";
    }
  }

  public function connet()
  {
    return $this->dbConnection;
  }
}
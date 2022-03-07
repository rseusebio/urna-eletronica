<?php
namespace Src;

class Vote {
  private $db;
  private $requestMethod;
  private $vereadorId;
  private $prefeitoId;

  public function __construct($db, $requestMethod, $vereadorId, $prefeitoId)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->vereadorId = $vereadorId;
    $this->prefeitoId = $prefeitoId;
  }

  public function processRequest()
  {
    switch ($this->requestMethod) {
      case 'GET':
        $response = $this->getAllVotes();
        break;
      case 'POST':
        $response = $this->postHandler($this->vereadorId, $this->prefeitoId);
        break;
      case 'DELETE':
        $response = $this->resetAll();
        break;
      default:
        $response = $this->notFoundResponse();
        break;
    }

    header($response['status_code_header']);

    if ($response['body']) {
      echo $response['body'];
    }
  }

  private function getTest()
  {
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    
    $age = array("Peter"=>35, "Ben"=>37, "Joe"=>43);

    $response['body'] = json_encode($age);

    return $response;
  }

  private function getAllVotes()
  {
    $query = "SELECT * FROM Politicos;";

    try {
      $statement = $this->db->query($query);
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function getPolitician($id) 
  {
    $query = "SELECT * FROM Politicos WHERE ID = :id;";

    $stmt = $this->db->prepare($query);
    $stmt->execute(array('id' => (int) $id));

    $politician = $stmt->fetch();

    return $politician;
  }

  private function updateVote($id, $vote) 
  {
    $update = "UPDATE Politicos SET Votos = :vote WHERE ID = :id;";

    $stmt = $this->db->prepare($update);

    $stmt->execute(array( 'vote' => $vote , 'id' => $id));

    return $stmt->rowCount();
  }

  private function insertVote($id)
  {
    $politician = $this->getPolitician($id);

    if (!$politician) 
    {
      return array("message" => "Couldn't find a politician with ID " . $id, "success" => false );
    }

    $vote = 1 + (int) $politician['Votos'];

    $rows = $this->updateVote($id, $vote);

    $new_pol = $this->cleanObject($this->getPolitician($id));

    return array("politician" => $new_pol, "success"=> true);
  }

  public function postHandler($vereador_id, $prefeito_id) 
  {
      $result = array(
        "vereador" => $this->insertVote($vereador_id),
        "prefeito" => $this->insertVote($prefeito_id)
      );

      $response['status_code_header'] = 'HTTP/1.1 200 OK';
      $response['body'] = json_encode($result);

      return $response;
  }

  private function cleanObject($obj)
  {
    unset($obj["0"]);
    unset($obj["1"]);
    unset($obj["2"]);
    unset($obj["3"]);
    unset($obj["4"]);
    unset($obj["5"]);
    unset($obj["6"]);

    return $obj;
  }

  private function resetAll() 
  {
    $update = "UPDATE Politicos SET Votos=0 WHERE ID <> -999;";

    $stmt = $this->db->prepare($update);

    $stmt->execute();

    $result = array("resetRows" => $stmt->rowCount());

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);

    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}
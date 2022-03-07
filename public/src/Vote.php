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

  private function getAllVotes()
  {
    $query = "SELECT * FROM Politicos WHERE Titulo = 'prefeito';";
    $statement = $this->db->query($query);
    $prefeitos = $statement->fetchAll(\PDO::FETCH_ASSOC);

    $query = "SELECT * FROM Politicos WHERE Titulo  ='vereador';";
    $statement = $this->db->query($query);
    $vereadores = $statement->fetchAll(\PDO::FETCH_ASSOC);

    $result = array(
      "prefeitos" => $prefeitos,
      "vereadores" => $vereadores
    );

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);

    return $response;
  }

  private function getPolitician($id, $title) 
  {
    $query = "SELECT * FROM Politicos WHERE ID = :id AND Titulo = :titulo;";

    $stmt = $this->db->prepare($query);
    $stmt->execute(array('id' => (int) $id, 'titulo' => $title));

    $politician = $stmt->fetch();

    return $politician;
  }

  private function updateVote($id, $vote, $title) 
  {
    $update = "UPDATE Politicos SET Votos = :vote WHERE ID = :id and Titulo = :titulo;";

    $stmt = $this->db->prepare($update);

    $stmt->execute(array( 'vote' => $vote , 'id' => $id, 'titulo' => $title));

    return $stmt->rowCount();
  }

  private function insertVote($id, $title)
 {
    $politician = $this->getPolitician($id, $title);

    if (!$politician) {
      return array("message" => "Couldn't find a politician with ID " . $id, "success" => false );
    }

    $vote = 1 + (int) $politician['Votos'];

    $rows = $this->updateVote($id, $vote, $title);

    return array(
      "politician" => $this->cleanObject($this->getPolitician($id, $title)),
      "rowsUpdated" => $rows, 
      "success"=> true
    );
  }

  public function postHandler($vereador_id, $prefeito_id) 
  {
      $result = array(
        "vereador" => $this->insertVote($vereador_id, "vereador"),
        "prefeito" => $this->insertVote($prefeito_id, "prefeito")
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
<?php
namespace Src;

class Post {
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
      case 'PUT':
        $response = $this->updatePost($this->vereadorId);
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














  private function getPost($id)
  {
    $result = $this->find($id);
    if (! $result) {
      return $this->notFoundResponse();
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode([1, 2, 3]);
    return $response;
  }

  private function createPost()
  {
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    if (! $this->validatePost($input)) {
      return $this->unprocessableEntityResponse();
    }

    $query = "
      INSERT INTO post
        (title, body, author, author_picture)
      VALUES
        (:title, :body, :author, :author_picture);
    ";

    try {
      $statement = $this->db->prepare($query);
      $statement->execute(array(
        'title' => $input['title'],
        'body'  => $input['body'],
        'author' => $input['author'],
        'author_picture' => 'https://secure.gravatar.com/avatar/'.md5(strtolower($input['author'])).'.png?s=200',
      ));
      $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }

    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $response['body'] = json_encode(array('message' => 'Post Created'));
    return $response;
  }

  private function updatePost($id)
  {
    $result = $this->find($id);

    if (! $result) {
      return $this->notFoundResponse();
    }

    $input = (array) json_decode(file_get_contents('php://input'), TRUE);

    if (! $this->validatePost($input)) {
      return $this->unprocessableEntityResponse();
    }

    $statement = "
      UPDATE post
      SET
        title = :title,
        body  = :body,
        author = :author,
        author_picture = :author_picture
      WHERE id = :id;
    ";

    try {
      $statement = $this->db->prepare($statement);
      $statement->execute(array(
        'id' => (int) $id,
        'title' => $input['title'],
        'body'  => $input['body'],
        'author' => $input['author'],
        'author_picture' => 'https://secure.gravatar.com/avatar/'.md5($input['author']).'.png?s=200',
      ));
      $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Post Updated!'));
    return $response;
  }

  private function deletePost($id)
  {
    $result = $this->find($id);

    if (! $result) {
      return $this->notFoundResponse();
    }

    $query = "
      DELETE FROM post
      WHERE id = :id;
    ";

    try {
      $statement = $this->db->prepare($query);
      $statement->execute(array('id' => $id));
      $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Post Deleted!'));
    return $response;
  }

  public function find($id)
  {
    $query = "
      SELECT
        id, title, body, author, author_picture, created_at
      FROM
        post
      WHERE id = :id;
    ";

    try {
      $statement = $this->db->prepare($query);
      $statement->execute(array('id' => $id));
      $result = $statement->fetch(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }

  private function validatePost($input)
  {
    if (! isset($input['title'])) {
      return false;
    }
    if (! isset($input['body'])) {
      return false;
    }

    return true;
  }

  private function unprocessableEntityResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = json_encode([
      'error' => 'Invalid input'
    ]);
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}
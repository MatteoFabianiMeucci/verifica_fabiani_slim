<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DocentiController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $result = $mysqli_connection->query("SELECT * FROM scuole WHERE id = " . $args['scuola_id']. "");
    if($result->num_rows == 0){
      $msg = ["msg" => "scuola inesistente"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(404);
    }

    $result = $mysqli_connection->query("SELECT * FROM docenti where scuola_id = " .$args['scuola_id'] );
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $result = $mysqli_connection->query("SELECT * FROM scuole WHERE id = " . $args['scuola_id']. "");
    if($result->num_rows == 0){
      $msg = ["msg" => "scuola inesistente"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(404);
    }

    $results = $mysqli_connection->query("SELECT * FROM docenti WHERE id = " . $args['id']. " AND scuola_id = " . $args['scuola_id']. " ");
    $results = $results->fetch_all(MYSQLI_ASSOC);
    if(count(($results)) > 0){
      $response->getBody()->write(json_encode($results));
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
    $msg = ["msg" => "docente inesistente"];
    $response->getBody()->write(json_encode($msg));
    return $response->withStatus(404);
  }

  public function create(Request $request, Response $response, $args){
    $body = json_decode($request->getbody()->getContents(), true);
    $scuola_id = $args["scuola_id"];
    $nome = $body["nome"];
    $cognome = $body["cognome"];

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    if($mysqli_connection->query("INSERT INTO docenti (nome, cognome, scuola_id) VALUES ('$nome', '$cognome','$scuola_id')")){
      $msg = ["msg" => "Created"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(201);
    }
    $msg = ["msg" => "Impossibile creare la risorsa"];
    $response->getBody()->write(json_encode($msg));
    return $response->withStatus(500);
  }

  public function update(Request $request, Response $response, $args){
    $body = json_decode($request->getbody()->getContents(), true);
    $scuola_id = $args["scuola_id"];
    $docente_id = $args["docente_id"];
    $nome = $body["nome"];
    $cognome = $body["cognome"];

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $result = $mysqli_connection->query("SELECT * FROM scuole WHERE id = " . $args['scuola_id']. "");
    if($result->num_rows == 0){
      $msg = ["msg" => "scuola inesistente"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(404);
    }

    $result = $mysqli_connection->query("SELECT * FROM docenti WHERE id = " . $args['docente_id']. "");
    if($result->num_rows == 0){
      $msg = ["msg" => "docente inesistente"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(404);
    }

    if($mysqli_connection->query("UPDATE docenti SET nome = '$nome', cognome = '$cognome' WHERE id = '$docente_id' AND scuola_id = '$scuola_id'")){
      $msg = ["msg" => "Updated"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(200);
    }
    $msg = ["msg" => "Impossibile aggiornare la risorsa"];
    $response->getBody()->write(json_encode($msg));
    return $response->withStatus(500);
  }

  public function destroy(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $result = $mysqli_connection->query("SELECT * FROM docenti WHERE id = " . $args['id']. "");
    if($result->num_rows == 0){
      $msg = ["msg" => "docente inesistente"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(404);
    }

    if($mysqli_connection->query("DELETE FROM docenti WHERE id = " . $args['id']. "")){
      $msg = ["msg" => "Deleted"];
      $response->getBody()->write(json_encode($msg));
      return $response->withStatus(200);
    }
    $msg = ["msg" => "Impossibile cancellare la risorsa"];
    $response->getBody()->write(json_encode($msg));
    return $response->withHeader("Content-length", "0")->withStatus(500);
  }

}

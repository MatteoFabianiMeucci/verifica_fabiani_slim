<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class ScuoleController{
    public function index(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $results = $mysqli_connection->query("SELECT * FROM scuole");
        $results = $results->fetch_all(MYSQLI_ASSOC);
        $response->getBody()->write(json_encode($results));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
      }

      public function show(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $result = $mysqli_connection->query("SELECT * FROM scuole WHERE id = " . $args['id']. "");
        if($result->num_rows > 0){
            $results = $result->fetch_all(MYSQLI_ASSOC);
            $response->getBody()->write(json_encode($results));
            return $response->withHeader("Content-type", "application/json")->withStatus(200);
        }
        $msg = ["msg" => "scuola inesistente"];
        $response->getBody()->write(json_encode($msg));
        return $response->withStatus(404);
      }

      public function create(Request $request, Response $response, $args){
        $body = json_decode($request->getbody()->getContents(), true);
        $nome = $body["nome"];
        $indirizzo = $body["indirizzo"];
    
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        if($mysqli_connection->query("INSERT INTO scuole (nome, indirizzo) VALUES ('$nome', '$indirizzo')")){
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
        $nome = $body["nome"];
        $indirizzo = $body["indirizzo"];
    
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

        $result = $mysqli_connection->query("SELECT * FROM scuole WHERE id = " . $args['id']. "");
        if($result->num_rows == 0){
            $msg = ["msg" => "scuola inesistente"];
            $response->getBody()->write(json_encode($msg));
            return $response->withStatus(404);
        }

        if($mysqli_connection->query("UPDATE scuole SET nome = '$nome', indirizzo = '$indirizzo' WHERE id = " . $args['id']. "")){
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

        $result = $mysqli_connection->query("SELECT * FROM scuole WHERE id = " . $args['id']. "");
        if($result->num_rows == 0){
            $msg = ["msg" => "scuola inesistente"];
            $response->getBody()->write(json_encode($msg));
            return $response->withStatus(404);
        }

        if($mysqli_connection->query("DELETE FROM scuole WHERE id = " . $args['id']. "")){
            $msg = ["msg" => "Deleted"];
            $response->getBody()->write(json_encode($msg));
          return $response->withHeader("Content-Length", "0")->withStatus(200);
        }
        $msg = ["msg" => "Impossibile cancellare la risorsa"];
        $response->getBody()->write(json_encode($msg));
        return $response->withHeader("Content-length", "0")->withStatus(500);
      }
}
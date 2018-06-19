<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Access-Control-Allow-Methods, Content-Type");
header("Access-Control-Allow-Methods: HEADERS, PUT, POST, GET, OPTIONS, DELETE");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;




require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});
// Get All Football Players
 $app->get('/football', function(Request $request, Response $response) {
    $sql = "SELECT * FROM roster ORDER BY id ASC";
    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $players = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($players);
    } catch(PDOException $e) {
        echo '{"error"; {"text": '.$e->getMessage().'}';
    }
});

//get one player
$app->get('/football/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "SELECT *  FROM roster WHERE ID = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $player = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($player);
    } catch(PDOException $e) {
        echo '{"error"; {"text": '.$e->getMessage().'}';
    }
});

//Add player
$app->post('/football/add', function(Request $request, Response $response) {
    $playerName = $request->getParam('playername');
    $team = $request->getParam('team');
    $jerseyNumber = $request->getParam('jerseynumber');
    $position = $request->getParam('position');
    
    $sql = "INSERT INTO roster (playername, team, jerseynumber, position) VALUES 
    (:playername,:team,:jerseynumber,:position)";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':playername', $playerName);
        $stmt->bindParam(':team', $team);
        $stmt->bindParam(':jerseynumber', $jerseyNumber);
        $stmt->bindParam(':position', $position);
        
        $stmt->execute();
        echo '{"notice": {"text": "player added"}}';
    
    } catch(PDOException $e) {
        echo '{"error"; {"text": '.$e->getMessage().'}';
    }
});

//Update player
$app->put('/football/update/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $playerName = $request->getParam('playername');
    $team = $request->getParam('team');
    $jerseyNumber = $request->getParam('jerseynumber');
    $position = $request->getParam('position');
    $sql = "UPDATE roster SET playername = :playername, 
                                    team = :team,
                            jerseynumber = :jerseynumber,
                                position = :position
                            WHERE id = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':playername', $playerName);
        $stmt->bindParam(':team', $team);
        $stmt->bindParam(':jerseynumber', $jerseyNumber);
        $stmt->bindParam(':position', $position);

        $stmt->execute();
        echo '{"notice": {"text": "player updated"}}';
    
    } catch(PDOException $e) {
        echo '{"error"; {"text": '.$e->getMessage().'}';
    }
});

//Delete Customer
$app->delete('/football/delete/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM roster WHERE ID = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $player = $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "player deleted"}}';
    } catch(PDOException $e) {
        echo '{"error"; {"text": '.$e->getMessage().'}';
    }
}); 


$app->run();
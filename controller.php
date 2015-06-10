<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
use Slim\Slim;

$app = new Slim(array('debug' => true));

$app->get('/equipments', 'readEquipments');
$app->get('/equipments/:id', 'readEquipment');
$app->post('/equipments', 'createEquipment');
$app->put('/equipments/:id', 'updateEquipment');
$app->delete('/equipments/:id', 'deleteEquipment');

$app->get('/peoples', 'readPeople');
$app->get('/peoples/:id', 'readPerson');
$app->post('/peoples', 'createPerson');
$app->put('/peoples/:id', 'updatePerson');
$app->delete('/peoples/:id', 'deletePerson');




$app->run();

$mongoHost = 'localhost';

function readEquipments() {
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->equipments;
        $cursor = $collection->find();
        $equipments = [];
        foreach ($cursor as $obj) {
            array_push($equipments, $obj);
        }
        echo json_encode($equipments);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}

function readEquipment($id) {
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->equipments;
        $equipment = $collection->findOne(array('_id' => new MongoId($id)));
        echo json_encode($equipment);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}
function readPeople() {
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->Peoples;
        $cursor = $collection->find();
        $peoples = [];
        foreach ($cursor as $obj) {
            array_push($peoples, $obj);
        }
        echo json_encode($peoples);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}

function readPerson($id) {
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->Peoples;
        $person = $collection->findOne(array('_id' => new MongoId($id)));
        echo json_encode($person);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}

function createEquipment() {
    $request = Slim::getInstance()->request();
    $equipment = json_decode($request->getBody());
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->equipments;
        $collection->insert($equipment);
        echo json_encode($equipment);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}
function createPerson() {
    $request = Slim::getInstance()->request();
    $person = json_decode($request->getBody());
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->Peoples;
        try {
          $collection->insert($person);
        } catch (MongoDuplicateKeyException $e){
                  
          echo header("HTTP/1.1 500 Internal Server Error"), $e->getMessage(), "\n";
        }
        
        echo json_encode($person);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}

function updateEquipment($id) {
    $request = Slim::getInstance()->request();
    $equipment = json_decode($request->getBody());
    $equipment->_id = new MongoId($id);
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->equipments;
        $collection->save($equipment);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}

function updatePerson($id) {
    $request = Slim::getInstance()->request();
    $equipment = json_decode($request->getBody());
    $equipment->_id = new MongoId($id);
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->Peoples;
        $collection->save($equipment);
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}
function deleteEquipment($id) {
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->equipments;
        $collection->remove(array('_id' => new MongoId($id)));
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}

function deletePerson($id) {
    try {
        global $mongoHost;
        $connection = new MongoClient($mongoHost);
        $db = $connection->Equipments;
        $collection = $db->Peoples;
        $collection->remove(array('_id' => new MongoId($id)));
        $connection->close();
    }
    catch ( MongoConnectionException $e )
    {
        echo $e->getMessage();
    }
    catch ( MongoException $e )
    {
        echo $e->getMessage();
    }
}

?>
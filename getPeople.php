<?php
$mongoHost = "localhost";
try {
    $connection = new Mongo($mongoHost);
    $db = $connection->Equipments;
    $collection = $db->Peoples;
    $collection->ensureIndex(array('name' => 1), array('unique' => true, 'dropDups' => 1));
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

?>
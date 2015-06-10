<?php
$mongoHost = "localhost";
try {
    $connection = new Mongo($mongoHost);
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

?>
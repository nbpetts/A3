<?php
$body = file_get_contents("php://input");
file_put_contents("backboneEquipAndPeople.json", $body);
?>
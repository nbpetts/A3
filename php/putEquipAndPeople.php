<?php
$data = isset($_GET['data']) ? $_GET['data'] : $_POST['data'];
$data = str_replace('\\"', '"', $data);
$count = file_put_contents("../equipAndPeople.json", $data);
?>

/*<?php
/*
$returnData = array();

if (isset($_POST["city"])) {

    include("db-conn.php");

    $returnData["id"] = $_POST["city"];

    $statement = $pdo->prepare("SELECT * FROM places WHERE city_id = :id");
    $statement->execute(["id" => $_POST["city"]]);
    $places = $statement->fetchAll();

    $returnData["places"] = $places;

} else {
    $returnData["error"] = "No City Selected!";
}

echo json_encode($returnData);
*/
?>

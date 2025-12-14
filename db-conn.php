<?php
// set my database information
$host = "localhost";   // server name
$user = "root";        // database username
$pass = "";        // database password
$db   = "comp2002";    // database name

// make the connection string for MySQL using PDO
$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

try {
    // connect to the database using PDO
    $pdo = new PDO($dsn, $user, $pass);

    // show error messages if something goes wrong
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connected to database"; // use only for testing

} catch (PDOException $error) {
    // show error message if connection fails
    echo "Connection failed: " . $error->getMessage();
}
?>

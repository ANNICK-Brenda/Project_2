<?php
include("db.php");

if (!isset($_POST["place_id"])) {
    echo "No booking selected";
    exit;
}

$placeId = $_POST["place_id"];
$checkIn = $_POST["check_in"];
$checkOut = $_POST["check_out"];

/* Get place info */
$statement = $pdo->prepare("SELECT * FROM places WHERE id = :id");
$statement->execute([
    "id" => $placeId
]);
$place = $statement->fetch();

/* Get owner info */
$statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$statement->execute([
    "id" => $place["user_id"]
]);
$user = $statement->fetch();

/* Calculate nights */
$start = new DateTime($checkIn);
$end = new DateTime($checkOut);
$nights = $start->diff($end)->days;

include("./templates/header.php");
?>

<h2>Your Booking Details</h2>

<p>Check In Date: <?php echo $checkIn; ?></p>
<p>Check Out Date: <?php echo $checkOut; ?></p>
<p>Nights: <?php echo $nights; ?></p>
<p>User: <?php echo $user["name"]; ?></p>

<form action="confirm.php" method="post">
    <input type="submit" value="Confirm">
</form>

<br>

<a href="index.php">Back to Home</a>

<?php include("./templates/footer.php"); ?>

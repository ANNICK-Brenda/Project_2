<?php
include("db-conn.php");

/* Make sure a place was selected */
if (!isset($_POST["place_id"])) {
    header("Location: index.php");
    exit;
}

$place_id = $_POST["place_id"];
$check_in = $_POST["check_in"];
$check_out = $_POST["check_out"];

/* Get place info */
$statement = $pdo->prepare("SELECT * FROM places WHERE id = :id");
$statement->execute([
    "id" => $place_id
]);
$place = $statement->fetch();

/* Get owner info */
$statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$statement->execute([
    "id" => $place["user_id"]
]);
$user = $statement->fetch();

/* Calculate nights */
$start = new DateTime($check_in);
$end = new DateTime($check_out);
$nights = $start->diff($end)->days;

include("./templates/header.php");
?>

<div class="container">

<h2>Your Booking Details</h2>

<p>Check In Date: <?php echo $check_in; ?></p>
<p>Check Out Date: <?php echo $check_out; ?></p>
<p>Nights: <?php echo $nights; ?></p>

<p>
Owner:
<?php echo $user["first_name"] . " " . $user["last_name"]; ?>
</p>

<!-- Back to home -->
<form action="index.php" method="get">
    <input type="submit" value="Back to Home">
</form>

<!-- Confirm booking -->
<form action="confirm.php" method="post">
    <input type="submit" value="Confirm">
</form>

</div>

<?php include("./templates/footer.php"); ?>

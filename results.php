<?php
include("db-conn.php");

/* If state is missing, go back home */
if (!isset($_POST["state"])) {
    header("Location: index.php");
    exit;
}

/* Get state */
$statement = $pdo->prepare("SELECT * FROM states WHERE id = :id");
$statement->execute([
    "id" => $_POST["state"]
]);
$state = $statement->fetch();

/* Get cities for this state */
$statement = $pdo->prepare("SELECT * FROM cities WHERE state_id = :id");
$statement->execute([
    "id" => $_POST["state"]
]);
$cities = $statement->fetchAll();

/* Get values from previous page */
$check_in  = $_POST["check_in"]  ?? "";
$check_out = $_POST["check_out"] ?? "";

/* Get search values (defaults) */
$city_id       = $_POST["city"] ?? null;
$number_rooms  = $_POST["number_rooms"] ?? 1;
$number_guests = $_POST["number_guests"] ?? 1;

include("./templates/header.php");
?>

<div class="container">

<h2>Results for <?php echo $state["name"]; ?></h2>

<!-- Change state or dates -->
<form action="index.php" method="get">
    <input type="submit" value="<< Change State or Dates">
</form>

<!-- Search form -->
<form action="results.php" method="post">

    <input type="hidden" name="state" value="<?php echo $_POST["state"]; ?>">
    <input type="hidden" name="check_in" value="<?php echo $check_in; ?>">
    <input type="hidden" name="check_out" value="<?php echo $check_out; ?>">

    <label for="city">City</label>
    <select name="city" id="city">
        <?php
        foreach ($cities as $city) {
            $selected = ($city_id == $city["id"]) ? "selected" : "";
            echo "<option value='".$city["id"]."' $selected>".$city["name"]."</option>";
        }
        ?>
    </select>

    <label for="number_rooms">Number of rooms</label>
    <input
        type="number"
        name="number_rooms"
        id="number_rooms"
        value="<?php echo $number_rooms; ?>"
        min="1"
    >

    <label for="number_guests">Number of guests</label>
    <input
        type="number"
        name="number_guests"
        id="number_guests"
        value="<?php echo $number_guests; ?>"
        min="1"
    >

    <input type="submit" value="Search">
</form>

<?php
/* Show listings only after search */
if ($city_id !== null) {

    $statement = $pdo->prepare(
        "SELECT * FROM places
         WHERE city_id = :city
         AND number_rooms >= :rooms"
    );

    $statement->execute([
        "city"  => $city_id,
        "rooms" => $number_rooms
    ]);

    $places = $statement->fetchAll();

    if (count($places) == 0) {
        echo "<p>no results</p>";
    } else {
        foreach ($places as $place) {
            ?>
            <p><?php echo $place["name"]; ?></p>

            <form action="book.php" method="post">
                <input type="hidden" name="place_id" value="<?php echo $place["id"]; ?>">
                <input type="hidden" name="check_in" value="<?php echo $check_in; ?>">
                <input type="hidden" name="check_out" value="<?php echo $check_out; ?>">
                <input type="submit" value="Book">
            </form>
            <?php
        }
    }
}
?>

</div>

<?php include("./templates/footer.php"); ?>

<?php
require_once "db-conn.php";

/* Get all states from database */
$sql = "SELECT id, name FROM states";
$statement = $pdo->prepare($sql);
$statement->execute();
$states = $statement->fetchAll();
?>

<?php include "./templates/header.php"; ?>

<h1>Bookings.com</h1>

<form action="result.php" method="post">

    <label for="state">State:</label>
    <select name="state" id="state" required>
        <?php
        foreach ($states as $state) {
            echo "<option value='" . $state['id'] . "'>" . $state['name'] . "</option>";
        }
        ?>
    </select>

    <br><br>

    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>

    <br><br>

    <label for="time">Time:</label>
    <input type="time" name="time" id="time">

    <br><br>

    <label for="rooms">Number of rooms:</label>
    <input type="number" name="rooms" id="rooms" min="1" value="1">

    <br><br>

    <label for="guests">Number of guests:</label>
    <input type="number" name="guests" id="guests" min="1" value="1">

    <br><br>

    <button type="submit">Search</button>

</form>

<?php include "./templates/footer.php"; ?>

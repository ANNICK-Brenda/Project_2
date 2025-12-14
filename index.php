<?php
include "db-conn.php";

$statement = $pdo->prepare("SELECT * FROM states");
$statement->execute();
$states = $statement->fetchAll();

/* Get today's date for date validation */
$today = date("Y-m-d");
?>

<?php include "./templates/header.php"; ?>

<h1>Booking</h1>

<form action="results.php" method="post">

    <label for="state">State</label>
    <select name="state" id="state">
        <?php
        foreach ($states as $state) {
            echo "<option value='".$state["id"]."'>".$state["name"]."</option>";
        }
        ?>
    </select>

    <label for="check_in">Check In Date</label>
    <input 
        type="date" 
        name="check_in" 
        id="check_in"
        min="<?php echo $today; ?>"
        required
    >

    <label for="check_out">Check Out Date</label>
    <input 
        type="date" 
        name="check_out" 
        id="check_out"
        required
    >

    <input type="submit" value="Search">

</form>

<script>
const checkIn = document.getElementById("check_in");
const checkOut = document.getElementById("check_out");

checkIn.addEventListener("change", () => {
    checkOut.min = checkIn.value;
});
</script>

<?php include "./templates/footer.php"; ?>

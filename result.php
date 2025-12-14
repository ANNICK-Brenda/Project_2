<?php
require_once "db-conn.php";

if (!isset($_POST["state"])) {
    echo "Invalid state";
    exit;
}

/* Get selected state */
$statement = $pdo->prepare("SELECT * FROM states WHERE id = :id");
$statement->execute([
    "id" => $_POST["state"]
]);
$state = $statement->fetch();

if (!$state) {
    echo "State not found";
    exit;
}

/* Get cities for that state */
$statement = $pdo->prepare("SELECT * FROM cities WHERE state_id = :id");
$statement->execute([
    "id" => $_POST["state"]
]);
$cities = $statement->fetchAll();

include("./templates/header.php");
?>

<h2>Results for <?php echo $state["name"]; ?></h2>

<form action="submitted.php" method="post" id="cityForm">

    <!-- KEEP the selected state -->
    <input type="hidden" name="state" value="<?php echo $_POST['state']; ?>">

    <label for="city">City:</label>
    <select name="city" id="city">
        <?php
        foreach ($cities as $city) {
            echo "<option value='" . $city["id"] . "'>" . $city["name"] . "</option>";
        }
        ?>
    </select>

    <br><br>

    <input type="submit" value="Search" id="submit">

</form>

<div id="responseContainer"></div>

<script>
const responseContainer = document.querySelector("#responseContainer");
const submitButton = document.querySelector("#submit");

submitButton.addEventListener("click", function (e) {
    e.preventDefault();

    fetch("submitted.php", {
        method: "POST",
        body: new FormData(document.querySelector("#cityForm"))
    })
    .then(response => response.json())
    .then(data => {
        responseContainer.innerHTML = JSON.stringify(data);
    });
});
</script>

<?php include("./templates/footer.php"); ?>

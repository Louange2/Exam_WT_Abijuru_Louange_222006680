<?php
include('database_connection.php');

// Check if favorite_id is set
if(isset($_REQUEST['favorite_id'])) {
    $fid = $_REQUEST['favorite_id'];
    
    $stmt = $connection->prepare("SELECT * FROM favorites WHERE favorite_id=?");
    $stmt->bind_param("i", $fid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['favorite_id'];
        $u = $row['id'];
        $y = $row['artwork_id'];
    } else {
        echo "favorites not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in favorites</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update favorites form -->
    <h2><u>Update Form of favorites</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="uid">id:</label>
        <input type="number" name="uid" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="arid">artwork_id:</label>
        <input type="text" name="arid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>


        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $id = $_POST['uid'];
    $artwork_id = $_POST['arid'];
    
    // Update the favorites in the database
    $stmt = $connection->prepare("UPDATE favorites SET id=?, artwork_id=? WHERE favorite_id=?");
    $stmt->bind_param("ssd", $id, $artwork_id,, $fid);
    $stmt->execute();
    
    // Redirect to favorites.php
    header('Location: favorites.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

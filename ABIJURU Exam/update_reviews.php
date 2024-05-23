<?php
include('database_connection.php');

// Check if review_id is set
if(isset($_REQUEST['review_id'])) {
    $rid = $_REQUEST['review_id'];
    
    $stmt = $connection->prepare("SELECT * FROM reviews WHERE review_id=?");
    $stmt->bind_param("i", $rid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['review_id'];
        $u = $row['id'];
        $y = $row['artwork_id'];
        $z = $row['rating'];
    } else {
        echo "reviews not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in reviews</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update reviews form -->
    <h2><u>Update Form of reviews</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="uid">id:</label>
        <input type="number" name="uid" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="arid">artwork_id:</label>
        <input type="text" name="arid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="rt">rating:</label>
        <input type="text" name="rt" value="<?php echo isset($z) ? $z : ''; ?>">
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
    $rating = $_POST['rt'];
    
    // Update the reviews in the database
    $stmt = $connection->prepare("UPDATE reviews SET id=?, artwork_id=?, rating=? WHERE review_id=?");
    $stmt->bind_param("isss", $id, $artwork_id, $rating, $rid);
    $stmt->execute();
    
    // Redirect to reviews.php
    header('Location: reviews.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

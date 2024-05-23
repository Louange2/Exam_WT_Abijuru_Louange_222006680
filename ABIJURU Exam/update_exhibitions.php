<?php
include('database_connection.php');

// Check if exhibition_id is set
if(isset($_REQUEST['exhibition_id'])) {
    $cid = $_REQUEST['exhibition_id'];
    
    $stmt = $connection->prepare("SELECT * FROM exhibitions WHERE exhibition_id=?");
    $stmt->bind_param("i", $cid);  // Corrected to use $cid
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['exhibition_id'];
        $u = $row['exhibition_name'];
        $y = $row['location'];
        $z = $row['gallery_id'];
        
    } else {
        echo "Exhibition not found.";
    }
    $stmt->close();  // Close the statement
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in exhibitions</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update exhibitions form -->
    <h2><u>Update Form of exhibitions</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="enm">exhibition_name:</label>
        <input type="text" name="enm" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="loc">location:</label>
        <input type="text" name="loc" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="gid">gallery_id:</label>
        <input type="text" name="gid" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $exhibition_name = $_POST['enm'];
    $location = $_POST['loc'];
    $gallery_id = $_POST['gid'];
    
    // Update the exhibitions in the database
    $stmt = $connection->prepare("UPDATE exhibitions SET exhibition_name=?, location=?, gallery_id=? WHERE exhibition_id=?");
    $stmt->bind_param("sssi", $exhibition_name, $location, $gallery_id, $cid);  // Corrected to use $cid and "sssi"
    $stmt->execute();
    $stmt->close();  // Close the statement
    
    // Redirect to exhibitions.php
    header('Location: exhibitions.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

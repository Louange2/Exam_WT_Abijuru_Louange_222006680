<?php
include('database_connection.php');

// Check if artist_Id is set
if(isset($_REQUEST['artist_id'])) {
    $aid = $_REQUEST['artist_id'];
    
    $stmt = $connection->prepare("SELECT * FROM artists WHERE artist_id=?");
    $stmt->bind_param("i", $aid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['artist_id'];
        $u = $row['id'];
        $y = $row['biography'];
        $z = $row['social_media'];
    } else {
        echo "artist not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update new record in artists</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update accounts form -->
    <h2><u>Update Form of artists</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
         <label for="uid">id:</label>
        <input type="text" name="uid" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="bio">biography:</label>
        <input type="text" name="bio" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="sm">social_media:</label>
        <input type="text" name="sm" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $id = $_POST['uid'];
    $biography = $_POST['bio'];
    $social_media = $_POST['sm'];
    
    // Update the product in the database
    $stmt = $connection->prepare("UPDATE artists SET id=?, biography=?, social_media=? WHERE artist_id=?");
    $stmt->bind_param("ssdi", $id, $biography, $social_media, $aid);
    $stmt->execute();
    
    // Redirect to artists.php
    header('Location: artist.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

<?php
include('database_connection.php');

// Check if artwork_id is set
if(isset($_REQUEST['artwork_id'])) {
    $cid = $_REQUEST['artwork_id'];
    
    $stmt = $connection->prepare("SELECT * FROM artworks WHERE artwork_id=?");
    $stmt->bind_param("i", $arid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['artwork_id'];
        $u = $row['artist_id'];
        $y = $row['price'];
        $z = $row['category_id'];
    } else {
        echo "artworks not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in artworks</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update artworks form -->
    <h2><u>Update Form of artworks</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="aid">artist_id:</label>
        <input type="number" name="aid" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="pr">price:</label>
        <input type="number" name="pr" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for=cid>category_id:</label>
        <input type="number" name="cid" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $artist_id = $_POST['aid'];
    $price = $_POST['pr'];
    $category_id = $_POST['cid'];
    
    // Update the artworks in the database
    $stmt = $connection->prepare("UPDATE artworks SET artist_id=?, price=?, category_id=? WHERE artwork_id=?");
    $stmt->bind_param("issi", $artist_id, $price, $category_id, $arid);
    $stmt->execute();
    
    // Redirect to artworks.php
    header('Location: artworks.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

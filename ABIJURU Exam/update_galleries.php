<?php
include('database_connection.php');

// Check if gallery_id is set
if(isset($_REQUEST['gallery_id'])) {
    $gid = $_REQUEST['gallery_id'];
    
    $stmt = $connection->prepare("SELECT * FROM galleries WHERE gallery_id=?");
    $stmt->bind_param("i", $gid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['gallery_id'];
        $u = $row['gallery_name'];
        $y = $row['location'];
        $n = $row['contact_info'];
    } else {
        echo "gallery not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in galleries</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update galleries form -->
    <h2><u>Update Form of galleries</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="gname">gallery_name:</label>
        <input type="text" name="gname" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="loc">location:</label>
        <input type="text" name="loc" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="ci">contact_info:</label>
        <input type="text" name="ci" value="<?php echo isset($n) ? $n : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $gallery_name = $_POST['gname'];
    $location = $_POST['loc'];
    $contact_info = $_POST['ci'];
    
    // Update the gallery in the database
    $stmt = $connection->prepare("UPDATE galleries SET gallery_name=?, location=?, contact_info=? WHERE gallery_id=?");
    $stmt->bind_param("sssd", $gallery_name, $location, $contact_info, $gid);
    $stmt->execute();
    
    // Redirect to galleries.php
    header('Location: galleries.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

<?php
include('database_connection.php');

// Check if category_id is set
if(isset($_REQUEST['category_id'])) {
    $cid = $_REQUEST['category_id'];
    
    $stmt = $connection->prepare("SELECT * FROM categories WHERE category_id=?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['category_id'];
        $u = $row['category_name'];
        $y = $row['description'];
    } else {
        echo "Category not found.";
    }
    $stmt->close();  // Close the statement
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in categories</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update categories form -->
    <h2><u>Update Form of categories</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="cname">category_name:</label>
        <input type="text" name="cname" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="des">description:</label>
        <input type="text" name="des" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $category_name = $_POST['cname'];
    $description = $_POST['des'];
    
    // Update the categories in the database
    $stmt = $connection->prepare("UPDATE categories SET category_name=?, description=? WHERE category_id=?");
    $stmt->bind_param("ssi", $category_name, $description, $cid);  // Corrected to use "ssi"
    $stmt->execute();
    $stmt->close();  // Close the statement
    
    // Redirect to categories.php
    header('Location: categories.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

<?php
include('database_connection.php');

// Check if shipping_id is set
if(isset($_REQUEST['shipping_id'])) {
    $sid = $_REQUEST['shipping_id'];
    
    $stmt = $connection->prepare("SELECT * FROM shipping WHERE shipping_id=?");
    $stmt->bind_param("i", $sid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['shipping_id'];
        $u = $row['order_id'];
        $y = $row['shipping_address'];
        $z = $row['shipped_date'];
    } else {
        echo "shipping not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in shipping</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update shipping form -->
    <h2><u>Update Form of shipping</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="oid">order_id:</label>
        <input type="number" name="oid" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="sad">shipping_address:</label>
        <input type="text" name="sad" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="sdt">shipped_date:</label>
        <input type="text" name="sdt" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $order_id = $_POST['oid'];
    $shipping_address = $_POST['sad'];
    $shipping_date = $_POST['sdt'];
    
    // Update the shipping in the database
    $stmt = $connection->prepare("UPDATE shipping SET order_id=?, shipping_address=?, shipped_date=? WHERE shipping_id=?");
    $stmt->bind_param("isss", $order_id, $shipping_address, $shipped_date, $sid);
    $stmt->execute();
    
    // Redirect to shipping.php
    header('Location: shipping.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

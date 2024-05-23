<?php
include('database_connection.php');

// Check if order_id is set
if(isset($_REQUEST['order_id'])) {
    $oid = $_REQUEST['order_id'];
    
    $stmt = $connection->prepare("SELECT * FROM orders WHERE order_id=?");
    $stmt->bind_param("i", $oid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['order_id'];
        $u = $row['id'];
        $y = $row['order_date'];
        $z = $row['amount'];
    } else {
        echo "orders not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in orders</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update orders form -->
    <h2><u>Update Form of orders</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="uid">id:</label>
        <input type="number" name="uid" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="odt">order_date:</label>
        <input type="text" name="odt" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for=mnt>amount:</label>
        <input type="text" name="mnt" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $id = $_POST['uid'];
    $order_date = $_POST['odt'];
    $amount = $_POST['mnt'];
    
    // Update the orders in the database
    $stmt = $connection->prepare("UPDATE orders SET id=?, order_date=?, amount=? WHERE order_id=?");
    $stmt->bind_param("isss", $id, $order_date, $amount, $oid);
    $stmt->execute();
    
    // Redirect to orders.php
    header('Location: orders.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>

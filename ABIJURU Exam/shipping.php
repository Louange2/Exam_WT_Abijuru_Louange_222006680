<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>shipping</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: yellow;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
      
    }
    header{
    background-color:skyblue;
}
    section{
    padding:71px;
    border-bottom: 1px solid #ddd;
    }
    footer{
    text-align: center;
    padding: 15px;
    background-color:skyblue;
    }

  </style>
  </head>

  <header>

<body bgcolor="skyblue">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./images/logo.png" width="90" height="60" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./Service.html">SERVICE</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./artists.php">ARTISTS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./artworks.php">ARTWORKS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./categories.php">CATEGORIES</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./exhibitions.php">EXHIBITIONS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./favorites.php">FAVORITES</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./galleries.php">GALLERIES</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./orders.php">ORDERS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./reviews.php">REVIEWS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./shipping.php">SHIPPING</a>
  </li>
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>

    <h1><u> shipping Form </u></h1>
    <form method="post" onsubmit="return confirmInsert();">
            
        <label for="sid">shipping_id:</label>
        <input type="number" id="sid" name="sid"><br><br>

        <label for="oid">order_id:</label>
        <input type="number" id="oid" name="oid"><br><br>

        <label for="sad">shipping_address:</label>
        <input type="text" id="sad" name="sad" required><br><br>

        <label for="sdt">shipped_date:</label>
        <input type="date" id="sdt" name="sdt" required><br><br>


        <input type="submit" name="add" value="Insert">
      

    </form>


<?php
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO shipping(shipping_id, order_id, shipping_address,shipped_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $sid, $oid, $sad, $sdt);
    // Set parameters and execute
    $sid = $_POST['sid'];
    $oid = $_POST['oid'];
    $sad = $_POST['sad'];
    $sdt = $_POST['sdt'];
   
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<?php
include('database_connection.php');

// SQL query to fetch data from the shipping table
$sql = "SELECT * FROM shipping";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of shipping</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of shipping</h2></center>
    <table border="5">
        <tr>
            <th>shipping_id</th>
            <th>order_id</th>
            <th>shipping_address</th>
            <th>shipped_date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
      include('database_connection.php');

        // Prepare SQL query to retrieve all shipping
        $sql = "SELECT * FROM shipping";
        $result = $connection->query($sql);

        // Check if there are any shipping
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $sid = $row['shipping_id']; // Fetch the shipping_id
                echo "<tr>
                    <td>" . $row['shipping_id'] . "</td>
                    <td>" . $row['order_id'] . "</td>
                    <td>" . $row['shipping_address'] . "</td>
                    <td>" . $row['shipped_date'] . "</td>
                    <td><a style='padding:4px' href='delete_shipping.php?shipping_id=$sid'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_shipping.php?shipping_id=$sid'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
</body>

    </section>


  
<footer>
  <center> 
    <marquee behavior='alternate'>
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by: @Louange ABIJURU</h2></b>
  </marquee>
  </center>
</footer>
</body>
</html>
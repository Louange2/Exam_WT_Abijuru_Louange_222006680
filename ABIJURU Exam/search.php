<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
include('database_connection.php');


    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'artists' => "SELECT biography FROM artists WHERE biography LIKE '%$searchTerm%'",
        'artworks' => "SELECT price FROM artworks WHERE price LIKE '%$searchTerm%'",
        'categories' => "SELECT description FROM categories WHERE description LIKE '%$searchTerm%'",
        'favorites' => "SELECT id FROM favorites WHERE id LIKE '%$searchTerm%'",
        'galleries' => "SELECT location FROM galleries WHERE location LIKE '%$searchTerm%'",
        'exhibions' => "SELECT location FROM exhibitions WHERE location LIKE '%$searchTerm%'",
        'orders' => "SELECT amount FROM orders WHERE amount LIKE '%$searchTerm%'",
        'reviews' => "SELECT rating FROM reviews WHERE rating LIKE '%$searchTerm%'",
        'shipping' => "SELECT shipped_date FROM shipping WHERE shipped_date LIKE '%$searchTerm%'"
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>

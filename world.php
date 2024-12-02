<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');

// Database connection details
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Establish database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get country from GET request, default to empty string if not set
$country = isset($_GET['country']) ? $_GET['country'] : '';

// Check if lookup is for cities
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : 'countries';

// Prepare the SQL query
try {
    if ($lookup === 'cities') {
        // Query for cities with JOIN
        $query = "SELECT cities.name, cities.district, cities.population 
                  FROM cities 
                  INNER JOIN countries ON cities.country_code = countries.code 
                  WHERE countries.name LIKE :country";
    } else {
        // Query for countries
        $query = "SELECT name, continent, independence_year, head_of_state 
                  FROM countries 
                  WHERE name LIKE :country";
    }

    // Prepare statement
    $stmt = $conn->prepare($query);

    // If no country specified, return all results
    if (empty($country)) {
        $stmt = $conn->prepare($lookup === 'cities' 
            ? "SELECT name, district, population FROM cities" 
            : "SELECT name, continent, independence_year, head_of_state FROM countries");
        $stmt->execute();
    } else {
        // Execute with country parameter
        $stmt->execute(['country' => "%$country%"]);
    }

    // Fetch results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<table>
    <?php if ($lookup === 'cities'): ?>
        <thead>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['district']); ?></td>
                <td><?= number_format($row['population']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php else: ?>
        <thead>
            <tr>
                <th>Name</th>
                <th>Continent</th>
                <th>Independence Year</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['continent']); ?></td>
                <td><?= $row['independence_year'] ?? 'N/A'; ?></td>
                <td><?= htmlspecialchars($row['head_of_state'] ?? 'N/A'); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>
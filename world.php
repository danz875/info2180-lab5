<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if a GET parameter 'country' or 'region' is set and use it to filter the query
$query = "SELECT * FROM countries";
$params = [];

if (!empty($_GET['country'])) {
    $query .= " WHERE name LIKE :country";
    $params[':country'] = "%" . $_GET['country'] . "%";
} elseif (!empty($_GET['region'])) {
    $query .= " WHERE region LIKE :region";
    $params[':region'] = "%" . $_GET['region'] . "%";
}

$stmt = $conn->prepare($query);
$stmt->execute($params);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>

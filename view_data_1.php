<!DOCTYPE html>
<html>
<head>
    <title>Просмотр данных</title>
</head>
<body>

<h1>Просмотр данных</h1>



<?php
include 'db.php';

echo "<h2>Организации</h2>";
$org_sql = "SELECT * FROM organization";
$org_result = $conn->query($org_sql);

if ($org_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Commercial</th><th>Address</th></tr>";
    while($row = $org_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".($row["commercial"] ? "Да" : "Нет")."</td><td>".$row["address"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

echo "<h2>Тип затрат</h2>";
$type_sql = "SELECT * FROM cost_type";
$type_result = $conn->query($type_sql);

if ($type_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th></tr>";
    while($row = $type_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

echo "<h2>Пункты</h2>";
$point_sql = "SELECT sp.*, o.name as org_name FROM salespoint sp JOIN organization o ON sp.organization_id = o.id";
$point_result = $conn->query($point_sql);

if ($point_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Address</th><th>Organization</th></tr>";
    while($row = $point_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["address"]."</td><td>".$row["org_name"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

echo "<h2>Продажи</h2>";
$sales_sql = "SELECT s.*, sp.name as point_name, ct.name as type_name FROM sales s 
              JOIN salespoint sp ON s.point_id = sp.id 
              JOIN cost_type ct ON s.type_id = ct.id";
$sales_result = $conn->query($sales_sql);

if ($sales_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Sales Point</th><th>Date</th><th>Cost Type</th><th>Price</th></tr>";
    while($row = $sales_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["point_name"]."</td><td>".$row["date"]."</td><td>".$row["type_name"]."</td><td>".$row["price"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>

<a href="index.php">На главную</a>

</body>
</html>


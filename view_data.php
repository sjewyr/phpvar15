<?php
include 'db.php';

// Удаление записи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST['table'];
    $id = $_POST['id'];
    $sql = "DELETE FROM $table WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Успешное удаления";
    } else {
        echo "Ошибка удаления: " . $conn->error;
    }
}

// Функция для отображения кнопки удаления
function deleteButton($table, $id) {
    return "<form method='post' action='' style='display:inline;'>
                <input type='hidden' name='table' value='$table'>
                <input type='hidden' name='id' value='$id'>
                <input type='submit' value='Удалить'>
            </form>";
}

// Функция для форматирования даты
function formatDate($dateString) {
    $date = strtotime($dateString);
    return date("j F Y", $date);
}

echo "<h2>Организации</h2>";
$org_sql = "SELECT * FROM organization";
$org_result = $conn->query($org_sql);

if ($org_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Название</th><th>Коммерческая</th><th>Адрес</th><th>Действия</th></tr>";
    while($row = $org_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".($row["commercial"] ? "Да" : "Нет")."</td><td>".$row["address"]."</td><td>".deleteButton('organization', $row["id"])."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

echo "<h2>Типы расходов</h2>";
$type_sql = "SELECT * FROM cost_type";
$type_result = $conn->query($type_sql);

if ($type_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Название</th><th>Действия</th></tr>";
    while($row = $type_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".deleteButton('cost_type', $row["id"])."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

echo "<h2>Пункты</h2>";
$point_sql = "SELECT sp.*, o.name as org_name FROM salespoint sp JOIN organization o ON sp.organization_id = o.id";
$point_result = $conn->query($point_sql);

if ($point_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Название</th><th>Адрес</th><th>Организация</th><th>Действия</th></tr>";
    while($row = $point_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["address"]."</td><td>".$row["org_name"]."</td><td>".deleteButton('salespoint', $row["id"])."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

echo "<h2>Продажи</h2>";
$sales_sql = "SELECT s.*, sp.name as point_name, ct.name as type_name FROM sales s 
              JOIN salespoint sp ON s.point_id = sp.id 
              JOIN cost_type ct ON s.type_id = ct.id";
$sales_result = $conn->query($sales_sql);

if ($sales_result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Пункт</th><th>Дата</th><th>Тип расходов</th><th>Сумма</th><th>Действия</th></tr>";
    while($row = $sales_result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["point_name"]."</td><td>".formatDate($row["date"])."</td><td>".$row["type_name"]."</td><td>".$row["price"]."</td><td>".deleteButton('sales', $row["id"])."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}


// Подсчет суммы перечислений в коммерческие и некоммерческие организации
$comm_sql = "SELECT SUM(s.price) as total_commercial 
             FROM sales s 
             JOIN salespoint sp ON s.point_id = sp.id 
             JOIN organization o ON sp.organization_id = o.id 
             WHERE o.commercial = 1";
$comm_result = $conn->query($comm_sql);
$comm_row = $comm_result->fetch_assoc();
$comm_total = $comm_row['total_commercial'] ? $comm_row['total_commercial'] : 0;

$noncomm_sql = "SELECT SUM(s.price) as total_noncommercial 
                FROM sales s 
                JOIN salespoint sp ON s.point_id = sp.id 
                JOIN organization o ON sp.organization_id = o.id 
                WHERE o.commercial = 0";
$noncomm_result = $conn->query($noncomm_sql);
$noncomm_row = $noncomm_result->fetch_assoc();
$noncomm_total = $noncomm_row['total_noncommercial'] ? $noncomm_row['total_noncommercial'] : 0;

echo "<h2>Сумма перечислений</h2>";
echo "<table border='1'><tr><th>Тип</th><th>Общая сумма</th></tr>";
echo "<tr><td>Коммерческие</td><td>".$comm_total."</td></tr>";
echo "<tr><td>Некоммерческие</td><td>".$noncomm_total."</td></tr>";
echo "</table>";


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Просмотр данных</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Просмотр данных</h1>
<a href="index.php">На главную</a>

</body>
</html>

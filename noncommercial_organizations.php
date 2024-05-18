<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Некоммерческие организации</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>



<?php
include 'db.php';

// SQL-запрос для выбора названий и адресов коммерческих организаций-получателей
$sql = "SELECT name, address FROM organization WHERE commercial = 0";

// Выполнение запроса
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод заголовка отчета
    echo "<h1>Отчет о некоммерческих организациях</h1>";

    // Вывод данных в виде таблицы
    echo "<table border='1'>";
    echo "<tr><th>Название</th><th>Адрес</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['address']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // Если нет результатов, вывести сообщение
    echo "Нет некоммерческих организаций.";
}

// Закрытие соединения с базой данных
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>�������������� �����������</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>



<?php
include 'db.php';

// SQL-������ ��� ������ �������� � ������� ������������ �����������-�����������
$sql = "SELECT name, address FROM organization WHERE commercial = 0";

// ���������� �������
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // ����� ��������� ������
    echo "<h1>����� � �������������� ������������</h1>";

    // ����� ������ � ���� �������
    echo "<table border='1'>";
    echo "<tr><th>��������</th><th>�����</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['address']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // ���� ��� �����������, ������� ���������
    echo "��� �������������� �����������.";
}

// �������� ���������� � ����� ������
$conn->close();
?>
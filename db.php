<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prak";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Установка кодировки соединения
if (!$conn->set_charset("cp1251")) {
    echo "Error loading character set cp1251: " . $conn->error;
}
?>


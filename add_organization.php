<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $commercial = $_POST['commercial'];
    $address = $_POST['address'];

    $sql = "INSERT INTO organization (name, commercial, address) VALUES ('$name', $commercial, '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "Успех";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>

<h2>Добавить организацию</h2>
<form method="post" action="">
  Название:<br>
  <input type="text" name="name" required>
  <br>
  Коммерческая:<br>
  <input type="radio" name="commercial" value="1" required> Да
  <input type="radio" name="commercial" value="0" required> Нет
  <br>
  Адрес:<br>
  <input type="text" name="address" required>
  <br><br>
  <input type="submit" value="Добавить">
</form>
<a href="index.php">На главную</a>
</body>
</html>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $sql = "INSERT INTO cost_type (name) VALUES ('$name')";

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

<h2>Добавить тип расходов</h2>
<form method="post" action="">
  Название:<br>
  <input type="text" name="name" required>
  <br><br>
  <input type="submit" value="Добавить">
</form>
<a href="index.php">На главную</a>
</body>
</html>

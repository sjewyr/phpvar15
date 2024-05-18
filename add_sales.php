<?php
include 'db.php';

$point_sql = "SELECT id, name FROM salespoint";
$point_result = $conn->query($point_sql);

$type_sql = "SELECT id, name FROM cost_type";
$type_result = $conn->query($type_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $point_id = $_POST['point_id'];
    $date = $_POST['date'];
    $type_id = $_POST['type_id'];
    $price = $_POST['price'];

    $sql = "INSERT INTO sales (point_id, date, type_id, price) VALUES ($point_id, '$date', $type_id, $price)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>

<h2>Добавить продажу</h2>
<form method="post" action="">
  Пункт:<br>
  <select name="point_id" required>
    <?php while($row = $point_result->fetch_assoc()): ?>
      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
    <?php endwhile; ?>
  </select>
  <br>
  Дата:<br>
  <input type="date" name="date" required>
  <br>
  Тип расходов:<br>
  <select name="type_id" required>
    <?php while($row = $type_result->fetch_assoc()): ?>
      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
    <?php endwhile; ?>
  </select>
  <br>
  Сумма:<br>
  <input type="number" name="price" required>
  <br><br>
  <input type="submit" value="Добавить">
</form>
<a href="index.php">На главную</a>
</body>
</html>

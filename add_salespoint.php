<?php
include 'db.php';

$org_sql = "SELECT id, name FROM organization";
$org_result = $conn->query($org_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $organization_id = $_POST['organization_id'];

    $sql = "INSERT INTO salespoint (name, address, organization_id) VALUES ('$name', '$address', $organization_id)";

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

<h2>Добавить пункт</h2>
<form method="post" action="">
  Название:<br>
  <input type="text" name="name" required>
  <br>
  Адрес:<br>
  <input type="text" name="address" required>
  <br>
  Организация:<br>
  <select name="organization_id" required>
    <?php while($row = $org_result->fetch_assoc()): ?>
      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
    <?php endwhile; ?>
  </select>
  <br><br>
  <input type="submit" value="Добавить">
</form>
<a href="index.php">На главную</a>
</body>
</html>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $commercial = $_POST['commercial'];
    $address = $_POST['address'];

    $sql = "INSERT INTO organization (name, commercial, address) VALUES ('$name', $commercial, '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "�����";
    } else {
        echo "������: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>

<h2>�������� �����������</h2>
<form method="post" action="">
  ��������:<br>
  <input type="text" name="name" required>
  <br>
  ������������:<br>
  <input type="radio" name="commercial" value="1" required> ��
  <input type="radio" name="commercial" value="0" required> ���
  <br>
  �����:<br>
  <input type="text" name="address" required>
  <br><br>
  <input type="submit" value="��������">
</form>
<a href="index.php">�� �������</a>
</body>
</html>

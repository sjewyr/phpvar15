<!DOCTYPE html>
<html>
<head>
    <title>Список организаций</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Список организаций</h1>

<table>
    <tr>
        <th>Дата</th>
        <th>Сумма</th>
        <th>Количество транзакций</th>
    </tr>
    <?php
    include 'db.php';

    // SQL-запрос
    $sql = "SELECT 
                o.name AS organization_name, 
                o.commercial, 
                ct.name AS cost_type_name, 
                SUM(s.price) AS total_price, 
                COUNT(*) AS total_transactions, 
                DATE_FORMAT(s.date, '%e %M %Y') AS formatted_date
            FROM 
                organization o
            JOIN 
                salespoint sp ON o.id = sp.organization_id
            JOIN 
                sales s ON sp.id = s.point_id
            JOIN 
                cost_type ct ON s.type_id = ct.id
            GROUP BY 
                o.commercial, 
                o.name, 
                ct.name, 
                s.date
            ORDER BY 
                o.commercial DESC, 
                o.name, 
                ct.name, 
                s.date";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $current_organization = "";
        $current_type = "";
        $total_transactions = 0;

        while ($row = $result->fetch_assoc()) {
            if ($current_organization != $row["organization_name"]) {
                if ($current_organization != "") {
                    echo "<tr><td colspan='3'>Количество транзакций: $total_transactions</td></tr>";
                    $total_transactions = 0;
                }
                echo "<tr><td colspan='3'><h2>{$row["organization_name"]}</h2></td></tr>";
                $current_organization = $row["organization_name"];
                $current_type = "";
            }
            if ($current_type != $row["cost_type_name"]) {
                if ($current_type != "") {
                    echo "<tr><td colspan='3'>Количество транзакций: $total_transactions</td></tr>";
                    $total_transactions = 0;
                }
                echo "<tr><td colspan='3'><h3>{$row["cost_type_name"]}</h3></td></tr>";
                $current_type = $row["cost_type_name"];
            }
            echo "<tr>";
            echo "<td>{$row["formatted_date"]}</td>";
            echo "<td>{$row["total_price"]}</td>";
            echo "<td>{$row["total_transactions"]}</td>";
            echo "</tr>";
            $total_transactions += $row["total_transactions"];
        }
        echo "<tr><td colspan='3'>Количество транзакций: $total_transactions</td></tr>";
    } else {
        echo "<tr><td colspan='3'>Результатов не найдено</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>

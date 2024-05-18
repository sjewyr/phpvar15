<!DOCTYPE html>
<html>
<head>
    <title>�������</title>
    <head><link rel="stylesheet" href="style.css"></head>
</head>
<body>

<h1>�������</h1>
<ul>
    <li><a href="add_organization.php">�������� �����������</a></li>
    <li><a href="add_cost_type.php">�������� ��� ��������</a></li>
    <li><a href="add_salespoint.php">�������� �����</a></li>
    <li><a href="add_sales.php">�������� �������</a></li>
    <li><a href="view_data.php">�������� ������</a></li>
    <li><a href="organization_list.php"> ������ �����������</a></li>
    <li><a href="commercial_organizations.php"> ������������ �����������</a></li>
    <li><a href="noncommercial_organizations.php"> �������������� �����������</a></li>
</ul>
 <!-- ����� ������ �� ���� ������������ -->
 <form action="" method="GET">  
        <label for="date">������ �� ����:</label>
        <input type="date" id="date" name="date">
        <button type="submit" name="search_by_date">�����</button>
    </form>

    <!-- ����� ������ �� �������� ����������� -->
    <form action="" method="GET">
        <label for="organization">������ �� �������� �����������:</label>
        <input type="text" id="organization" name="organization">
        <button type="submit" name="search_by_organization">�����</button>
    </form>

    <!-- ������ ��� ���������� �� ���� ������������ -->
    <form action="" method="GET">
        <button type="submit" name="sort_by_date">����������� �� ����</button>
    </form>

    <!-- ������ ��� ���������� �� ����� ������ -->
    <form action="" method="GET">
        <button type="submit" name="sort_by_cost_type">����������� �� ���� ��������</button>
    </form>

    <!-- ������� ��� ������ ����������� -->
    <table>
        <thead>
            <tr>
                <th>����</th>
                <th>�������� �����������</th>
                <th>��� ��������</th>
                <th>����</th>
                <th>�����</th>
                <th>������������</th>
            </tr>
        </thead>
        <tbody>
        <?php
        function formatDate($dateString) {
            $date = strtotime($dateString);
            return date("j F Y", $date);
        }
            // ����������� � ���� ������
            include 'db.php';

            // ����� �� ���� ������������
            if(isset($_GET['search_by_date'])) {
                $date = $_GET['date'];
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                WHERE sales.date = '$date'";
            }
            // ����� �� �������� �����������
            elseif(isset($_GET['search_by_organization'])) {
                $organization = $_GET['organization'];
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                WHERE organization.name LIKE '%$organization%'";
            }
            // ���������� �� ���� ������������
            elseif(isset($_GET['sort_by_date'])) {
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                ORDER BY sales.date";
            }
            // ���������� �� ����� ������
            elseif(isset($_GET['sort_by_cost_type'])) {
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                ORDER BY cost_type.name";
            }
            // ���� �� ���� �� ������ �� ������, ������� ��� ������
            else {
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                JOIN salespoint ON sales.point_id = salespoint.id
                JOIN organization ON salespoint.organization_id = organization.id
                JOIN cost_type ON sales.type_id = cost_type.id";
            }

            // ���������� �������
            $result = $conn->query($sql);

            // ����� �����������
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".formatDate($row['date'])."</td><td>{$row['organization_name']}</td><td>{$row['cost_type_name']}</td><td>{$row['price']}</td><td>{$row['address']}</td><td>".($row['commercial'] ? "��" : "���")."</td></tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No results found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php

            $sql = "SELECT salespoint.id, salespoint.name AS salespoint_name, SUM(sales.price) AS total_sales 
            FROM salespoint 
            INNER JOIN sales ON salespoint.id = sales.point_id 
            GROUP BY salespoint.id 
            ORDER BY total_sales DESC 
            LIMIT 1";

            echo "����� � ���������� ������ ������������";
            // ���������� �������
            $result = $conn->query($sql);

            // ����� �����������
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<p>��������: {$row['salespoint_name']}</p>";
                echo "<p>����� ������������: {$row['total_sales']}</p>";
            } else {
                echo "<p>������� �� �������</p>";
            }

            // �������� ���������� � ����� ������
            $conn->close();
            ?>
</body>
</html>

</body>
</html>

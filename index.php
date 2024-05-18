<!DOCTYPE html>
<html>
<head>
    <title>Главная</title>
    <head><link rel="stylesheet" href="style.css"></head>
</head>
<body>

<h1>Главная</h1>
<ul>
    <li><a href="add_organization.php">Добавить организацию</a></li>
    <li><a href="add_cost_type.php">Добавить тип расходов</a></li>
    <li><a href="add_salespoint.php">Добавить пункт</a></li>
    <li><a href="add_sales.php">Добавить продажу</a></li>
    <li><a href="view_data.php">Просмотр данных</a></li>
    <li><a href="organization_list.php"> Список организаций</a></li>
    <li><a href="commercial_organizations.php"> Коммерческие организации</a></li>
    <li><a href="noncommercial_organizations.php"> Некоммерческие организации</a></li>
</ul>
 <!-- Форма поиска по дате перечисления -->
 <form action="" method="GET">  
        <label for="date">Искать по дате:</label>
        <input type="date" id="date" name="date">
        <button type="submit" name="search_by_date">Поиск</button>
    </form>

    <!-- Форма поиска по названию организации -->
    <form action="" method="GET">
        <label for="organization">Искать по названию организации:</label>
        <input type="text" id="organization" name="organization">
        <button type="submit" name="search_by_organization">Поиск</button>
    </form>

    <!-- Кнопка для сортировки по дате перечисления -->
    <form action="" method="GET">
        <button type="submit" name="sort_by_date">Сортировать по дате</button>
    </form>

    <!-- Кнопка для сортировки по видам затрат -->
    <form action="" method="GET">
        <button type="submit" name="sort_by_cost_type">Сортировать по типу расходов</button>
    </form>

    <!-- Таблица для вывода результатов -->
    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Название организации</th>
                <th>Тип расходов</th>
                <th>Цена</th>
                <th>Адрес</th>
                <th>Коммерческая</th>
            </tr>
        </thead>
        <tbody>
        <?php
        function formatDate($dateString) {
            $date = strtotime($dateString);
            return date("j F Y", $date);
        }
            // Подключение к базе данных
            include 'db.php';

            // Поиск по дате перечисления
            if(isset($_GET['search_by_date'])) {
                $date = $_GET['date'];
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                WHERE sales.date = '$date'";
            }
            // Поиск по названию организации
            elseif(isset($_GET['search_by_organization'])) {
                $organization = $_GET['organization'];
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                WHERE organization.name LIKE '%$organization%'";
            }
            // Сортировка по дате перечисления
            elseif(isset($_GET['sort_by_date'])) {
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                ORDER BY sales.date";
            }
            // Сортировка по видам затрат
            elseif(isset($_GET['sort_by_cost_type'])) {
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                INNER JOIN salespoint ON sales.point_id = salespoint.id
                INNER JOIN organization ON salespoint.organization_id = organization.id
                INNER JOIN cost_type ON sales.type_id = cost_type.id
                ORDER BY cost_type.name";
            }
            // Если ни одна из кнопок не нажата, выводим все записи
            else {
                $sql = "SELECT sales.date, organization.name AS organization_name, cost_type.name AS cost_type_name, sales.price, salespoint.address, organization.commercial FROM sales 
                JOIN salespoint ON sales.point_id = salespoint.id
                JOIN organization ON salespoint.organization_id = organization.id
                JOIN cost_type ON sales.type_id = cost_type.id";
            }

            // Выполнение запроса
            $result = $conn->query($sql);

            // Вывод результатов
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".formatDate($row['date'])."</td><td>{$row['organization_name']}</td><td>{$row['cost_type_name']}</td><td>{$row['price']}</td><td>{$row['address']}</td><td>".($row['commercial'] ? "Да" : "Нет")."</td></tr>";
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

            echo "Пункт с наибольшей суммой перечислений";
            // Выполнение запроса
            $result = $conn->query($sql);

            // Вывод результатов
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<p>Название: {$row['salespoint_name']}</p>";
                echo "<p>Сумма перечислений: {$row['total_sales']}</p>";
            } else {
                echo "<p>Пунктов не найдено</p>";
            }

            // Закрытие соединения с базой данных
            $conn->close();
            ?>
</body>
</html>

</body>
</html>

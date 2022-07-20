<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
    <title><?=$pageTitle?></title>
</head>
<body>
<div class="container mt-5">
    <header class="navbar">
        <a href="tour_requests.php" class="navLink nav-link">Личный кабинет<a> |
        <div class="dropdown">
        <a href="#" class="dropbtn navLink nav-link" onclick="dropContent()">Администрирование</a>
            <div class="dropdown-content" id="myDropdown">
                <a href="real_estate.php" class="droplink nav-link">Недвижимость<a>
                <a href="clients.php" class="droplink nav-link">Клиенты<a>
                <a href="adresses.php" class="droplink nav-link">Адреса<a>
                <a href="streets.php" class="droplink nav-link">Улицы<a>
                <a href="cities.php" class="droplink nav-link">Города<a>
                <a href="countries.php" class="droplink nav-link">Страны<a>
                <a href="wall_materials.php" class="droplink nav-link">Материалы стен<a>
                <a href="request_status.php" class="droplink nav-link">Статусы заявок<a>
            </div>
        </div>
    </header>

    

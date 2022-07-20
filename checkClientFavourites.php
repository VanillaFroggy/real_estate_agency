<?php
    session_start();

    if(isset($_POST["isDeleteFavourite"]) && $_POST["isDeleteFavourite"] == 1) {
        require_once "db.php";
        $mysql = new mysqli($host, $hostLogin, $hostPassword, $dbName);
        $mysql->query("DELETE FROM `client_favourites` WHERE `client_id` = '" . $_SESSION["userId"] . "' AND `real_estate_id` = '" . $_POST["clientFavouriteId"] . "';");
        header("Location: tour_requests.php");
    }
    else {
        $_SESSION["realEstateID"] = $_POST["clientFavouriteId"];
        header("Location: realEstateElement.php");
        exit;
    }
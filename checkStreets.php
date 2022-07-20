<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: streets.php");
        exit;
    }

    $_SESSION["streetTextError"] = "";
    if(strlen(trim($_POST["streetName"])) < 5) {
        $_SESSION["streetTextError"] = "Название улицы должно содержать минимум 5 букв";
        redirect();
    }
    else {
        $_SESSION["streetTextError"] = "";
        
        $cityId = htmlspecialchars(trim($_POST["cityId"]));
        $streetName = htmlspecialchars(trim($_POST["streetName"]));
        $streetDescription = htmlspecialchars(trim($_POST["streetDescription"]));

        if($_POST["isEditForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $streetId = htmlspecialchars(trim($_POST["streetID"]));
                $mysql->query("UPDATE `streets` SET `city_id` = '$cityId', `street_name` = '$streetName', `description` = '$streetDescription' WHERE `id` = '$streetId';");
                redirect();
            }
        }
        else if($_POST["isCreateForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $mysql->query("INSERT INTO `streets` (`city_id`, `street_name`, `description`) VALUES ('$cityId', '$streetName', '$streetDescription');");
                redirect();
            }
        }
    }

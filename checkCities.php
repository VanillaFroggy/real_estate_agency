<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: cities.php");
        exit;
    }

    $_SESSION["cityTextError"] = "";
    if(strlen(trim($_POST["cityName"])) < 3) {
        $_SESSION["cityTextError"] = "Название города должно содержать минимум 3 буквы";
        redirect();
    }
    else {
        $_SESSION["cityTextError"] = "";
        
        $countryId = htmlspecialchars(trim($_POST["countryId"]));
        $cityName = htmlspecialchars(trim($_POST["cityName"]));
        $cityDescription = htmlspecialchars(trim($_POST["cityDescription"]));

        if($_POST["isEditForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $cityId = htmlspecialchars(trim($_POST["cityID"]));
                $mysql->query("UPDATE `cities` SET `country_id` = '$countryId', `city_name` = '$cityName', `description` = '$cityDescription' WHERE `id` = '$cityId';");
                redirect();
            }
        }
        else if($_POST["isCreateForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $mysql->query("INSERT INTO `cities` (`country_id`, `city_name`, `description`) VALUES ('$countryId', '$cityName', '$cityDescription');");
                redirect();
            }
        }
    }

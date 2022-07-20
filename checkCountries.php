<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: countries.php");
        exit;
    }

    $_SESSION["countryTextError"] = "";
    if(strlen(trim($_POST["countryName"])) < 4) {
        $_SESSION["countryTextError"] = "Название страны должно содержать минимум 3 буквы";
        redirect();
    }
    else {
        $_SESSION["countryTextError"] = "";
        
        $countryName = htmlspecialchars(trim($_POST["countryName"]));
        $countryDescription = htmlspecialchars(trim($_POST["countryDescription"]));

        if($_POST["isEditForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $countryId = htmlspecialchars(trim($_POST["countryID"]));
                $mysql->query("UPDATE `countries` SET `country_name` = '$countryName', `description` = '$countryDescription' WHERE `id` = '$countryId';");
                redirect();
            }
        }
        else if($_POST["isCreateForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $mysql->query("INSERT INTO `countries` (`country_name`, `description`) VALUES ('$countryName', '$countryDescription');");
                redirect();
            }
        }
    }

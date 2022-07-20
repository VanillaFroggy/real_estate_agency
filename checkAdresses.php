<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: adresses.php");
        exit;
    }

    $_SESSION["errorNumber"] = "";
    
    if(trim($_POST["houseNumber"]) < 0 || trim($_POST["apartmentNumber"]) < 0) {
        $_SESSION["errorNumber"] = "Числа должны быть больше нуля";
        redirect();
    }
    else {
        $_SESSION["errorNumber"] = "";  

        $streetId = htmlspecialchars(trim($_POST["streetId"]));
        $houseNumber = htmlspecialchars(trim($_POST["houseNumber"]));
        $apartmentNumber = htmlspecialchars(trim($_POST["apartmentNumber"]));

        if($_POST["isEditForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $adressId = htmlspecialchars(trim($_POST["adressID"]));
                $mysql->query("UPDATE `adresses` SET `street_id` = '$streetId', `house_number` = '$houseNumber', `apartment_number` = '$apartmentNumber' WHERE `id` = '$adressId';");
                redirect();
            }
        }
        else if($_POST["isCreateForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $mysql->query("INSERT INTO `adresses` (`street_id`, `house_number`, `apartment_number`) VALUES ('$streetId', '$houseNumber', '$apartmentNumber');");
                redirect();
            }
        }
    }

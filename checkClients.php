<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: clients.php");
        exit;
    }

    $_SESSION["clientTextError"] = "";
    $_SESSION["clientPhoneError"] = "";
    if(strlen(trim($_POST["clientSurname"])) <= 1 || strlen(trim($_POST["clientFirstname"])) <= 1 || strlen(trim($_POST["clientLogin"])) <= 1 || strlen(trim($_POST["clientPassword"])) <= 1) {
        $_SESSION["clientTextError"] = "Текстовые поля должны содержать больше одного символа";
        redirect();
    }
    else if(strval(strlen(trim($_POST["clientPhone"]))) < 11) {
        $_SESSION["clientPhoneError"] = "Телефон должен содержать 11 цифр";
        redirect();
    }
    else {
        $_SESSION["clientTextError"] = "";
        $_SESSION["clientPhoneError"] = "";    

        $clientSurname = htmlspecialchars(trim($_POST["clientSurname"]));
        $clientFirstname = htmlspecialchars(trim($_POST["clientFirstname"]));
        $clientPatronymic = htmlspecialchars(trim($_POST["clientPatronymic"]));
        $clientPhone = htmlspecialchars(trim($_POST["clientPhone"]));
        $clientLogin = htmlspecialchars(trim($_POST["clientLogin"]));
        $clientPassword = htmlspecialchars(trim($_POST["clientPassword"]));

        if($_POST["isEditForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $clientId = htmlspecialchars(trim($_POST["clientID"]));
                $mysql->query("UPDATE `clients` SET `surname` = '$clientSurname', `firstname` = '$clientFirstname', `patronymic` = '$clientPatronymic', `phonenumber` = '$clientPhone', `login` = '$clientLogin', `password` = '$clientPassword' WHERE `id` = '$clientId';");
                redirect();
            }
        }
        else if($_POST["isCreateForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $mysql->query("INSERT INTO `clients` (`role_id`, `surname`, `firstname`, `patronymic`, `phonenumber`, `login`, `password`) VALUES ('2', '$clientSurname', '$clientFirstname', '$clientPatronymic', '$clientPhone', '$clientLogin', '$clientPassword');");
                redirect();
            }
        }
    }

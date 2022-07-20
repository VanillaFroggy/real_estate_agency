<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: tour_requests.php");
        exit;
    }

    $_SESSION['errorUserLastname'] = "";
    $_SESSION['errorUserFirstname'] = "";
    $_SESSION['errorUserPatronymic'] = "";
    $_SESSION['errorUserPhone'] = "";
    $_SESSION['errorUserLogin'] = "";
    $_SESSION['errorUserPassword'] = "";

    if(strlen($_POST["userLastname"]) <= 1) {
        $_SESSION['errorUserLastname'] = "Слишком короткокая фамилия";
        redirect();
    }
    else if(strlen($_POST["userFirstname"]) <= 1) {
        $_SESSION['errorUserFirstname'] = "Слишком короткокое имя";
        redirect();
    }
    else if(strlen($_POST["userPatronymic"]) <= 1) {
        $_SESSION['errorUserPatronymic'] = "Слишком короткокое отчество";
        redirect();
    }
    else if(strlen(strval($_POST["userPhone"])) < 11) {
        $_SESSION['errorUserPhone'] = "Слишком короткокий номер телефона";
        redirect();
    }
    else if(strlen($_POST["userLogin"]) <= 1) {
        $_SESSION['errorUserLogin'] = "Слишком короткокий логин";
        redirect();
    }
    else if(strlen($_POST["userPassword"]) <= 1) {
        $_SESSION['errorUserPassword'] = "Слишком короткокий пароль";
        redirect();
    }
    else {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $_SESSION['errorUserLastname'] = "";
            $_SESSION['errorUserFirstname'] = "";
            $_SESSION['errorUserPatronymic'] = "";
            $_SESSION['errorUserPhone'] = "";
            $_SESSION['errorUserLogin'] = "";
            $_SESSION['errorUserPassword'] = "";

            $_SESSION['userLastname'] = $_POST["userLastname"];
            $_SESSION['userFirstname'] = $_POST["userFirstname"];
            $_SESSION['userPatronymic'] = $_POST["userPatronymic"];
            $_SESSION['userPhone'] = $_POST["userPhone"];
            $_SESSION['userLogin'] = $_POST["userLogin"];
            $_SESSION['userPassword'] = $_POST["userPassword"];
            $_SESSION["userId"];
            if($_SESSION["userRole"] == 1)
                $table = "rieltors";
            else
                $table = "clients";
            $mysql->query("UPDATE `$table` SET `surname` = '" . $_SESSION['userLastname'] . "', `firstname` = '" . $_SESSION['userFirstname'] . "', `patronymic` = '" . $_SESSION['userPatronymic'] . "', `phonenumber` = '" . $_SESSION['userPhone'] . "', `login` = '" . $_SESSION['userLogin'] . "', `password` = '" . $_SESSION['userPassword'] . "'
                WHERE `id` = '" . $_SESSION['userId'] . "';");

    // $mysql->query("INSERT INTO `$table` (`surname`, `firstname`, `patronymic`, `phonenumber`, `login`, `password`)
    // VALUES (" . $clientId . "," . $rieltorId . "," . $realEstateId . "," . '$dateTime' . "," . '$tourTime' . "," . 'VAR' . ");");
    }
        redirect();
    }
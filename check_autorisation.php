<?php
    session_start();

    require_once "db.php";

    $_SESSION["errorAutorisation"] = "";

    function redirectClient() {
        header("Location: real_estate.php");
        exit();
    }
    function redirectRieltor() {
        header("Location: tour_requests.php");
        exit();
    }
    function redirectBack() {
        header("Location: autorisation.php");
        exit();
    }
    function checkSelectResults($result) {  
        while($row = $result->fetch_assoc()) {   
            $_SESSION['userId'] = $row['id'];
            $_SESSION['userRole'] = $row['role_id'];
            $_SESSION['userLastname'] = $row['surname'];
            $_SESSION['userFirstname'] = $row['firstname'];
            $_SESSION['userPatronymic'] = $row['patronymic'];
            $_SESSION['userPhone'] = $row['phonenumber'];
        }
    }

    $login = htmlspecialchars(trim($_POST["login"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    
    $_SESSION["userLogin"] = $login;
    $_SESSION["userPassword"] = $password;

    if($mysql->connect_error) {
        echo "Error Number: ". $mysqsl->connect_errno."<br>";
        echo "Error: " . $mysql->connect_error;
    }
    else {
        $clientResult = $mysql->query("SELECT * FROM `clients` WHERE `login` = '$login' AND `password` = '$password'");
        $rieltorResult = $mysql->query("SELECT * FROM `rieltors` WHERE `login` = '$login' AND `password` = '$password'");
        if($clientResult->num_rows > 0) {           
            checkSelectResults($clientResult);
            redirectClient();
        }
        else if($rieltorResult->num_rows > 0) {
            checkSelectResults($rieltorResult);
            redirectRieltor();
        }
        else {
            $_SESSION["errorAutorisation"] = "Неверный логин или пароль";
            redirectBack();
        }
    }
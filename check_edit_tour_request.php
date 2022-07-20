<?php
    session_start();

    require_once "db.php";

    $_SESSION["errorLastname"] = "";
    $_SESSION["errorDateTime"] = "";
    $_SESSION["errorTourTime"] = "";

    function redirect() {
        header("Location: tour_requests.php");
        exit;
    }
    function printSelectRow($result, $columnName) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {   
                $element = $row[$columnName];
            }
        }
        return $element;
    }

    $dateTime = htmlspecialchars(trim($_POST["dateTime"]));
    $tourTime = htmlspecialchars(trim($_POST["tourTime"]));
    $requestName = htmlspecialchars(trim($_POST["requestName"]));

    $_SESSION["dateTime"] = $dateTime;
    $_SESSION["tourTime"] = $tourTime;
    $_SESSION["requestName"] = $requestName;
    $tourRequestID = $_SESSION["tourRequestID"];

    $actualDate = date("d-m-Y H:i");

    if(strtotime($actualDate) > strtotime($dateTime)) {
        $_SESSION["errorDateTime"] = "Input correct data";
        redirect();
    }
    else if($tourTime <= 0) {
        $_SESSION["errorTourTime"] = "Input correct time";
        redirect();
    }
    else {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $userId = $_SESSION["userId"];
            $humanId = 'rieltor_id';
            $rieltorId = $userId;

            $requestResult = $mysql->query("SELECT `id` FROM `request_status` WHERE `request_status_name` = '" . $requestName . "';");
            $requestStatusId = printSelectRow($requestResult, "id");

            $mysql->query("UPDATE `tour_requests` SET `meeting_date` = '$dateTime', `tour_time` = '$tourTime', `request_status_id` = '$requestStatusId' WHERE `id` = $tourRequestID;");
            redirect();
        }
    }
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
    function updateTourRequest($requestName, $dateTime, $tourTime, $tourRequestID) {
        $host = "localhost";
        $hostLogin = "root";
        $hostPassword = "1234";
        $dbName = "real_estate_agency";

        $mysql = new mysqli($host, $hostLogin, $hostPassword, $dbName);

        $requestResult = $mysql->query("SELECT `id` FROM `request_status` WHERE `request_status_name` = '" . $requestName . "';");
        $requestStatusId = printSelectRow($requestResult, "id");
        $mysql->query("UPDATE `tour_requests` SET /*`meeting_date` = '$dateTime',*/ `tour_time` = '$tourTime', `request_status_id` = $requestStatusId
            WHERE `id` = '$tourRequestID';");
    }
    function deleteTourRequest($tourRequestID) {
        $host = "localhost";
        $hostLogin = "root";
        $hostPassword = "1234";
        $dbName = "real_estate_agency";

        $mysql = new mysqli($host, $hostLogin, $hostPassword, $dbName);
        $mysql->query("DELETE FROM `tour_requests` WHERE `id` = '" . $tourRequestID . "';");
    }

    $clientLastName = htmlspecialchars(trim($_POST["clientLastname"]));
    $rieltorLastname = htmlspecialchars(trim($_POST["rieltorLastname"]));
    $realEstateId = htmlspecialchars(trim($_POST['realEstateId']));
    $dateTime = htmlspecialchars(trim($_POST["dateTime"]));
    $tourTime = htmlspecialchars(trim($_POST["tourTime"]));
    $isCreateForm = htmlspecialchars(trim($_POST["isCreateForm"]));
    
    if ($_POST["isEditForm"] == '1') {
        if ($_POST["isDeleteTourRequest"] == '1') {
            deleteTourRequest($_POST["tourRequestID"]);
        }
        else {
            $_SESSION["isEditForm"] = $_POST["isEditForm"];
            $_SESSION["tourRequestID"] = $_POST["tourRequestID"];
            $_SESSION["editFormStatus"] = $_POST["editFormStatus"];
            $_SESSION["requestName"] = $_POST["requestName"];
        }
        redirect();
    }

    $_SESSION["clientLastname"] = $clientLastName;
    $_SESSION["rieltorLastname"] = $rieltorLastname;
    $_SESSION["dateTime"] = $dateTime;
    $_SESSION["tourTime"] = $tourTime;

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
        $_SESSION["successData"] = "You successfully sent your data";
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $userId = $_SESSION["userId"];
            $humanId = 'client_id';
            $clientId = $userId;
            $rieltorResult = $mysql->query("SELECT `id` FROM `rieltors` WHERE `surname` = '" . $rieltorLastname . "';");
            $rieltorId = printSelectRow($rieltorResult, "id");
            $_SESSION["isCreateForm"] = $_POST["isCreateForm"];
            if($_SESSION['isCreateForm'] == '1') {
                $mysql->query("INSERT INTO `tour_requests` (`client_id`, `rieltor_id`, `real_estate_id`, `meeting_date`, `tour_time`, `request_status_id`)
                    VALUES ($clientId, $rieltorId, $realEstateId, '$dateTime', '$tourTime', '1');");
            }
        }
        redirect();
    }

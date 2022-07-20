<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: request_status.php");
        exit;
    }

    $_SESSION["requestStatusTextError"] = "";
    if(strlen(trim($_POST["requestStatusName"])) <= 6) {
        $_SESSION["requestStatusTextError"] = "Текст статуса должен содержать минимум 7 букв";
        redirect();
    }
    else {
        $_SESSION["requestStatusTextError"] = "";
        
        $requestStatusName = htmlspecialchars(trim($_POST["requestStatusName"]));

        if($_POST["isEditForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $requestStatusId = htmlspecialchars(trim($_POST["requestStatusID"]));
                $mysql->query("UPDATE `request_status` SET `request_status_name` = '$requestStatusName' WHERE `id` = '$requestStatusId';");
                redirect();
            }
        }
        else if($_POST["isCreateForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $mysql->query("INSERT INTO `request_status` (`request_status_name`) VALUES ('$requestStatusName');");
                redirect();
            }
        }
    }

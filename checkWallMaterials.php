<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: wall_materials.php");
        exit;
    }

    $wallMaterialName = htmlspecialchars(trim($_POST["wallMaterialName"]));
    $wallMaterialDescription = htmlspecialchars(trim($_POST["materialDescription"]));

    if($_POST["isEditForm"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $wallMaterialId = htmlspecialchars(trim($_POST["wallMaterialID"]));
            $mysql->query("UPDATE `wall_materials` SET `wall_material_name` = '$wallMaterialName', `description` = '$wallMaterialDescription' WHERE `id` = '$wallMaterialId';");
            redirect();
        }
    }
    else if($_POST["isCreateForm"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $mysql->query("INSERT INTO `wall_materials` (`wall_material_name`, `description`) VALUES ('" . $_POST["wallMaterialName"] . "', '" . $_POST["materialDescription"] . "');");
            redirect();
        }
    }


<?php
    session_start();

    require_once "db.php";

    function addColumnToQuery($result, $column, $value) {
        $result += "`$column` = $value";
    }

    $_SESSION['errorNumber'] = "";

    if(isset($_POST['isDeleteRealEstate'])) {
        $mysql->query("DELETE FROM `client_favourites` WHERE real_estate_id = '" . $_SESSION["realEstateID"] . "';");
        $mysql->query("DELETE FROM `real_estate` WHERE real_estate.id = '" . $_SESSION["realEstateID"] . "';");
        header("Location: real_estate.php");
        exit;
    }
    else if(isset($_POST['isInsertToFavourites'])) {
        $mysql->query("INSERT INTO `client_favourites` (`client_id`, `real_estate_id`) VALUES ('" . $_SESSION["userId"] . "', '" . $_SESSION["realEstateID"] . "');");
        header("Location: realEstateElement.php");
        exit;
    }
    else {
        if($_POST['realEstateArea'] < 0 || $_POST['realEstateCeilingHeight'] < 0 || $_POST['realEstatePrice'] < 0 || $_POST['realEstateConstructionYear'] < 0 || $_POST['realEstateRoomsNum'] < 0 || $_POST['realEstateFloor'] < 0 || $_POST['realEstateStorey'] < 0) {
            $_SESSION['errorNumber'] = "Вводите положительные числа";
            header("Location: realEstateElement.php");
            exit;
        }
        else {
            if(isset($_POST['typeOfRealEstate'])) {
                $mysql->query("UPDATE `real_estate` SET `type_of_real_estate` = '" . $_POST['typeOfRealEstate'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateArea'])) {
                $mysql->query("UPDATE `real_estate` SET `area` = '" . $_POST['realEstateArea'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateCeilingHeight'])){
                $mysql->query("UPDATE `real_estate` SET `ceiling_height` = '" . $_POST['realEstateCeilingHeight'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstatePrice'])){
                $mysql->query("UPDATE `real_estate` SET `price` = '" . $_POST['realEstatePrice'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateConstructionYear'])){
                $mysql->query("UPDATE `real_estate` SET `year_of_construction` = '" . $_POST['realEstateConstructionYear'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateRepairType'])){
                $mysql->query("UPDATE `real_estate` SET `repair_type` = '" . $_POST['realEstateRepairType'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateRoomsNum'])){
                $mysql->query("UPDATE `real_estate` SET `number_of_rooms` = '" . $_POST['realEstateRoomsNum'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateFloor'])){
                $mysql->query("UPDATE `real_estate` SET `floor` = '" . $_POST['realEstateFloor'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateAdress'])){
                $mysql->query("UPDATE `real_estate` SET `adress_id` = '" . $_POST['realEstateAdress'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateBathroom'])){
                $mysql->query("UPDATE `real_estate` SET `bathroom` = '" . $_POST['realEstateBathroom'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateKitchen'])){
                $mysql->query("UPDATE `real_estate` SET `availability_of_a_kitchen` = '" . $_POST['realEstateKitchen'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateBalcony'])){
                $mysql->query("UPDATE `real_estate` SET `balcony` = '" . $_POST['realEstateBalcony'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateStorey'])){
                $mysql->query("UPDATE `real_estate` SET `number_of_storeys` = '" . $_POST['realEstateStorey'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateWallMaterial'])){
                $mysql->query("UPDATE `real_estate` SET `wall_material_id` = '" . $_POST['realEstateWallMaterial'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateWindowsMaterial'])){
                $mysql->query("UPDATE `real_estate` SET `windows_material` = '" . $_POST['realEstateWindowsMaterial'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateNewResale'])){
                $mysql->query("UPDATE `real_estate` SET `new_building_resale` = '" . $_POST['realEstateNewResale'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateInfrastructure'])){
                $mysql->query("UPDATE `real_estate` SET `infrastructure` = '" . $_POST['realEstateInfrastructure'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateAdditionally'])){
                $mysql->query("UPDATE `real_estate` SET `additionally` = '" . $_POST['realEstateAdditionally'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            if(isset($_POST['realEstateStatus'])){
                $mysql->query("UPDATE `real_estate` SET `status` = '" . $_POST['realEstateStatus'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
            }
            
            $_SESSION['errorNumber'] = "";

            header("Location: realEstateElement.php");
            print_r($_POST);
            exit;
        }
    }
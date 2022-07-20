<?php
    session_start();

    require_once "db.php";

    $_SESSION['errorNumber'] = "";

    if($_POST['realEstateArea'] < 0 || $_POST['realEstateCeilingHeight'] < 0 || $_POST['realEstatePrice'] < 0 || $_POST['realEstateConstructionYear'] < 0 || $_POST['realEstateRoomsNum'] < 0 || $_POST['realEstateFloor'] < 0 || $_POST['realEstateStorey'] < 0) {
        $_SESSION['errorNumber'] = "Вводите положительные числа";
        header("Location: createRealEstate.php");
        exit;
    }
    else {
        $mysql->query("INSERT INTO `real_estate` (`type_of_real_estate`, `area`, `ceiling_height`, `price`, `year_of_construction`, `repair_type`, `number_of_rooms`, `floor`, `adress_id`, `bathroom`, `availability_of_a_kitchen`, `balcony`, `number_of_storeys`, `wall_material_id`, `windows_material`, `new_building_resale`, `infrastructure`, `additionally`, `status`)
            VALUES ('" . $_POST['typeOfRealEstate'] . "', '" . $_POST['realEstateArea'] . "', '" . $_POST['realEstateCeilingHeight'] . "', '" . $_POST['realEstatePrice'] . "', '" . $_POST['realEstateConstructionYear'] . "', '" . $_POST['realEstateRepairType'] . "', '" . $_POST['realEstateRoomsNum'] . "', '" . $_POST['realEstateFloor'] . "', '" . $_POST['realEstateAdress'] . "', '" . $_POST['realEstateBathroom'] . "', '" . $_POST['realEstateKitchen'] . "', '" . $_POST['realEstateBalcony'] . "', '" . $_POST['realEstateStorey'] . "', '" . $_POST['realEstateWallMaterial'] . "', '" . $_POST['realEstateWindowsMaterial'] . "', '" . $_POST['realEstateNewResale'] . "', '" . $_POST['realEstateInfrastructure'] . "', '" . $_POST['realEstateAdditionally'] . "', 'продаётся');");
        
        $_SESSION['errorNumber'] = "";

        header("Location: real_estate.php");
        exit;
    }
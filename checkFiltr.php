<?php
    // session_start();
    // require_once "db.php";

    // function addColumnToQuery($result, $column, $value) {
    //     $result += "`$column` = $value";
    // }

    // $result = "SELECT real_estate.id, real_estate.type_of_real_estate,
    //             real_estate.repair_type, real_estate.bathroom, real_estate.availability_of_a_kitchen,
    //             real_estate.balcony, real_estate.wall_material_id, wall_materials.wall_material_name,
    //             real_estate.windows_material, real_estate.new_building_resale,
    //             real_estate.real_estate_photos
    //             FROM `real_estate` INNER JOIN `wall_materials`
    //             ON real_estate.wall_material_id = wall_materials.id
    //             WHERE ";
    
    // if(isset($_POST['typeOfRealEstate']) && $_POST['typeOfRealEstate'] != '-') {
    //     $result = $result . "real_estate.type_of_real_estate = '" . $_POST['typeOfRealEstate'] . "' And ";
    // }
    // if(isset($_POST['realEstateRepairType']) && $_POST['realEstateRepairType'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `repair_type` = '" . $_POST['realEstateRepairType'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }
    // if(isset($_POST['realEstateBathroom']) && $_POST['realEstateBathroom'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `bathroom` = '" . $_POST['realEstateBathroom'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }
    // if(isset($_POST['realEstateKitchen']) && $_POST['realEstateKitchen'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `availability_of_a_kitchen` = '" . $_POST['realEstateKitchen'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }
    // if(isset($_POST['realEstateBalcony']) && $_POST['realEstateBalcony'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `balcony` = '" . $_POST['realEstateBalcony'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }
    // if(isset($_POST['realEstateWallMaterial']) && $_POST['realEstateWallMaterial'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `wall_material_id` = '" . $_POST['realEstateWallMaterial'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }
    // if(isset($_POST['realEstateWindowsMaterial']) && $_POST['realEstateWindowsMaterial'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `windows_material` = '" . $_POST['realEstateWindowsMaterial'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }
    // if(isset($_POST['realEstateNewResale']) && $_POST['realEstateNewResale'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `new_building_resale` = '" . $_POST['realEstateNewResale'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }
    // if(isset($_POST['realEstateStatus']) && $_POST['realEstateStatus'] != '-'){
    //     $mysql->query("UPDATE `real_estate` SET `status` = '" . $_POST['realEstateStatus'] . "'WHERE real_estate.id = '" . $_SESSION['realEstateID'] . "';");
    // }

    // // print_r($_POST);

    // $result = $result . "real_estate.status = 'продаётся' ORDER BY real_estate." .  $_POST['sortValue'] . ";";

    // $_SESSION["filtrResult"] = $result;

    // // print_r($_SESSION["filtrResult"]);

    // header("Location: real_estate.php");
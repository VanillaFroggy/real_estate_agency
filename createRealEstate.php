<?php
    session_start();

    require_once "db.php";
    require_once "rieltor_header.php";

    function printSelectResultsForComboBox($column) {
        $host = "localhost";
        $hostLogin = "root";
        $hostPassword = "1234";
        $dbName = "real_estate_agency";
    
        $mysql = new mysqli($host, $hostLogin, $hostPassword, $dbName);
        if($column == "wall_material_id") {
            $result = $mysql->query("SELECT id FROM `wall_materials`;");
            $column = 'id';
        }
        else if($column == "adress_id") {
            $result = $mysql->query("SELECT id FROM `adresses`;");
            $column = 'id';
        }
        else {
            $result = $mysql->query("SELECT DISTINCT $column FROM `real_estate`;");
        }
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<option>" . $row[$column] . "</option><br>";
            }
        }
        $mysql->close();
    }     
?>

<div class="description container mt-2">
    <div class="portfolio">
    <h1 class="text-center">Объект недвижимости</h1>

        <div class="container realEstateElement">
<form action="checkCreateRealEstate.php" id="editForm" style="display: block;" method="post">
    
    <label for="realEstateType" class="label">Тип недвижимости:</label>
    <select name="typeOfRealEstate" class="form-control">
        <?php printSelectResultsForComboBox('type_of_real_estate');?>
    </select><br>
    
    <label for="realEstateArea" class="label">Площадь:</label>
    <input type="number" name="realEstateArea" class="form-control">
    
    <label for="realEstateCeilingHeight" class="label">Высота потолков:</label>
    <input type="number" name="realEstateCeilingHeight" class="form-control">
    
    <label for="realEstatePrice" class="label">Цена</label>
    <input type="number" name="realEstatePrice"  class="form-control">

    <label for="realEstateConstructionYear" class="label">Год постройки:</label>
    <input type="number" name="realEstateConstructionYear" class="form-control">

    <label for="realEstateRepairType" class="label">Тип ремонта:</label>
    <select name="realEstateRepairType" class="form-control">
        <?php printSelectResultsForComboBox('repair_type');?>
    </select><br>

    <label for="realEstateRoomsNum" class="label">Количество комнат:</label>
    <input type="number" name="realEstateRoomsNum" class="form-control">

    <label for="realEstateFloor" class="label">Этаж:</label>
    <input type="number" name="realEstateFloor" class="form-control">

    <label for="realEstateAdress" class="label">Адрес:</label>
    <select name="realEstateAdress" class="form-control">
        <?php printSelectResultsForComboBox('adress_id');?>
    </select><br>

    <label for="realEstateBathroom" class="label">Тип санузла:</label>
    <select name="realEstateBathroom" class="form-control">
        <?php printSelectResultsForComboBox('bathroom');?>
    </select><br>

    <label for="realEstateKitchen" class="label">Наличие кухни::</label>
    <select name="realEstateKitchen" class="form-control">
        <?php printSelectResultsForComboBox('availability_of_a_kitchen');?>
    </select><br>

    <label for="realEstateBalcony" class="label">Тип балкона:</label>
    <select name="realEstateBalcony" class="form-control">
        <?php printSelectResultsForComboBox('balcony');?>
    </select><br>

    <label for="realEstateStorey" class="label">Этажность:</label>
    <input type="number" name="realEstateStorey" class="form-control">

    <label for="realEstateWallMaterial" class="label">Материал стен:</label>
    <select name="realEstateWallMaterial" class="form-control">
        <?php printSelectResultsForComboBox('wall_material_id');?>
    </select><br>

    <label for="realEstateWindowsMaterial" class="label">Материал окон:</label>
    <select name="realEstateWindowsMaterial" class="form-control">
        <?php printSelectResultsForComboBox('windows_material');?>
    </select><br>

    <label for="realEstateNewResale" class="label">Новостройка/вторичка:</label>
    <select name="realEstateNewResale" class="form-control">
        <?php printSelectResultsForComboBox('new_building_resale');?>
    </select><br>

    <label for="realEstateInfrastructure" class="label">Инфраструктура:</label>
    <textarea name="realEstateInfrastructure" class="form-control"></textarea>

    <!-- value="<?=$_SESSION['realEstateInfrastructure']?>" -->

    <label for="realEstateAdditionally" class="label">Дополнительно:</label>
    <textarea name="realEstateAdditionally" class="form-control"></textarea>

    <!-- value="<?php $_SESSION['realEstateAdditionally']?>" -->

    <!-- <label for="realEstateStatus" class="label">Статус:</label>
    <select name="realEstateStatus" value="<?=$_SESSION['realEstateStatus']?>" placeholder="Введите логин" class="form-control">
        <?php printSelectResultsForComboBox('status');?>
    </select><br> -->

    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>


    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; left: 35%;">Сохранить</button>
    <!-- <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button> -->
</form>

        </div>
    </div>
</div>
<?php
    session_start();

    $pageTitle = "Объект недвижимости";

    require_once "db.php";
    if(isset($_POST["realEstateID"])) {
        $_SESSION["realEstateID"] = $_POST["realEstateID"];
    }

    if($_SESSION["userRole"] == '1')
        require_once "rieltor_header.php";
    else
        require_once "client_header.php";

    
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

<?php
    $sql = "SELECT real_estate.wall_material_id, real_estate.adress_id, real_estate.id, real_estate.type_of_real_estate, real_estate.area, real_estate.area, real_estate.ceiling_height, real_estate.price, real_estate.year_of_construction, real_estate.repair_type, real_estate.number_of_rooms, real_estate.floor, countries.country_name, cities.city_name, streets.street_name, adresses.house_number, adresses.apartment_number,
        real_estate.real_estate_photos, real_estate.real_estate_sheme, real_estate.bathroom, real_estate.availability_of_a_kitchen, real_estate.balcony, real_estate.number_of_storeys, wall_materials.wall_material_name, real_estate.windows_material, real_estate.new_building_resale, real_estate.communication_scheme, real_estate.infrastructure, real_estate.additionally 
        FROM wall_materials
        INNER JOIN real_estate ON real_estate.wall_material_id = wall_materials.id  
        INNER JOIN  adresses ON  real_estate.adress_id =  adresses.id 
        INNER JOIN  streets ON  adresses.street_id =  streets.id 
        INNER JOIN  cities ON  streets.city_id =  cities.id 
        INNER JOIN  countries ON  cities.country_id =  countries.id
        WHERE `status` = 'продаётся' AND real_estate.id = " . $_SESSION["realEstateID"] . ";";
    $result = $mysql->query($sql);
    $row = $result->fetch_array();
    echo "<span><b>Id:</b> " . $row['id']."</span><br>";
    $_SESSION['typeOfRealEstate'] = $row['type_of_real_estate'];
    echo "<input type='number' name='realEstateID' style='display: none;' value=" . $row['id'] . ">";
    echo "<span><b>Тип недвижимости:</b> " . $row['type_of_real_estate']." дом<br>";
    $_SESSION['realEstateArea'] = $row['area'];
    echo "<span><b>Площадь:</b> " . $row['area']." кв.м<br>";
    $_SESSION['realEstateCeilingHeight'] = $row['ceiling_height'];
    echo "<span><b>Высота потолков:</b> " . $row['ceiling_height']." м<br>";
    $_SESSION['realEstatePrice'] = $row['price'];
    echo "<span><b>Цена:</b> " . $row['price']." р.<br>";
    $_SESSION['realEstateConstructionYear'] = $row['year_of_construction'];
    echo "<span><b>Год постройки:</b> " . $row['year_of_construction']." г.<br>";
    $_SESSION['realEstateRepairType'] = $row['repair_type'];
    echo "<span><b>Тип ремонта:</b> " . $row['repair_type']."<br>";
    $_SESSION['realEstateRoomsNum'] = $row['number_of_rooms'];
    echo "<span><b>Количество комнат:</b> " . $row['number_of_rooms']."<br>";
    $_SESSION['realEstateFloor'] = $row['floor'];
    echo "<span><b>Этаж:</b> " . $row['floor']."<br>";
    $_SESSION['realEstateAdress'] = $row['adress_id'];
    echo "<span><b>Адрес:</b><br>";
    echo "<span>&nbsp;&nbsp;&nbsp;&nbsp<b>Страна:</b> " . $row['country_name']."<br>";
    echo "<span>&nbsp;&nbsp;&nbsp;&nbsp<b>Город:</b> " . $row['city_name']."<br>";
    echo "<span>&nbsp;&nbsp;&nbsp;&nbsp<b>Улица:</b> " . $row['street_name']."<br>";
    echo "<span>&nbsp;&nbsp;&nbsp;&nbsp<b>Номер дома:</b> " . $row['house_number']."<br>";
    echo "<span>&nbsp;&nbsp;&nbsp;&nbsp<b>Номер квартиры:</b> " . $row['apartment_number']."<br>";
    $id = $row['id'];
    echo "<span><b>Фото недвижимости:</b> ". "<img src='imageView.php?id=$id&column=real_estate_photos' class='img-fluid' style='width: 300px; height: 180px'>" ."<br>";
    echo "<span><b>Схема недвижимости:</b> " . "<img src='imageView.php?id=$id&column=real_estate_sheme' class='img-fluid' style='width: 200px; height: 180px'>" . "<br>";
    $_SESSION['realEstateBathroom'] = $row['bathroom'];
    echo "<span><b>Тип санузла:</b> " . $row['bathroom']."<br>";
    if($row['availability_of_a_kitchen'] == '1')
        $kitchen = "в наличии";
    else
        $kitchen = "остутствует";
    $_SESSION['realEstateKitchen'] = $row['availability_of_a_kitchen'];
    echo "<span><b>Наличие кухни:</b> " . $kitchen."<br>";
    $_SESSION['realEstateBalcony'] = $row['number_of_storeys'];
    echo "<span><b>Тип балкона:</b> " . $row['balcony']."<br>";
    $_SESSION['realEstateStorey'] = $row['number_of_storeys'];
    echo "<span><b>Этажность:</b> " . $row['number_of_storeys']." этаж<br>";
    $_SESSION['realEstateWallMaterial'] = $row['wall_material_id'];
    echo "<span><b>Материал стен:</b> " . $row['wall_material_name']."<br>";
    $_SESSION['realEstateWindowsMaterial'] = $row['windows_material'];
    echo "<span><b>Материал окон:</b> " . $row['windows_material']."<br>";
    $_SESSION['realEstateNewResale'] = $row['new_building_resale'];
    echo "<span><b>Новостройка/вторичка:</b> " . $row['new_building_resale']."<br>";
    echo "<span><b>Схема коммуникаций:</b> " . "<img src='imageView.php?id=$id&column=communication_scheme' class='img-fluid' style='width: 200px; height: 180px'>"."<br>";
    $_SESSION['realEstateInfrastructure'] = $row['infrastructure'];
    echo "<span><b>Инфраструктура:</b> " . $row['infrastructure']."<br>";
    $_SESSION['realEstateStatus'] = $row['additionally'];
    echo "<span><b>Дополнительно:</b> " . $row['additionally']."<br>";

    // echo "<form action='checkRealEstate.php'>";


    if ($_SESSION["userRole"] == 1) {
        echo "<button type='button' class='btn btn-success' style='width: 30%; margin-top: 7px; margin-bottom: 7px;' onclick='openEditForm();'>Редактировать</button>";
        echo "<form action='checkRealEstate.php' method='post'><button type='submit' name='isDeleteRealEstate' value='1' class='btn btn-danger' style='width: 30%; margin-left: 31%'>Удалить</button></form>";
    }
    else {
        $clientFavouritesSelectResult = $mysql->query("SELECT * FROM `client_favourites` WHERE client_id = '" . $_SESSION["userId"] . "' AND real_estate_id = '" . $_SESSION["realEstateID"] . "';");
        if ($clientFavouritesSelectResult->num_rows == 0)
            echo "<form action='checkRealEstate.php' method='post'><button type='submit' name='isInsertToFavourites' value='1' class='btn btn-success' style='width: 30%; margin-top: 7px; margin-bottom: 7px;' >Добавить в избранное</button></form>";
    }
    // echo "</form>"

?>
    <form action="checkRealEstate.php" id="editForm" style="display: none;" method="post">
    
    <label for="realEstateType" class="label">Тип недвижимости:</label>
    <select name="typeOfRealEstate" value="<?=$_SESSION['typeOfRealEstate']?>" class="form-control">
        <?php printSelectResultsForComboBox('type_of_real_estate');?>
    </select><br>
    
    <label for="realEstateArea" class="label">Площадь:</label>
    <input type="number" name="realEstateArea" value="<?=$_SESSION['realEstateArea']?>" class="form-control">
    
    <label for="realEstateCeilingHeight" class="label">Высота потолков:</label>
    <input type="number" name="realEstateCeilingHeight" value="<?=$_SESSION['realEstateCeilingHeight']?>" class="form-control">
    
    <label for="realEstatePrice" class="label">Цена</label>
    <input type="number" name="realEstatePrice" value="<?=$_SESSION['realEstatePrice']?>" class="form-control">

    <label for="realEstateConstructionYear" class="label">Год постройки:</label>
    <input type="number" name="realEstateConstructionYear" value="<?=$_SESSION['realEstateConstructionYear']?>" class="form-control">

    <label for="realEstateRepairType" class="label">Тип ремонта:</label>
    <select name="realEstateRepairType" value="<?=$_SESSION['realEstateRepairType']?>" class="form-control">
        <?php printSelectResultsForComboBox('repair_type');?>
    </select><br>

    <label for="realEstateRoomsNum" class="label">Количество комнат:</label>
    <input type="number" name="realEstateRoomsNum" value="<?=$_SESSION['realEstateRoomsNum']?>" class="form-control">

    <label for="realEstateFloor" class="label">Этаж:</label>
    <input type="number" name="realEstateFloor" value="<?=$_SESSION['realEstateFloor']?>" class="form-control">

    <label for="realEstateAdress" class="label">Адрес:</label>
    <select name="realEstateAdress" value="<?=$_SESSION['realEstateAdress']?>" class="form-control">
        <?php printSelectResultsForComboBox('adress_id');?>
    </select><br>

    <label for="realEstateBathroom" class="label">Тип санузла:</label>
    <select name="realEstateBathroom" value="<?=$_SESSION['realEstateBathroom']?>" class="form-control">
        <?php printSelectResultsForComboBox('bathroom');?>
    </select><br>

    <label for="realEstateKitchen" class="label">Наличие кухни::</label>
    <select name="realEstateKitchen" value="<?=$_SESSION['realEstateKitchen']?>" class="form-control">
        <?php printSelectResultsForComboBox('availability_of_a_kitchen');?>
    </select><br>

    <label for="realEstateBalcony" class="label">Тип балкона:</label>
    <select name="realEstateBalcony" value="<?=$_SESSION['realEstateBalcony']?>" class="form-control">
        <?php printSelectResultsForComboBox('balcony');?>
    </select><br>

    <label for="realEstateStorey" class="label">Этажность:</label>
    <input type="number" name="realEstateStorey" value="<?=$_SESSION['realEstateStorey']?>" class="form-control">

    <label for="realEstateWallMaterial" class="label">Материал стен:</label>
    <select name="realEstateWallMaterial" value="<?=$_SESSION['realEstateWallMaterial']?>" class="form-control">
        <?php printSelectResultsForComboBox('wall_material_id');?>
    </select><br>

    <label for="realEstateWindowsMaterial" class="label">Материал окон:</label>
    <select name="realEstateWindowsMaterial" value="<?=$_SESSION['realEstateWindowsMaterial']?>" class="form-control">
        <?php printSelectResultsForComboBox('windows_material');?>
    </select><br>

    <label for="realEstateNewResale" class="label">Новостройка/вторичка:</label>
    <select name="realEstateNewResale" value="<?=$_SESSION['realEstateNewResale']?>" class="form-control">
        <?php printSelectResultsForComboBox('new_building_resale');?>
    </select><br>

    <label for="realEstateInfrastructure" class="label">Инфраструктура:</label>
    <textarea name="realEstateInfrastructure" class="form-control"></textarea>

    <!-- value="<?=$_SESSION['realEstateInfrastructure']?>" -->

    <label for="realEstateAdditionally" class="label">Дополнительно:</label>
    <textarea name="realEstateAdditionally" class="form-control"></textarea>

    <!-- value="<?php $_SESSION['realEstateAdditionally']?>" -->

    <label for="realEstateStatus" class="label">Статус:</label>
    <select name="realEstateStatus" value="<?=$_SESSION['realEstateStatus']?>" placeholder="Введите логин" class="form-control">
        <?php printSelectResultsForComboBox('status');?>
    </select><br>

    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>


    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; left: 25%;">Сохранить</button>
    <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button>
</form>

<?php
    if (count($_FILES) > 0) {
        if (is_uploaded_file($_FILES['realEstatePhoto']['tmp_name'])) {
            
            $imgData = addslashes(file_get_contents($_FILES['realEstatePhoto']['tmp_name']));
            
            $sql = "UPDATE `real_estate` SET `real_estate_photos` = '$imgData' WHERE `id` = " . $_SESSION["realEstateID"] . ";";
            $result = $mysql->query($sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . $mysql->error);
                    }
        if (is_uploaded_file($_FILES['realEstateScheme']['tmp_name'])) {
            
            $imgData = addslashes(file_get_contents($_FILES['realEstateScheme']['tmp_name']));
            
            $sql = "UPDATE `real_estate` SET `real_estate_sheme` = '$imgData' WHERE `id` = " . $_SESSION["realEstateID"] . ";";
            $result = $mysql->query($sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . $mysql->error);
        }
        if (is_uploaded_file($_FILES['realEstateCommunication']['tmp_name'])) {
            
            $imgData = addslashes(file_get_contents($_FILES['realEstateCommunication']['tmp_name']));
            
            $sql = "UPDATE `real_estate` SET `communication_scheme` = '$imgData' WHERE `id` = " . $_SESSION["realEstateID"] . ";";
            $result = $mysql->query($sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . $mysql->error);
        }
    }
?>

<form action="" enctype="multipart/form-data" id="uploadImageForm" style="display: none; margin-top: 5em;" method="post">
    
    <label for="realEstatePhoto" class="label">Фото недвижимости:</label> <!-- фото --> 
    <input type="file" name="realEstatePhoto" class="form-control">

    <label for="realEstateScheme" class="label">Схема недвижимости:</label> <!-- фото --> 
    <input type="file" name="realEstateScheme" class="form-control">
    
    <label for="realEstateCommunication" class="label">Схема коммуникаций:</label> <!-- фото --> 
    <input type="file" name="realEstateCommunication" class="form-control">

    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; margin-top: 20px; left: 25%;">Загрузить фотографии</button>
</form>
            </div>
        </div>
    </div>

</div>
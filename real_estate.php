<?php
    session_start();

    $pageTitle = "Недвижимость";

    require_once "db.php";

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

    <h1 class="text-center">Список недвижимости</h1>
        <div class="container">
        <?php
            if($_SESSION["userRole"] == 1)
                echo "<a href='createRealEstate.php' class='btn btn-success' style='width: 30%; margin-bottom: 20px; margin-left: 35%'>Создать объект недвижимости</a>";
        ?>
            <a href="#editForm" class='btn btn-success' id='btnOpenCreateForm' onclick='openEditForm();' style='width: 30%; margin-bottom: 20px;' href>Отфильтровать</a>
            <div class="row">
        
<?php
function printSelectResults($result) {
    if($result->num_rows > 0) {           
        while($row = $result->fetch_array()) {
            echo "<div class='col-lg-4 col-md-4 col-sm-12 element'><form action='realEstateElement.php' method='post'>";
            echo "Id: " . $row['id']."<br>";
            echo "<input type='number' name='realEstateID' style='display: none;' value=" . $row['id'] . ">";
            $id = $row['id'];
            echo "<img src='imageView.php?id=$id&column=real_estate_photos' class='img-fluid' style='width: 300px; height: 180px'>" ."<br>";
            echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Перейти</button>";
            echo "</form></div>";
        }
    }
}
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                if (!isset($_POST["isFiltred"])) {
                    $result = $mysql->query("SELECT real_estate.id, real_estate.type_of_real_estate,
                    real_estate.repair_type, real_estate.bathroom, real_estate.availability_of_a_kitchen,
                    real_estate.balcony, real_estate.wall_material_id, wall_materials.wall_material_name,
                    real_estate.windows_material, real_estate.new_building_resale,
                    real_estate.real_estate_photos
                    FROM `real_estate` INNER JOIN `wall_materials`
                    ON real_estate.wall_material_id = wall_materials.id
                    WHERE real_estate.status = 'продаётся'
                    ORDER BY real_estate.id;");
                }
                else {
                    $filtrResult = "SELECT real_estate.id, real_estate.type_of_real_estate,
                        real_estate.repair_type, real_estate.bathroom, real_estate.availability_of_a_kitchen,
                        real_estate.balcony, real_estate.wall_material_id, wall_materials.wall_material_name,
                        real_estate.windows_material, real_estate.new_building_resale,
                        real_estate.real_estate_photos
                        FROM `real_estate` INNER JOIN `wall_materials`
                        ON real_estate.wall_material_id = wall_materials.id
                        WHERE ";
    
                    if(isset($_POST['typeOfRealEstate']) && $_POST['typeOfRealEstate'] != '-') {
                        $filtrResult = $filtrResult . "real_estate.type_of_real_estate = '" . $_POST['typeOfRealEstate'] . "' And ";
                    }
                    if(isset($_POST['realEstateRepairType']) && $_POST['realEstateRepairType'] != '-'){
                        $filtrResult = $filtrResult . "real_estate.repair_type = '" . $_POST['realEstateRepairType'] . "' And ";
                    }
                    if(isset($_POST['realEstateBathroom']) && $_POST['realEstateBathroom'] != '-'){
                        $filtrResult = $filtrResult . "real_estate.bathroom = '" . $_POST['realEstateBathroom'] . "' And ";
                    }
                    if(isset($_POST['realEstateKitchen']) && $_POST['realEstateKitchen'] != '-'){
                        $filtrResult = $filtrResult . "real_estate.availability_of_a_kitchen = '" . $_POST['realEstateKitchen'] . "' And ";
                    }
                    if(isset($_POST['realEstateBalcony']) && $_POST['realEstateBalcony'] != '-'){
                        $filtrResult = $filtrResult . "real_estate.balcony = '" . $_POST['realEstateBalcony'] . "' And ";
                    }
                    if(isset($_POST['realEstateWallMaterial']) && $_POST['realEstateWallMaterial'] != '-'){
                        $filtrResult = $filtrResult . "real_estate.wall_material_id = '" . $_POST['realEstateWallMaterial'] . "' And ";
                    }
                    if(isset($_POST['realEstateWindowsMaterial']) && $_POST['realEstateWindowsMaterial'] != '-'){
                        $filtrResult = $filtrResult . "real_estate.windows_material = '" . $_POST['realEstateWindowsMaterial'] . "' And ";
                    }
                    if(isset($_POST['realEstateNewResale']) && $_POST['realEstateNewResale'] != '-'){
                        $filtrResult = $filtrResult . "real_estate.new_building_resale = '" . $_POST['realEstateNewResale'] . "' And ";
                    }

                    $filtrResult = $filtrResult . "real_estate.status = 'продаётся' ORDER BY real_estate." .  $_POST['sortValue'] . ";";
                    $result = $mysql->query($filtrResult);
                }
            printSelectResults($result);
            $sortResult = $mysql->query("SHOW COLUMNS FROM `real_estate`;");
            }
?>
            </div>
    <form action="" id="editForm" style="display: none;" method="post">
    
    <label for="realEstateType" class="label">Тип недвижимости:</label>
    <select name="typeOfRealEstate" value="<?=$_SESSION['typeOfRealEstate']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('type_of_real_estate');?>
    </select><br>
    
    <label for="realEstateRepairType" class="label">Тип ремонта:</label>
    <select name="realEstateRepairType" value="<?=$_SESSION['realEstateRepairType']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('repair_type');?>
    </select><br>

    <label for="realEstateBathroom" class="label">Тип санузла:</label>
    <select name="realEstateBathroom" value="<?=$_SESSION['realEstateBathroom']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('bathroom');?>
    </select><br>

    <label for="realEstateKitchen" class="label">Наличие кухни:</label>
    <select name="realEstateKitchen" value="<?=$_SESSION['realEstateKitchen']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('availability_of_a_kitchen');?>
    </select><br>

    <label for="realEstateBalcony" class="label">Тип балкона:</label>
    <select name="realEstateBalcony" value="<?=$_SESSION['realEstateBalcony']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('balcony');?>
    </select><br>
    
    <label for="realEstateWallMaterial" class="label">Материал стен:</label>
    <select name="realEstateWallMaterial" value="<?=$_SESSION['realEstateWallMaterial']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('wall_material_id');?>
    </select><br>

    <label for="realEstateWindowsMaterial" class="label">Материал окон:</label>
    <select name="realEstateWindowsMaterial" value="<?=$_SESSION['realEstateWindowsMaterial']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('windows_material');?>
    </select><br>

    <label for="realEstateNewResale" class="label">Новостройка/вторичка:</label>
    <select name="realEstateNewResale" value="<?=$_SESSION['realEstateNewResale']?>" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('new_building_resale');?>
    </select><br>

    <label for="sortValue" class="label">Сортировка по:</label>
    <select name="sortValue" value="<?=$_SESSION['sortValue']?>" placeholder="Введите логин" class="form-control">
        <?php 
            if($sortResult->num_rows > 0) {           
                while($row = $sortResult->fetch_assoc()) {
                    echo "<option>" . $row['Field'] . "</option><br>";
                }
            }
        ?>
    </select><br>

    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>


    <button type="submit" name="isFiltred" value="1" class="btn btn-success" style="width: 30%; position:absolute; left: 25%;">Применить</button>
    <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button>
</form>
        </div>
    </div>
<?php
    include_once "footer.php";
?>
</div>

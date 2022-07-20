<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Города";

    require_once "rieltor_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteCity"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteCity"]) && $_POST["isDeleteCity"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $cityId = htmlspecialchars(trim($_POST["cityID"]));
            $mysql->query("DELETE FROM `cities` WHERE `id` = '$cityId';");
        }
    }

    if(isset($_POST["cityID"])) {
        $cityId = $_POST["cityID"];
        $cityResult = $mysql->query("SELECT `country_id` FROM `cities` WHERE id = '" . $_POST["cityID"] . "';");
        $countryId = printSelectRow($cityResult, 'country_id');
        $cityResult = $mysql->query("SELECT `city_name` FROM `cities` WHERE id = '" . $_POST["cityID"] . "';");
        $cityName = printSelectRow($cityResult, 'city_name');
        $cityResult = $mysql->query("SELECT `description` FROM `cities` WHERE id = '" . $_POST["cityID"] . "';");
        $cityDescription = printSelectRow($cityResult, 'description');
        
        $countryResult1 = $mysql->query("SELECT `id` FROM `cities`;");
        
    }

    $gridResult = $mysql->query("SELECT * FROM `cities`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='cityID' style='display: none;' value=" . $row['id'] . ">";
                echo "Id: " . $row['id']."<br>";
                echo "Id страны: " . $row['country_id']."<br>";
                echo "Название: " . $row['city_name']."<br>";
                echo "Описание: " . $row['description']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteCity' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
                echo "</form></div>";
            }
        }
    }
    function printSelectRow($result, $columnName) {
        $element = "";
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {   
                $element = $row[$columnName];
            }
        }
        return $element;
    }
    function printSelectResultsForComboBox($result, $column) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<option>" . $row[$column] . "</option><br>";
            }
        }
    }
?>

<div class="description container mt-2">
<h1 class='text-center gridH'>Список городов</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Добавить город</button>

<form action="checkCities.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='cityID' value='<?=$cityId?>' style='display: none;' value="display: none">
    <label for="countryId" class="label">Id страны:</label>
    <select name='countryId' value="<?=$countryId?>" class='form-control'>";
        <?php printSelectResultsForComboBox($countryResult1, 'id');?>
    </select><br>
    <label for="cityName" class="label">Название:</label>
    <input type="text" name="cityName" value="<?=$cityName?>" class="form-control" required>
    <label for="cityDescription" class="label">Описание:</label>
    <textarea name="cityDescription" value="<?=$cityDescription?>" class="form-control"></textarea>
    <div class="text-danger"><?=$_SESSION['cityTextError']?></div><br>
    <button type="submit" class="btn btn-success">Сохранить</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeEditForm();">Закрыть</button>
</form>

<!-- id="grid" -->
<div class='container  mt-2' >
    <div class='container'>
        <div class='row'>
            <?=printSelectResults($gridResult);?>
        </div>
    </div>
</div>

<form action="checkCities.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="countryId" class="label">Id страны:</label>
    <select name='countryId' class='form-control'>";
        <?php 
            $countryResult2 = $mysql->query("SELECT `id` FROM `countries`;");
            printSelectResultsForComboBox($countryResult2, 'id');
        ?>
    </select><br>
    <label for="cityName" class="label">Название:</label>
    <input type="text" name="cityName" class="form-control" required>
    <label for="cityDescription" class="label">Описание:</label>
    <textarea name="cityDescription" class="form-control"></textarea>
    <div class="text-danger"><?=$_SESSION['cityTextError']?></div><br>
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>

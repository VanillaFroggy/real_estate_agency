<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Улицы";

    require_once "rieltor_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteStreet"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteStreet"]) && $_POST["isDeleteStreet"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $streetId = htmlspecialchars(trim($_POST["streetID"]));
            $mysql->query("DELETE FROM `streets` WHERE `id` = '$streetId';");
        }
    }

    if(isset($_POST["streetID"])) {
        $streetId = $_POST["streetID"];
        $streetResult = $mysql->query("SELECT `city_id` FROM `streets` WHERE id = '" . $_POST["streetID"] . "';");
        $cityId = printSelectRow($streetResult, 'city_id');
        $streetResult = $mysql->query("SELECT `street_name` FROM `streets` WHERE id = '" . $_POST["streetID"] . "';");
        $streetName = printSelectRow($streetResult, 'street_name');
        $streetResult = $mysql->query("SELECT `description` FROM `streets` WHERE id = '" . $_POST["streetID"] . "';");
        $streetDescription = printSelectRow($streetResult, 'description');
        
        $cityResult1 = $mysql->query("SELECT `id` FROM `cities`;");
        
    }

    $gridResult = $mysql->query("SELECT * FROM `streets`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='streetID' style='display: none;' value=" . $row['id'] . ">";
                echo "Id: " . $row['id']."<br>";
                echo "Id города: " . $row['city_id']."<br>";
                echo "Название: " . $row['street_name']."<br>";
                echo "Описание: " . $row['description']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteStreet' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
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
<h1 class='text-center gridH'>Список улиц</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Добавить улицу</button>

<form action="checkStreets.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='streetID' value='<?=$streetId?>' style='display: none;' value="display: none">
    <label for="cityId" class="label">Id города:</label>
    <select name='cityId' value="<?=$cityId?>" class='form-control'>";
        <?php printSelectResultsForComboBox($cityResult1, 'id');?>
    </select><br>
    <label for="streetName" class="label">Название:</label>
    <input type="text" name="streetName" value="<?=$streetName?>" class="form-control" required>
    <label for="streetDescription" class="label">Описание:</label>
    <textarea name="streetDescription" value="<?=$streetDescription?>" class="form-control"></textarea>
    <div class="text-danger"><?=$_SESSION['streetTextError']?></div><br>
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

<form action="checkStreets.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="cityId" class="label">Id города:</label>
    <select name='cityId' class='form-control'>";
        <?php 
            $cityResult2 = $mysql->query("SELECT `id` FROM `cities`;");
            printSelectResultsForComboBox($cityResult2, 'id');
        ?>
    </select><br>
    <label for="streetName" class="label">Название:</label>
    <input type="text" name="streetName" class="form-control" required>
    <label for="streetDescription" class="label">Описание:</label>
    <textarea name="streetDescription" class="form-control"></textarea>
    <div class="text-danger"><?=$_SESSION['streetTextError']?></div><br>
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>

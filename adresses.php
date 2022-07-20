<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Адреса";

    require_once "rieltor_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteAdress"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteAdress"]) && $_POST["isDeleteAdress"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $adressId = htmlspecialchars(trim($_POST["adressID"]));
            $mysql->query("DELETE FROM `adresses` WHERE `id` = '$adressId';");
        }
    }

    if(isset($_POST["adressID"])) {
        $adressId = $_POST["adressID"];
        $adressResult = $mysql->query("SELECT `street_id` FROM `adresses` WHERE id = '" . $_POST["adressID"] . "';");
        $streetId = printSelectRow($adressResult, 'street_id');
        $adressResult = $mysql->query("SELECT `house_number` FROM `adresses` WHERE id = '" . $_POST["adressID"] . "';");
        $houseNumber = printSelectRow($adressResult, 'house_number');
        $adressResult = $mysql->query("SELECT `apartment_number` FROM `adresses` WHERE id = '" . $_POST["adressID"] . "';");
        $apartmentNumber = printSelectRow($adressResult, 'apartment_number');
        
        $streetResult1 = $mysql->query("SELECT `id` FROM `streets`;");
        
    }

    $gridResult = $mysql->query("SELECT * FROM `adresses`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='adressID' style='display: none;' value=" . $row['id'] . ">";
                echo "Id: " . $row['id']."<br>";
                echo "Id улицы: " . $row['street_id']."<br>";
                echo "Номер дома: " . $row['house_number']."<br>";
                echo "Номер квартиры: " . $row['apartment_number']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteAdress' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
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
<h1 class='text-center gridH'>Список адресов</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Добавить адресс</button>

<form action="checkAdresses.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='adressID' value='<?=$adressId?>' style='display: none;' value="display: none">
    <label for="streetId" class="label">Id улицы:</label>
    <select name='streetId' value="<?=$streetId?>" class='form-control'>";
        <?php printSelectResultsForComboBox($streetResult1, 'id');?>
    </select><br>
    <label for="houseNumber" class="label">Номер дома:</label>
    <input type="number" name="houseNumber" value="<?=$houseNumber?>" class="form-control" required>
    <label for="apartmentNumber" class="label">Номер квартиры:</label>
    <input type="number" name="apartmentNumber" value="<?=$apartmentNumber?>" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>
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

<form action="checkAdresses.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="streetId" class="label">Id улицы:</label>
    <select name='streetId' class='form-control'>";
        <?php 
            $streetResult2 = $mysql->query("SELECT `id` FROM `streets`;");
            printSelectResultsForComboBox($streetResult2, 'id');
        ?>
    </select><br>
    <label for="houseNumber" class="label">Номер дома:</label>
    <input type="number" name="houseNumber" class="form-control" required>
    <label for="apartmentNumber" class="label">Номер квартиры:</label>
    <input type="number" name="apartmentNumber" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>

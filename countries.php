<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Страны";

    require_once "rieltor_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteCountry"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteCountry"]) && $_POST["isDeleteCountry"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $countryId = htmlspecialchars(trim($_POST["countryID"]));
            $mysql->query("DELETE FROM `countries` WHERE `id` = '$countryId';");
        }
    }

    if(isset($_POST["countryID"])) {
        $countryId = $_POST["countryID"];
        $countryResult = $mysql->query("SELECT `country_name` FROM `countries` WHERE id = '" . $_POST["countryID"] . "';");
        $countryName = printSelectRow($countryResult, 'country_name');
        $countryResult = $mysql->query("SELECT `description` FROM `countries` WHERE id = '" . $_POST["countryID"] . "';");
        $countryDescription = printSelectRow($countryResult, 'description');        
    }

    $gridResult = $mysql->query("SELECT * FROM `countries`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='countryID' style='display: none;' value=" . $row['id'] . ">";
                echo "Id: " . $row['id']."<br>";
                echo "Название: " . $row['country_name']."<br>";
                echo "Описание: " . $row['description']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteCountry' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
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
?>

<div class="description container mt-2">
<h1 class='text-center gridH'>Список стран</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Добавить страну</button>

<form action="checkCountries.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='countryID' value='<?=$countryId?>' style='display: none;' value="display: none">
    <label for="countryName" class="label">Название:</label>
    <input type="text" name="countryName" value="<?=$countryName?>" class="form-control" required>
    <label for="countryDescription" class="label">Описание:</label>
    <textarea name="countryDescription" value="<?=$countryDescription?>" class="form-control"></textarea>
    <div class="text-danger"><?=$_SESSION['countryTextError']?></div><br>
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

<form action="checkCountries.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="countryName" class="label">Название:</label>
    <input type="text" name="countryName" class="form-control" required>
    <label for="countryDescription" class="label">Описание:</label>
    <textarea name="countryDescription" class="form-control"></textarea>
    <div class="text-danger"><?=$_SESSION['countryTextError']?></div><br>
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>

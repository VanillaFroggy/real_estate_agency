<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Материалы стен";

    require_once "rieltor_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteWallMaterial"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteWallMaterial"]) && $_POST["isDeleteWallMaterial"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $wallMaterialId = htmlspecialchars(trim($_POST["wallMaterialID"]));
            $mysql->query("DELETE FROM `wall_materials` WHERE `id` = '$wallMaterialId';");
        }
    }

    if(isset($_POST["wallMaterialID"])) {
        $materialResult = $mysql->query("SELECT `wall_material_name` FROM `wall_materials` WHERE id = '" . $_POST["wallMaterialID"] . "';");
        $materialId = $_POST["wallMaterialID"];
        $materialName = printSelectRow($materialResult, 'wall_material_name');
        $materialResult = $mysql->query("SELECT `description` FROM `wall_materials` WHERE id = '" . $_POST["wallMaterialID"] . "';");
        $materialDescription = printSelectRow($materialResult, 'description');
    }

    $gridResult = $mysql->query("SELECT * FROM `wall_materials`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='wallMaterialID' style='display: none;' value=" . $row['id'] . ">";
                echo "id материала: " . $row['id']."<br>";
                echo "Имя материала: " . $row['wall_material_name']."<br>";
                echo "Описание: " . $row['description']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteWallMaterial' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
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
<h1 class='text-center gridH'>Список материалов</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Внести материал</button>

<form action="checkWallMaterials.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <label for="wallMaterialName" class="label">Название материала:</label>
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='wallMaterialID' value='<?=$materialId?>' style='display: none;' value="display: none">
    <input type="text" name="wallMaterialName" value="<?=$materialName?>" class="form-control">
    <label for="materialDescription" class="label">Описание:</label>
    <textarea name="materialDescription" value="<?=$materialDescription?>"  class="form-control"></textarea>        
    <button type="submit" class="btn btn-success">Сохранить</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeEditForm();">Закрыть</button>
</form>

<div class='container  mt-2' id="grid">
    <div class='container'>
        <div class='row'>
            <?=printSelectResults($gridResult);?>
        </div>
    </div>
</div>

<form action="checkWallMaterials.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="wallMaterialName" class="label">Название материала:</label>
    <input type="text" name="wallMaterialName" class="form-control">
    <label for="materialDescription" class="label">Описание:</label>
    <textarea name="materialDescription" class="form-control"></textarea>        
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>

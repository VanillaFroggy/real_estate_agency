<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Статусы заявок";

    require_once "rieltor_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteRequestStatus"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteRequestStatus"]) && $_POST["isDeleteRequestStatus"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $requestStatusId = htmlspecialchars(trim($_POST["requestStatusID"]));
            $mysql->query("DELETE FROM `request_status` WHERE `id` = '$requestStatusId';");
        }
    }

    if(isset($_POST["requestStatusID"])) {
        $requestStatusId = $_POST["requestStatusID"];
        $requestStatusResult = $mysql->query("SELECT `request_status_name` FROM `request_status` WHERE id = '" . $_POST["requestStatusID"] . "';");
        $requestStatusName = printSelectRow($requestStatusResult, 'request_status_name');
    }

    $gridResult = $mysql->query("SELECT * FROM `request_status`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='requestStatusID' style='display: none;' value=" . $row['id'] . ">";
                echo "Id: " . $row['id']."<br>";
                echo "Текст статуса: " . $row['request_status_name']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteRequestStatus' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
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
<h1 class='text-center gridH'>Список статусов заявок</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Добавить статус заявки</button>

<form action="checkRequestStatus.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='requestStatusID' value='<?=$requestStatusId?>' style='display: none;' value="display: none">
    <label for="requestStatusName" class="label">Текст статуса:</label>
    <input type="text" name="requestStatusName" value="<?=$requestStatusName?>" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['requestStatusTextError']?></div><br>
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

<form action="checkRequestStatus.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="requestStatusName" class="label">Текст статуса:</label>
    <input type="text" name="requestStatusName" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['requestStatusTextError']?></div><br>
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>

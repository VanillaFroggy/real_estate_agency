<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Клиенты";

    require_once "rieltor_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteClient"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteClient"]) && $_POST["isDeleteClient"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $clientId = htmlspecialchars(trim($_POST["clientID"]));
            $mysql->query("DELETE FROM `clients` WHERE `id` = '$clientId';");
        }
    }

    if(isset($_POST["clientID"])) {
        $clientResult = $mysql->query("SELECT `surname` FROM `clients` WHERE id = '" . $_POST["clientID"] . "';");
        $clientId = $_POST["clientID"];
        $clientSurname = printSelectRow($clientResult, 'surname');
        $clientResult = $mysql->query("SELECT `firstname` FROM `clients` WHERE id = '" . $_POST["clientID"] . "';");
        $clientFirstname = printSelectRow($clientResult, 'firstname');
        $clientResult = $mysql->query("SELECT `patronymic` FROM `clients` WHERE id = '" . $_POST["clientID"] . "';");
        $clientPatronymic = printSelectRow($clientResult, 'patronymic');
        $clientResult = $mysql->query("SELECT `phonenumber` FROM `clients` WHERE id = '" . $_POST["clientID"] . "';");
        $clientPhone = printSelectRow($clientResult, 'phonenumber');
        $clientResult = $mysql->query("SELECT `login` FROM `clients` WHERE id = '" . $_POST["clientID"] . "';");
        $clientLogin = printSelectRow($clientResult, 'login');
        $clientResult = $mysql->query("SELECT `password` FROM `clients` WHERE id = '" . $_POST["clientID"] . "';");
        $clientPassword = printSelectRow($clientResult, 'password');
    }

    $gridResult = $mysql->query("SELECT `id`, `surname`, `firstname`, `patronymic`, `phonenumber`, `login`, `password` FROM `clients`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='clientID' style='display: none;' value=" . $row['id'] . ">";
                echo "id: " . $row['id']."<br>";
                echo "Фамилия: " . $row['surname']."<br>";
                echo "Имя: " . $row['firstname']."<br>";
                echo "Отчество: " . $row['patronymic']."<br>";
                echo "Номер телефона: " . $row['phonenumber']."<br>";
                echo "Логин: " . $row['login']."<br>";
                echo "Пароль: " . $row['password']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteClient' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
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
<h1 class='text-center gridH'>Список клиентов</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Зарегестрировать клиента</button>

<form action="checkClients.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='clientID' value='<?=$clientId?>' style='display: none;' value="display: none">
    <label for="clientSurname" class="label">Фамилия:</label>
    <input type="text" name="clientSurname" value="<?=$clientSurname?>" class="form-control" required>
    <label for="clientFirstname" class="label">Имя:</label>
    <input type="text" name="clientFirstname" value="<?=$clientFirstname?>" class="form-control" required>
    <label for="clientPatronymic" class="label">Отчество:</label>
    <input type="text" name="clientPatronymic" value="<?=$clientPatronymic?>" class="form-control">
    <label for="clientPhone" class="label">Номер телефона:</label>
    <input type="number" name="clientPhone" value="<?=$clientPhone?>" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['clientPhoneError']?></div><br>
    <label for="clientLogin" class="label">Логин:</label>
    <input type="text" name="clientLogin" value="<?=$clientLogin?>" class="form-control" required>
    <label for="clientPassword" class="label">Пароль:</label>
    <input type="password" name="clientPassword" value="<?=$clientPassword?>"  class="form-control" required>    
    <div class="text-danger"><?=$_SESSION['clientTextError']?></div><br>
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

<form action="checkClients.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="clientSurname" class="label">Фамилия:</label>
    <input type="text" name="clientSurname" class="form-control" required>
    <label for="clientFirstname" class="label">Имя:</label>
    <input type="text" name="clientFirstname" class="form-control" required>
    <label for="clientPatronymic" class="label">Отчество:</label>
    <input type="text" name="clientPatronymic" class="form-control">
    <label for="clientPhone" class="label">Номер телефона:</label>
    <input type="number" name="clientPhone" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['clientPhoneError']?></div><br>
    <label for="clientLogin" class="label">Логин:</label>
    <input type="text" name="clientLogin" class="form-control" required>
    <label for="clientPassword" class="label">Пароль:</label>
    <input type="password" name="clientPassword"  class="form-control" required>    
    <div class="text-danger"><?=$_SESSION['clientTextError']?></div><br>
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>

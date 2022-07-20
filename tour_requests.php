<?php
    session_start();

    require_once "db.php";
    
    $pageTitle = "Личный кабинет";
    $userId = $_SESSION["userId"];

    if($_SESSION["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
        $_SESSION["isEditForm"] = 0;
    }

    if($_SESSION["isCreateForm"] == '1') {
        $_SESSION["isCreateForm"] = 0;
    }
    
    if($_SESSION["userRole"] == 1) {
        require_once "rieltor_header.php";
        $humanId = 'rieltor_id';
    }
    else {
        require_once "client_header.php";
        $humanId = 'client_id';
    }
    
    if($mysql->connect_error) {
        echo "Error Number: ". $mysqsl->connect_errno."<br>";
        echo "Error: " . $mysql->connect_error;
    }
    else {
        if($_SESSION["userRole"] == 2) {
            $clientsColumn = 'surname';
            $clientsResult = $mysql->query("SELECT $clientsColumn FROM `clients` WHERE `id` = $userId;");
        }
        $realEstateColumn = 'id';
        $realEstateResult = $mysql->query("SELECT $realEstateColumn FROM `real_estate` WHERE `status` = 'продаётся';");
        $requestColumn = 'request_status_name';
        $requestResult = $mysql->query("SELECT $requestColumn FROM `request_status`;");
        $rieltorsColumn = 'surname';
        $rieltorsResult = $mysql->query("SELECT $rieltorsColumn FROM `rieltors`;");
        $rieltorsResultForEditForm = $mysql->query("SELECT $rieltorsColumn FROM `rieltors`;");
        $gridResult = $mysql->query("SELECT tour_requests.id, clients.surname AS clientSurname, rieltors.surname AS rieltorSurname, tour_requests.real_estate_id, tour_requests.meeting_date, tour_requests.tour_time, request_status.request_status_name FROM clients
        INNER JOIN tour_requests ON clients.id = tour_requests.client_id
        JOIN rieltors ON tour_requests.rieltor_id = rieltors.id
        JOIN request_status ON tour_requests.request_status_id = request_status.id
        WHERE $humanId = $userId;");
        $tourResult = $mysql->query("SELECT tour_requests.id, clients.surname AS clientSurname, rieltors.surname AS rieltorSurname, tour_requests.real_estate_id, tour_requests.meeting_date, tour_requests.tour_time, request_status.request_status_name FROM clients
        INNER JOIN tour_requests ON clients.id = tour_requests.client_id
        JOIN rieltors ON tour_requests.rieltor_id = rieltors.id
        JOIN request_status ON tour_requests.request_status_id = request_status.id;");
    }
    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element'><form action='check_tour_requests.php' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='tourRequestID' style='display: none;' value=" . $row['id'] . ">";
                echo "id заявки: " . $row['id']."<br>";
                echo "Клиент: " . $row['clientSurname']."<br>";
                echo "Риелтор: " . $row['rieltorSurname']."<br>";
                echo "id недвижимости: " . $row['real_estate_id']."<br>";
                echo "Дата встречи: " . $row['meeting_date']."<br>";
                echo "Время тура: " . $row['tour_time']." ч. <br>";
                echo "Статус заявки: " . $row['request_status_name']."<br>";
                if($row['request_status_name'] != "закрыта" && $_SESSION['userRole'] == 1) {
                    echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                    echo "<button type='submit' name='isDeleteTourRequest' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
                }
                echo "</form></div>";
            }
        }
    }
    function printSelectResultsForComboBox($result, $column) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<option>" . $row[$column] . "</option><br>";
            }
        }
    }
    function printSelectColumn($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                if($row["id"] == $_SESSION["tourRequestID"]) {
                    echo "<label for='clientLastname' class='label'>Клиент:</label> ";    
                    echo "<span name='clientLastname'> " . $row['clientSurname'] . "</span><br>";
                    echo "<label for='rieltorLastname' class='label'>Риелтор:</label> ";
                    echo "<span name='rieltorLastname'> " . $row['rieltorSurname'] . "</span><br>";
                    echo "<label for='realEstateId' class='label'>Id недвижимости:</label>";
                    echo "<span name='realEstateId'> " . $row["real_estate_id"] . "</span><br>";
                    $_SESSION["dateTime"] = $row["meeting_date"];
                    $_SESSION["tourTime"] = $row["tour_time"];
                    $_SESSION["requestName"] = $row["request_status_name"];
                }
            }
        }
    }
    function printSelectClientName($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {   
                echo " " . $row['surname'];
            }
        }
    }
?>
<div class="description container mt-2">
    <h1 class='text-center gridH'>Профиль</h1>
    <?php require_once "profile.php"?>
    <h1 class='text-center gridH'>Заявки</h1>
    <?php
        if($_SESSION["userRole"] == 2)
            echo "<button type='button' class='btn btn-success' id='btnOpenCreateForm' onclick='openCreateForm();'>Создать заявку</button>";
    ?>
    <form action="check_tour_requests.php" id="createForm" method="post">
        <input type='number' name='isCreateForm' value='1' style='display: none;'>
        <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
        <label for="clientLastname" class="label">Клиент:</label>
        <input type="text" name="clientLastname" value="<?=printSelectClientName($clientsResult);?>" placeholder="Введите свою фамилию" class="form-control" readonly>
        <label for="rieltorLastname" class="label">Риелтор:</label>
        <select name="rieltorLastname" placeholder="Введите фамилию риелтора" class="form-control"><?php printSelectResultsForComboBox($rieltorsResult, $rieltorsColumn)?></select><br>
        <label for='realEstateId' class='label'>Id недвижимости:</label>
        <select name='realEstateId' placeholder='Id недвижимости' value="<?=$_SESSION['realEstateId']?>" class='form-control'>";
            <?php printSelectResultsForComboBox($realEstateResult, $realEstateColumn);?>
        </select><br>
        <label for="dateTime" class="label">Дата и время встречи:</label>
        <input type="datetime-local" name="dateTime" value="<?=$_SESSION['dateTime']?>" placeholder="Введите дату и время встречи" class="form-control">
        <div class="text-danger"><?=$_SESSION['errorDateTime']?></div><br>
        <label for="tourTime" class="label">Длительность экскурсии (в часах):</label>
        <input type="number" name="tourTime" value="<?=$_SESSION['tourTime']?>" placeholder="Введите, какой длительности экскурсию хотели бы (в часах)" class="form-control">
        <div class="text-danger"><?=$_SESSION['errorTourTime']?></div><br>
        <button type="submit" class="btn btn-success">Отправить</button>
        <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
    </form>
    
    <form action="check_edit_tour_request.php" id="editForm" style="<?=$editFormStatus?>" method="post">
        <?=printSelectColumn($tourResult)?>
        <label for="dateTime" class="label">Дата и время встречи:</label>
        <input type="datetime-local" name="dateTime" value="<?=$_SESSION['dateTime']?>" placeholder="Введите дату и время встречи" class="form-control">
        <div class="text-danger"><?=$_SESSION['errorDateTime']?></div><br>
        <label for="tourTime" class="label">Длительность экскурсии:</label>
        <input type="number" name="tourTime" value="<?=$_SESSION['tourTime']?>" placeholder="Введите, какой длительности экскурсию хотели бы (в часах)" class="form-control">
        <div class="text-danger"><?=$_SESSION['errorTourTime']?></div><br>
        <label for='requestName' class='label'>Статус заявки:</label>
        <?php
            if($_SESSION["userRole"] == 2) {
                echo "<input type='text' name='requestName' value='" . $_SESSION['requestName'] . "' placeholder='Статус заявки' class='form-control' readonly>";
            }
            else {
                echo "<select name='requestName' placeholder='Статус заявки' value='" . $_SESSION['requestName'] . "' class='form-control'>";
                printSelectResultsForComboBox($requestResult, $requestColumn);
                echo "</select>";
            }
        
        ?>
        <button type="submit" class="btn btn-success">Отправить</button>
        <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeEditForm();">Закрыть</button>
    </form>
    <div class='container  mt-2'>
        <div class='container'>
            <div class='row'>
                <?=printSelectResults($gridResult)?>
            </div>
        </div>
    </div>
    <?php
        if($_SESSION["userRole"] == 2)
            echo "<h1 class='text-center gridH'>Избранное</h1>"?>
    <div class='container  mt-2'>
        <div class='container clientFavourites'>
            <div class='row'>
                <?php 
                    if($_SESSION["userRole"] == 2)
                        require_once "client_favourites.php";
                ?>
            </div>
        </div>
    </div>
<?php
    include_once "footer.php";
?> 
</div>




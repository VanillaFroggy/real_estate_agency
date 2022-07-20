<?php
    echo "<div class='container element profile' id='profileDiv'>";
    echo "Id: " . $_SESSION['userId']."<br>";
    echo "Фамилия: " . $_SESSION['userLastname']."<br>";
    echo "Имя: " . $_SESSION['userFirstname']."<br>";
    echo "Отчество: " . $_SESSION['userPatronymic']."<br>";
    echo "Телефон: " . $_SESSION['userPhone']."<br>";
    echo "Логин: " . $_SESSION['userLogin']."<br>";
    echo "Пароль: " . $_SESSION['userPassword']."<br>";
    echo "<button type='button' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' onclick='openProfileForm();'>Редактировать</button>";
    echo "</div>";
?>
<form action="checkEditProfile.php" id="profileForm" style="display: none;" method="post">
    
    <label for="userLastname" class="label">Фамилия:</label>
    <input type="text" name="userLastname" value="<?=$_SESSION['userLastname']?>" placeholder="Введите фамилию" class="form-control">
    <div class="text-danger"><?=$_SESSION['errorUserLastname']?></div><br>

    <label for="userFirstname" class="label">Имя:</label>
    <input type="text" name="userFirstname" value="<?=$_SESSION['userFirstname']?>" placeholder="Введите имя" class="form-control">
    <div class="text-danger"><?=$_SESSION['errorUserFirstname']?></div><br>
    
    <label for="userPatronymic" class="label">Отчество:</label>
    <input type="text" name="userPatronymic" value="<?=$_SESSION['userPatronymic']?>" placeholder="Введите отчество" class="form-control">
    <div class="text-danger"><?=$_SESSION['errorUserPatronymic']?></div><br>
    
    <label for="userPhone" class="label">Телефон:</label>
    <input type="number" name="userPhone" value="<?=$_SESSION['userPhone']?>" placeholder="Введите номер телефона" class="form-control">
    <div class="text-danger"><?=$_SESSION['errorUserPhone']?></div><br>
    
    <label for="userLogin" class="label">Логин:</label>
    <input type="text" name="userLogin" value="<?=$_SESSION['userLogin']?>" placeholder="Введите логин" class="form-control">
    <div class="text-danger"><?=$_SESSION['errorUserLogin']?></div><br>

    <label for="userPassword" class="label">Пароль:</label>
    <input type="password" name="userPassword" value="<?=$_SESSION['userPassword']?>" placeholder="Введите пароль" class="form-control">
    <div class="text-danger"><?=$_SESSION['errorUserPassword']?></div><br>

    <button type="submit" class="btn btn-success">Сохранить</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeProfileForm();">Закрыть</button>
</form>
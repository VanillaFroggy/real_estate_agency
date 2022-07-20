<?php
    function printSelectFavourites($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element'><form action='checkClientFavourites.php' method='post'>";
                $realEstateId = $row['real_estate_id'];
                echo "id недвижимости: $realEstateId <br>";
                echo "<input type='number' name='clientFavouriteId' value='$realEstateId' style='display: none;'>";
                echo "<img src='imageView.php?id=$realEstateId&column=real_estate_photos' class='img-fluid' style='width: 300px; height: 180px'>" ."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Перейти к недвижимости</button>";
                echo "<button type='submit' name='isDeleteFavourite' value='1' class='btn btn-danger' style='margin-bottom: 7px;'>Удалить из избранного</button>";
                echo "</form></div>";
            }
        }
    }

    if($mysql->connect_error) {
        echo "Error Number: ". $mysqsl->connect_errno."<br>";
        echo "Error: " . $mysql->connect_error;
    }
    else {
        $result = $mysql->query("SELECT client_favourites.real_estate_id, real_estate.real_estate_photos FROM `client_favourites` INNER JOIN `real_estate` ON client_favourites.real_estate_id = real_estate.id WHERE `client_id` = " . $_SESSION["userId"] . ";");
        printSelectFavourites($result);
    }
    
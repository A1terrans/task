<?php
function sendToSql($ObjList){
    include 'config.php';
    foreach($ObjList as $Obj){
        $data = explode("#", $Obj);
        $query ="SELECT * FROM DataCSV WHERE code ='" . $data[0] ."'";
		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        echo($query);
        if(mysqli_num_rows($result) == 0) {
            $queryTwo ="INSERT INTO DataCSV VALUES ('" . $data[0] . "','" . $data[1] ."')";
            $resultTwo = mysqli_query($link, $queryTwo) or die("Ошибка " . mysqli_error($link));
            echo($queryTwo);
        } else {
            $queryTwo ="UPDATE DataCSV SET name = '". $data[1] ."' WHERE code = '". $data[0] ."'";
            $resultTwo = mysqli_query($link, $queryTwo) or die("Ошибка " . mysqli_error($link));
            echo($queryTwo);
        }
    }
}
?>
<?php
    $host = 'localhost'; // адрес сервера 
    $database = 'admin_port'; // имя базы данных
    $user = 'admin_port'; // имя пользователя
    $password = '123123123'; // пароль
    $link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
    mysqli_query($link, "SET NAMES UTF8 ");
?>
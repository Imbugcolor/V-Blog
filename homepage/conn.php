<?php
    $connect = mysqli_connect("localhost", "root", "", "blogit");
    header("Content-type: text/html; charset=utf-8");
    mysqli_set_charset($connect, 'UTF8');
?>
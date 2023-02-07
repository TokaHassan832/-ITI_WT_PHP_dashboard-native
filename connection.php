<?php
try {
    $connection=new PDO('mysql:host=localhost;dbname=task3','root','');
}catch (Exception $e){
    echo $e->getMessage();
    exit();
}


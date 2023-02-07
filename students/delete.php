<?php
require_once '../connection.php';
if (isset($_GET['code'])){
    $code=$_GET['code'];
}else{
    echo "<h1 align='center'>Wrong Page!!!!</h1>";
    exit();
}
$result=$connection->query("delete from students where code=$code");
header("location:index.php");
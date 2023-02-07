<?php

if (isset($_POST['save'])){
    $username = $_POST['username'];
    setcookie('username',$username,time()+60*60*60);
}
if (isset($_COOKIE['username'])) {
    echo $_COOKIE['username'];
}
?>
<form method="post" action="">
    <input type="text" name="username">
    <input type="submit" name="save">
</form>


<a href="logout.php">Logout</a>
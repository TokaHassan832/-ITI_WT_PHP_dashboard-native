<?php

//setcookie('username','',time()-1);  for destroy cookie
session_start();
session_destroy();
header("location: login.php");
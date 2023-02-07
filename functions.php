
<?php

function validate($input){
    $input=trim($input);
    $input=htmlspecialchars($input);
    $input=stripslashes($input);
    return $input;
}

function check_int($input,$key,$error){
    global $errors;
    if (!filter_var($input,FILTER_VALIDATE_INT)){
        $errors[$key]=$error;
    }
}

function if_empty($input,$key,$error){
    global $errors;
    if (empty($input)){
        $errors[$key]=$error;
    }
}

function check_unique($table,$column,$input,$key,$error){
    global $errors;
    global $connection;
$input_result=$connection->query("select $column from $table where $column='$input'");
$input_count=$input_result->rowCount();
if ($input_count>0){
    $errors[$key]=$error;
}
}


<?php
include("config.php");
include("firebaseRDB.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$clicks = 0;

if($name == ""){
    echo "Name is required";
}else if($name == ""){
    echo "Password is required";
}else{
    $rdb = new firebaseRDB($databaseURL);
    $retrieve = $rdb -> retrieve("/user","email","EQUAL", $email);
    $data = json_decode($retrieve, 1);
    if(count($data) > 0){
        echo "Email already used";
    }else{
        $insert = $rdb->insert("/user",[
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "clicks" => $clicks
        ]);

        $result = json_decode($insert, 1);
        if(isset($result['name'])){
            echo "Signup Success, Please Login";
            echo "<br><a href='login.php'>Login</a>";
        }
        else{
            echo "Signup Failed";
        }
    }
}

?>
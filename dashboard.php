<?php
include("config.php");

include("firebaseRDB.php");
echo " <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>";

if(!isset($_SESSION['user'])){
    header("location: login.php");
}
else{
    $rdb = new firebaseRDB($databaseURL);
    echo "hello <b>{$_SESSION['user']['name']}</b>,  Welcome to my website <br>";
    echo "<a href='logout.php'>Logout</a>";
    $link = 'www.youtube.com/@gsocexpress';
    echo "<br> <a href='www.youtube.com/@gsocexpress' id='link-to-copy'>Example link</a> <br> <form method='POST'><button type='submit' name='click_button' id='copy-link-button'>Copy to Clipboard</button> </form><br>";

    echo '<script>const copyLinkButton = document.getElementById("copy-link-button");
    const linkToCopy = document.getElementById("link-to-copy");

    copyLinkButton.addEventListener("click", function() {
      const tempInput = document.createElement("input");
      tempInput.value = linkToCopy.href;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
      alert("Link copied to clipboard! Share it now :)");
    });</script>';


    // display the current value of "click"
    $retrieve = $rdb->retrieve("/user", "email","ALL",null);
    $data = json_decode($retrieve, true);
    $currentname = $_SESSION['user']['name'];
    if(isset($data)){
       foreach($data as $key => $value){
          if($value['name'] == $currentname){
             $clicks = $value['clicks'];
             echo "Number of clicks: ".$clicks;
          }
       }
    }

    // update value of "click"
    if(isset($_POST['click_button'])){
    $retrieve1 = $rdb->retrieve("/user", "email","ALL",null);
      $data1 = json_decode($retrieve1, true);
      $currentname = $_SESSION['user']['name'];
      $currentClicks = 0;
      if(isset($data1)){
         foreach($data1 as $key => $value){
            $currentClicks = $value['clicks'];
            $uniqueID = $key;
         }
         $newClicks = $currentClicks + 1;
         $data1 = array("clicks" => $newClicks);
         $update = $rdb->update("/user", $uniqueID, $data1);
         $_POST = array();
         header("Refresh: 0");
      }
    }
}
?>
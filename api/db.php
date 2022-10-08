<?php 
// error_reporting(0);
$db = new mysqli("localhost", "notesocean", "notesocean", "notesocean");

if($db->connect()){
    
}else{
    // set content type to json
    header("Content-Type: application/json");
    echo json_encode(["status" => "success", "message" => "Database connection failed"]);
    exit;
}

?>
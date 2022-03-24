<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Allow-Methods, Authorization, X-Requested-With');

//initializing our api
include_once('../config/DB.php');
include_once('../models/post.php');

//instantiate DB and connect
$database = new DB();
$db = $database->conn();

//instantiate post class
$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

if($post->create()){
    echo json_encode(
        array('message'=> 'Post Created')
    );
}
else{
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}


?>
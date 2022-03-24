<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//initializing our api
include_once('../config/DB.php');
include_once('../models/post.php');

//instantiate DB and connect
$database = new DB();
$db = $database->conn();

//instantiate post class
$post = new Post($db);

//get ID from URL
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get Single Post
$post->read_single();

//Create Array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

//convert to json

print_r(json_encode($post_arr));

?>
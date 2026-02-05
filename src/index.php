<?php
$mapped_paths = [];

function setPaths($url, $path) {
    global $mapped_paths;
    $mapped_paths[$url] = $path;
}

function getRoot($url) {
    global $mapped_paths;
    return isset($mapped_paths[$url]) ? $mapped_paths[$url] : null;
}

$request_uri = $_SERVER['REQUEST_URI'];
$tmp_path = parse_url($request_uri, PHP_URL_PATH);
$path = ($tmp_path !== '/') ? rtrim($tmp_path, '/') : $tmp_path;  
    
setPaths('/login', 'login.php');
setPaths('/table', 'table.php');
setPaths('/logout', 'logout.php');
setPaths('/comment', 'comment.php');

$file = getRoot($path);

if ($file === null || !file_exists(__DIR__ . '/' . $file)) {  
     http_response_code(404);  
     echo "404 Not Found";  
     exit;  
 }  

require __DIR__ . '/' . $file;

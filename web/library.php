<?php
cors();


function cors() {
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
}
    
include __DIR__ . '/convertor.php';

try{
    if ($_POST['title'] && !empty($_POST['title']) && $_POST['body'] && !empty($_POST['body'])&& $_POST['type'] && !empty($_POST['type']) && $_POST['confirmDate'] && !empty($_POST['confirmDate']) && $_POST['number'] && !empty($_POST['number']) ) {
        return LibraryPdf($_POST['title'],$_POST['body'],$_POST['type'], $_POST['confirmDate'], $_POST['number']);
    }
    else if ($_POST['title'] && !empty($_POST['title']) && $_POST['body'] && !empty($_POST['body']) )
    {
        return LibraryPdf($_POST['title'],$_POST['body']);
    }
    else
    { 
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        if ($data && 
        !empty($data['title']) &&
        !empty($data['body']) &&
        !empty($data['type'])&& 
        !empty($data['confirmDate'])&& 
        !empty($data['number']))
        {
            return LibraryPdf($data['title'],$data['body'],$data['type'], $data['confirmDate'], $data['number']);
        }
        else if ($data && 
        !empty($data['title']) &&
        !empty($data['body'])) 
        {
            return LibraryPdf($data['title'],$data['body']);
            
        }

        http_response_code(400);
    }
}
catch (Exception $e)
{
    echo $e->getMessage();
}
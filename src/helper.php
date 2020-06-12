<?php

function dump(){
    foreach(func_get_args() as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    dump(...func_get_args());
    exit;
}

function go($url, $message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "location.href='$url';";
    echo "</script>";
    exit;
}

function back($message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
    exit;
}

function json_response($result = false, $data = []){
    header("Content-Type: application/json");
    echo json_encode(array_merge(['result' => $result], $data));
    exit;
}

function checkInput($response = "js"){
    foreach($_POST as $item){
        if($item === ""){
            if($response === "js") back("모든 정보를 입력해 주세요!"); 
            else json_response(); 
        }
    }
    foreach($_FILES as $file){
        if(!is_file($file['tmp_name'])){
            if($response === "js") back("파일을 업로드 해 주세요!"); 
            else json_response();            
        }
    }
}

function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

function view($pageName, $data = []){
    extract($data);
    $filePath = _VIEW.DS.$pageName .".php";

    if(is_file($filePath)){
        require _VIEW.DS."layouts/header.php";
        require $filePath;
        require _VIEW.DS."layouts/footer.php";
    }
    exit;
}

function extname($filename){
    return substr($filename, strrpos(".", $filename));
}

function printScore($total, $cnt = 1){
    $score = $cnt == 0 ? 0 : floor($total / $cnt);

    for($i = 0; $i < $score; $i++)
        echo "<i class='fa fa-star'></i>";
    
    for(; $i < 5; $i++)
        echo "<i class='fa fa-star-o'></i>";
}
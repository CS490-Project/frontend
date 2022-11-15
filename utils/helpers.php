<?php

session_start();

function is_logged_in() {
    return isset($_SESSION["user"]);
}

function user_is_teacher() {
    return $_SESSION["user"]["role"] == "teacher";
}

function user_is_student() {
    return $_SESSION["user"]["role"] == "student";
}

function get_user_id() {
    if (is_logged_in() && isset($_SESSION["user"]["user_id"])) {
        return $_SESSION["user"]["user_id"];
    }
    return -1;
}

function make_request($endpoint, $params){
    $defaults = [
        CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/'.$endpoint.'.php',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true
    ];
    //Ask Jozi to change mid to do login in JSON 
    if($endpoint != "mid"){
        $defaults[CURLOPT_POSTFIELDS] = json_encode($params);
        $defaults[CURLOPT_HTTPHEADER] = array('Content-Type:application/json');
    } 
    //Testing autograde for now, later remove
    if($endpoint == "mid_autograde"){
        $defaults[CURLOPT_URL] = 'https://afsaccess4.njit.edu/~gc348/CS490/middleware/mid_autograde.php';
    }

    $ch = curl_init();
    curl_setopt_array($ch, $defaults);

    //results from middle
    $response = json_decode(curl_exec($ch), true);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
    
    return ["response" => $response, "status" => $status];
}



function getMessages() {
    if (isset($_SESSION['flash'])) {
        $flashes = $_SESSION['flash'];
        $_SESSION['flash'] = array();
        return $flashes;
    }
    return array();
}

function pretty_print($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";

}



//for flash feature
function flash($msg) {
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $msg);
    }
    else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $msg);
    }

}

function getURL($path) {
    if (substr($path, 0, 1) == "/") {
        return $path;
    }
    return $_SERVER["CONTEXT_PREFIX"] . "/CS490/frontend/$path";
}
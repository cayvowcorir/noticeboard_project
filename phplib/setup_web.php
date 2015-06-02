<?php

if(isset($_POST)){
    
    require_once 'util/input.php';
    
    $response = array();
    
    $type = $_POST['Type'];    
    
    switch($type){
        
        case 'setup':         
            $response = setup();
            break;         
    }
    
    echo json_encode($response);
}

function addImports(){       
    require_once 'init/DbConnect.php';
    require_once 'class/cls_User.php';
}

function setup(){
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'User_no';
        
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();
        $db = new DbConnect();
        $con = $db->connect();
        $date = date('Y-m-d H:i:s');
        
        $user_no = sanitize_mysqli($con, $_POST['User_no']);
        
        //Get user data
        $user = new User($con);
        $user_data = $user->get($user_no);
        
        //Get user info data
        $user_info_no = $user_data['user_info_no'];
        $response['user_info'] = $user->get_user_info($user_info_no);
        
        //Get user avatar data
        $avatar_no = $user_data['avatar_no'];
        $response['avatar'] = $user->get_user_avatar($avatar_no);
        
        //set the last updated date
        $response['date'] = $date;        
        $response = array_merge($response, $user_data);
    }    
    
    return $response;
}

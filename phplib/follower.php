<?php

if(isset($_POST)){
    
    require_once 'util/input.php';
    
    $response = array();
    
    $type = $_POST['Type'];    
    
    switch($type){
        
        case 'follow':
            $response = follow();
            break;

        case 'load':
            $response = load_followers();
            break;
    }
    
    echo json_encode($response);
}

function addImports(){       
    require_once 'init/DbConnect.php';
    require_once 'class/cls_Follower.php';
    require_once 'class/cls_NoticeBoard.php';
    require_once 'class/cls_User.php';
}

function follow(){
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';
    $allowed[] = 'User_no';
    $allowed[] = 'Noticeboard_no';
        
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            //Get the fields
            $user_no = sanitize_mysqli($con, $_POST['User_no']);
            $noticeboard_no = sanitize_mysqli($con, $_POST['Noticeboard_no']);

            //Get a connection to notices
            $follower = new Follower($con);
            
            //follow
            $response = $follower->follow($user_no, $noticeboard_no);
        }       
        else{
            $response['res'] = -1;            
        }
        
    }
    else{        
        $response['res'] = -2;        
    }
    
    return $response;
}

function load_followers()
{
    $response = array();

    $allowed = array();
    $allowed[] = 'Type';
    $allowed[] = 'Noticeboard_no';
    $allowed[] = 'Lower';
    $allowed[] = 'Limit';

    $sent = array_keys($_POST);

    if (input_ok($sent, $allowed)) {
        addImports();

        $db = new DbConnect();
        $con = $db->connect();

        if (!mysqli_connect_errno()) {

            //Get the fields
            $noticeboard_no = sanitize_mysqli($con, $_POST['Noticeboard_no']);
            $lower = sanitize_mysqli($con, $_POST['Lower']);
            $limit = sanitize_mysqli($con, $_POST['Limit']);

            $follower = new Follower($con);
            $response["results"] = $follower->load_followers($noticeboard_no, $lower, $limit);
        } else {
            $response['res'] = -1;
        }

    } else {
        $response['res'] = -2;
    }

    return $response;
}
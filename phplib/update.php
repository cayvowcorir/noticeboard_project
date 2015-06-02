<?php

if(isset($_POST)){
    
    require_once 'util/input.php';
    
    $response = array();
    
    $type = $_POST['Type'];    
    
    switch($type){
        
        case 'update':
            $response = update();
            break;         
    }
    
    echo json_encode($response);
}

function addImports(){       
    require_once 'init/DbConnect.php';
    require_once 'class/cls_Notice.php';
}

function update(){
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';
    $allowed[] = 'User_no';
    $allowed[] = 'Last_updated';
        
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            //Get the fields
            $user_no = sanitize_mysqli($con, $_POST['User_no']);
            $last_updated = sanitize_mysqli($con, $_POST['Last_updated']);

            //Get a connection to notices
            $notice = new Notice($con);

            //Get new last updated
            $date = date('Y-m-d H:i:s');
            $response['last_updated'] = $date;
            //load updates
            $response['notices'] = $notice->load_all_new($user_no, $last_updated, $date);
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

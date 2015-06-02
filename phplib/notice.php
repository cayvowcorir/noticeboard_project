<?php

if(isset($_POST)){
    
    require_once 'util/input.php';
    
    $response = array();
    
    $type = $_POST['Type'];    
    
    switch($type){
        
        case 'add_notice':         
            $response = add_notice();
            break;         
    }
    
    echo json_encode($response);
}

function addImports(){       
    require_once 'init/DbConnect.php';
    require_once 'class/cls_Notice.php';
}

function add_notice(){
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'Noticeboard_no'; 
    $allowed[] = 'Type_no';
    $allowed[] = 'Title'; 
    $allowed[] = 'Desc';  
    $allowed[] = 'Date_expiry';
        
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            //Get the fields
            $noticeboard_no = sanitize_mysqli($con, $_POST['Noticeboard_no']);  
            $type = sanitize_mysqli($con, $_POST['Type_no']);            
            $title = sanitize_mysqli($con, $_POST['Title']);
            $desc = sanitize_mysqli($con, $_POST['Desc']);
            $date_expiry = sanitize_mysqli($con, $_POST['Date_expiry']);
            
            $file_ext = "";
            
            //Get a connection to notices
            $notice = new Notice($con);
            
            //Add record
            $response = $notice->add($noticeboard_no, $type, $file_ext, $title, $desc, $date_expiry);
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

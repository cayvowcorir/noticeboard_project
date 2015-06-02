<?php

if(isset($_POST)){
    
    require_once 'util/input.php';
    
    $response = array();
    
    $type = $_POST['Type'];    
    
    switch($type){
        
        case 'username_exists':         
            $response = username_exists();
            break; 
        case 'add_user':         
            $response = add_user();
            break;
        case 'login_user':         
            $response = login_user();
            break;        
        case 'update_info':         
            $response = update_info();
            break;
        case 'search_user':
            $response = search_user();
            break;
        
    }
    
    echo json_encode($response);
}

function addImports(){
    require_once 'class/cls_User.php';    
    require_once 'init/DbConnect.php';
    require_once 'util/validation.php';
}

function add_user(){
    
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'User_name';
    $allowed[] = 'Email';
    $allowed[] = 'User_pass';
    
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            $user_name = sanitize_mysqli($con, $_POST['User_name']);  
            $email = sanitize_mysqli($con, $_POST['Email']);
            $user_pass = sanitize_mysqli($con, $_POST['User_pass']);            
            $response = validate_user($con, $user_name, $email, $user_pass);
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

//function to check for user name availability
function username_exists(){
    
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'User_name';
    
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            $user = new User($con);
            $user_name = sanitize_mysqli($con, $_POST['User_name']);
            $response['res'] = $user->user_name_exists($user_name);           
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

//function to add user

function validate_user($con, $user_name, $email, $user_pass){
    
    $response = array();
    
    if(inputValid($user_name, $email, $user_pass)){
        $user = new User($con);
        $res = $user->user_name_exists($user_name);
        
        if($res == 0){
            $response['no'] = $user->add($user_name, $email, $user_pass);
            $response['res'] = 1;
        }
        else{
            $response['res'] = -4;
        }
    }
    else{
        $response['res'] = -3;
    }
    return $response;
}

//function to login user

function login_user(){
    
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'User_name';
    $allowed[] = 'User_pass';
    
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            $user = new User($con);
            
            $user_name = sanitize_mysqli($con, $_POST['User_name']);
            $user_pass = sanitize_mysqli($con, $_POST['User_pass']);
                        
            $response['res'] = $user->login($user_name, $user_pass);           
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


//function to update user info

function update_info(){
    
    $response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'User_info_no';
    $allowed[] = 'Fullname';
    $allowed[] = 'Phone';
    $allowed[] = 'Email';
    
    $sent = array_keys($_POST);
    
    if (input_ok($sent, $allowed))
    {
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();
        
        if(!mysqli_connect_errno()){
            $user = new User($con);
            
            $user_info_no = sanitize_mysqli($con, $_POST['User_info_no']);
            $fullname = sanitize_mysqli($con, $_POST['Fullname']);
            $phone = sanitize_mysqli($con, $_POST['Phone']);
            $email = sanitize_mysqli($con, $_POST['Email']);
                        
            $response = $user->update_user_info($user_info_no, $fullname, $phone, $email);           
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

function search_user()
{
    $response = array();

    $allowed = array();
    $allowed[] = 'Type';
    $allowed[] = 'User_no';
    $allowed[] = 'Keyword';
    $allowed[] = 'Lower';
    $allowed[] = 'Limit';

    $sent = array_keys($_POST);

    if (input_ok($sent, $allowed)) {
        addImports();

        $db = new DbConnect();
        $con = $db->connect();

        if (!mysqli_connect_errno()) {

            //Get the fields
            $user_no = sanitize_mysqli($con, $_POST['User_no']);
            $keyword = sanitize_mysqli($con, $_POST['Keyword']);
            $lower = sanitize_mysqli($con, $_POST['Lower']);
            $limit = sanitize_mysqli($con, $_POST['Limit']);

            $user = new User($con);
            $response["results"] = $user->search($user_no, $keyword, $lower, $limit);
        } else {
            $response['res'] = -1;
        }

    } else {
        $response['res'] = -2;
    }

    return $response;
}

<?php

require_once 'input.php';

function username_ok($username){
    
    $len = strlen($username);
    
    if($len < 4){
        return false;
    }    
    
    if(string_has_spaces($username)){
        return false;
    }
    
    return true;    
}

function email_ok($email){
    
    $email_pattern= '/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i';	
    
    if (preg_match($email_pattern, $email)) 
    { 
        return true;                    
    }
    
    return false;
}

function password_ok($password){
    
    $len = strlen($password);
    
    if($len < 6){
        return false;
    }    
    
    if(string_has_spaces($password)){
        return false;
    }
    
    return true;
}


function inputValid($username, $email, $password){
    return (username_ok($username) && (email_ok($email)) && (password_ok($password)));
}
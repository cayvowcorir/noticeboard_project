<?php

function sanitize_string($var)
{
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}

//Code to sanitize string
function sanitize_mysqli($con, $var)
{ 
    $var = $con->real_escape_string($var);
    $var = sanitize_string($var);
    return $var;
}

//Check if input matches the allowed paremeters
function input_ok($sent , $allowed){
    
    $size_sent = count($sent);
    $size_allowed = count($allowed);
   
    
    if($size_allowed == $size_sent){
        foreach ($sent as $val_sent) {
            $found = false;
            
            foreach ($allowed as $val_allowed) {
                if(strcmp($val_sent, $val_allowed) === 0){
                    $found = true;
                    break;
                }
            }
            
            if($found == false){
                return false;
            }
        }
        
        return true;
    }   
    
    return false;
}

//Check if a string has spaces in between
function string_has_spaces($s){
    
    for($i = 0 ; $i < strlen($s); ++$i){
        if($s[$i] == ' '){
            return true;
        }    
    }
    
    return false;    
}



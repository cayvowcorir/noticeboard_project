<?php 

if(isset($_POST)){
    
    require_once 'util/input.php';
    
    $response = array();
    
    $type = $_POST['Type'];    
    
    switch($type){
        
        case 'load_noticeboard_name':         
            $response = load_noticeboard_name();
            break;         
    }
    
    echo json_encode($response);
}

function addImports(){       
    require_once 'init/DbConnect.php';
    require_once 'class/cls_NoticeBoard.php';
}


function load_noticeboard_name(){
	$response = array();
    
    $allowed   = array();
    $allowed[] = 'Type';   
    $allowed[] = 'noticeboard_name';

    $sent = array_keys($_POST);

    if (input_ok($sent, $allowed)){
        addImports();       
        
        $db = new DbConnect();
        $con = $db->connect();


        if(!mysqli_connect_errno()){
            $noticeboard_name = sanitize_mysqli($con, $_POST['noticeboard_name']);                      
            
        
	        if( ($stmt = $this->con->prepare("SELECT 'title' FROM noticeboards ") {

	        	$result;
		        $stmt -> bind_param("s", $noticeboard_name);
		        $stmt -> execute();
		        $stmt -> fetch();
		        $stmt -> bind_result($result)
		        $stmt -> close();
		        
		        $response['res'] = 1;
		        $response['result'] = $result;
	        
	        	return $response;
        	}       
	        else{
	            $response['res'] = -1;
            }            

        }
         else{
	            $response['res'] = -2;
            } 
    }
    else{
	            $response['res'] = -3;
            }         
   
	
    } 
    
    $response['res'] = 0;
    return $response;



class NoticeBoard{
var $con;	    
    
    //to pass in the connection
    public function __construct($con) {
        $this->con = $con;
    }
   
   	public function get_noticeboard_name(){
	    if( ($stmt = $this->con->prepare("SELECT 'title' FROM noticeboards ") {

	        $stmt -> bind_param("dddssss", $user_no, $avatar_no, $type, $title, $desc, $date, $date);
	        $stmt -> execute();
	        $id = $stmt -> insert_id;
	        $stmt -> close();
	        
	        $response['res'] = 1;
	        $response['noticeboard_no'] = $id;
	        $response['avatar_no'] = $avatar_no;
	        $response['date'] = $date;
        }

  	}
?>
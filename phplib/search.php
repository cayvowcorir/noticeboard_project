<?php 
if(isset($_GET)){

    $response = array();
	require_once 'init/DbConnect.php';
	require_once 'class/cls_NoticeBoard.php';
	require_once 'util/input.php';

	$db = new DbConnect();
	$con = $db->connect();

	if (!mysqli_connect_errno()) {
	    //Get the fields
	    $term = sanitize_mysqli($con, $_GET['term']);
	    $response = search($con, $term);
        echo json_encode($response);
	    
// 	} else {
// 	    $response['res'] = -1;
// 	}

// } else {
//     $response['res'] = -2;
}
}



 function search($con, $keyword){
        $query = "SELECT `noticeboard_no`,`title` FROM `noticeboards` WHERE  `title` LIKE '%$keyword%'";
        $result = mysqli_query($con, $query);
        $response = array();
        $response['count'] = mysqli_num_rows($result);
        $counter = 0;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $response[$counter] = array(
      
                'title' => $row['title']      
            );
            ++$counter;
        }
        return $response;
        
    }
?>
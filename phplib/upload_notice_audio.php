<?php

$response = array();

if (isset($_FILES)) {

    require_once 'util/input.php';

    $code = $_REQUEST['code'];

    //Check if the file type is ok
    $file_ok = file_type_ok();

    if($code == "2010" && $file_ok){

        require_once 'class/cls_Notice.php';
        require_once 'init/DbConnect.php';

        //Set the destination folder
        $target_path1 = "noticeaudio/";

        $filename = $_FILES['file1']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        //Add notice to db and get the notice no
        $res = addNoticeToDb($ext);
        $target_path1 = $target_path1 . $res['notice_no'] . "." . $ext;

        //Upload the file
        if (move_uploaded_file($_FILES['file1']['tmp_name'], $target_path1)) {
            $response = array_merge($response, $res);
            $response['success'] = '1';
        } else {
            $response['success'] = '0';
        }
    } else {
        $response['success'] = "0";
    }
} else {
    $response['success'] = "0";
}

function file_type_ok() {
    $allowed = array('mp3', 'wav', '3gp');
    $filename = $_FILES['file1']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return in_array($ext, $allowed);
}

function addNoticeToDb($file_ext) {

    //Connect to db
    $db = new DbConnect();
    $con = $db->connect();

    //Get the fields
    $noticeboard_no = sanitize_mysqli($con, $_POST['Noticeboard_no']);
    $type = sanitize_mysqli($con, $_POST['Type_no']);
    $title = sanitize_mysqli($con, $_POST['Title']);
    $desc = sanitize_mysqli($con, $_POST['Desc']);
    $date_expiry = sanitize_mysqli($con, $_POST['Date_expiry']);

    //Get a connection to notices
    $notice = new Notice($con);

    //Add record
    return $notice->add($noticeboard_no, $type, $file_ext, $title, $desc, $date_expiry);
}

//output the response from server in json format
echo json_encode($response);

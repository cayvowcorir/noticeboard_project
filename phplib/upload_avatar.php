<?php

$response = array();

if (isset($_FILES)) {
    
    require_once 'util/input.php';

    $code = $_REQUEST['code'];

    if ($code == "2010" && file_type_ok()) {
        
        require_once 'class/cls_User.php';
        require_once 'init/DbConnect.php';

        $db = new DbConnect();
        $con = $db->connect();

        //Get the username to rename the file
        $avatar_no = sanitize_mysqli($con, $_REQUEST['avatar_no']);
        $target_path1 = "avatarmedium/";

        $target_path1 = $target_path1 . $avatar_no . ".jpg";

        //Upload the file
        if (move_uploaded_file($_FILES['file1']['tmp_name'], $target_path1)) {

            //Get the small image            
            $img = resize_image($target_path1, 50, 50);
            ImageJPEG($img, "avatarsmall/" . $avatar_no . ".jpg");

            //Update the avatar record
            $user = new User($con);
            $user->updateAvatar($avatar_no, "1");
            $response['success'] = '1';
        } else {
            $response['success'] = '0';
        }
    } else {
        $response['success'] = "0";
    }

    echo json_encode($response);
}

//Check is the file type is ok
function file_type_ok() {
    $allowed = array('jpg', 'jpeg');
    $filename = $_FILES['file1']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return in_array($ext, $allowed);
}

function resize_image($file, $w, $h, $crop = FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

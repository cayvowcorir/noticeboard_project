<?php

if (isset($_POST)) {

    require_once 'util/input.php';

    $response = array();

    $type = $_POST['Type'];

    switch ($type) {

        case 'add_noticeboard':
            $response = add_noticeboard();
            break;
        case 'search_noticeboard':
            $response = search_noticeboard();
            break;
        case 'load_user':
            $response = load_user_noticeboards();
            break;
        case 'load_noticeboard':
            $response = load_noticeboard();
            break;
    }

    echo json_encode($response);
}

function addImports()
{
    require_once 'init/DbConnect.php';
    require_once 'class/cls_NoticeBoard.php';
    require_once 'class/cls_Follower.php';
}

function add_noticeboard()
{
    $response = array();

    $allowed = array();
    $allowed[] = 'Type';
    $allowed[] = 'User_no';
    $allowed[] = 'Type_no';
    $allowed[] = 'Title';
    $allowed[] = 'Desc';

    $sent = array_keys($_POST);

    if (input_ok($sent, $allowed)) {
        addImports();

        $db = new DbConnect();
        $con = $db->connect();

        if (!mysqli_connect_errno()) {

            //Get the fields
            $user_no = sanitize_mysqli($con, $_POST['User_no']);
            $type = sanitize_mysqli($con, $_POST['Type_no']);
            $title = sanitize_mysqli($con, $_POST['Title']);
            $desc = sanitize_mysqli($con, $_POST['Desc']);

            //Get a connection to noticeboard
            $noticeboard = new NoticeBoard($con);

            //Add record
            $response = $noticeboard->add($user_no, $type, $title, $desc);
        } else {
            $response['res'] = -1;
        }

    } else {
        $response['res'] = -2;
    }

    return $response;
}

function search_noticeboard()
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

            $noticeboard = new NoticeBoard($con);
            $response["results"] = $noticeboard->search($user_no, $keyword, $lower, $limit);
        } else {
            $response['res'] = -1;
        }

    } else {
        $response['res'] = -2;
    }

    return $response;
}

function load_user_noticeboards()
{
    $response = array();

    $allowed = array();
    $allowed[] = 'Type';
    $allowed[] = 'User_no';

    $sent = array_keys($_POST);

    if (input_ok($sent, $allowed)) {
        addImports();

        $db = new DbConnect();
        $con = $db->connect();

        if (!mysqli_connect_errno()) {

            //Get the fields
            $user_no = sanitize_mysqli($con, $_POST['User_no']);

            $noticeboard = new NoticeBoard($con);
            $response["noticeboards"] = $noticeboard->load($user_no);
        } else {
            $response['res'] = -1;
        }

    } else {
        $response['res'] = -2;
    }

    return $response;
}

function load_noticeboard()
{
    $response = array();

    $allowed = array();
    $allowed[] = 'Type';
    $allowed[] = 'Noticeboard_no';

    $sent = array_keys($_POST);

    if (input_ok($sent, $allowed)) {
        addImports();

        $db = new DbConnect();
        $con = $db->connect();

        if (!mysqli_connect_errno()) {

            //Get the fields
            $noticeboard_no = sanitize_mysqli($con, $_POST['Noticeboard_no']);

            $noticeboard = new NoticeBoard($con);
            $response = $noticeboard->load_noticeboard($noticeboard_no);
        } else {
            $response['res'] = -1;
        }

    } else {
        $response['res'] = -2;
    }

    return $response;
}
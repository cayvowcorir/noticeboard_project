<?php

/*
 * Class to deal with all noticeboard transactions
 */


class NoticeBoard
{
    var $con;

    //to pass in the connection
    public function __construct($con)
    {
        $this->con = $con;
    }

    //add a new noticeboard
    public function add($user_no, $type, $title, $desc)
    {

        $response = array();

        //Get the link to the avatar table
        $avatar_no = $this->get_avatar_no();

        $date = date('Y-m-d H:i:s');

        if (($stmt = $this->con->prepare("INSERT INTO noticeboards (`user_no`, `avatar_no`,`type`, `title`, `desc`, `date_added`, `date_updated`) VALUES(?,?,?,?,?,?,?)"))) {

            $stmt->bind_param("dddssss", $user_no, $avatar_no, $type, $title, $desc, $date, $date);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();

            $response['res'] = 1;
            $response['noticeboard_no'] = $id;
            $response['avatar_no'] = $avatar_no;
            $response['date'] = $date;

            return $response;
        }

        $response['res'] = 0;
        return $response;
    }

    //get avatar no
    public function get_avatar_no()
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO avatars (is_set, date_added, date_updated) VALUES('0', '$date', '$date')";
        $this->con->query($query);

        return $this->con->insert_id;
    }

    //update user info    
    public function update_user_info($user_info_no, $fullname, $phone, $email)
    {

        $response = array();

        $date = date('Y-m-d H:i:s');

        if (($stmt = $this->con->prepare("UPDATE user_info SET fullname = ? , phone = ? , email = ? , date_updated = ? WHERE user_info_no = ?"))) {

            $stmt->bind_param("ssssd", $fullname, $phone, $email, $date, $user_info_no);
            $stmt->execute();
            $stmt->close();

            $response['res'] = 1;
            $response['date'] = $date;

            return $response;
        }

        $response['res'] = -1;
        return $response;
    }

    //load all noticeboards belonging to a particular user plus their notices
    public function load_and_notices($user_no)
    {
        $res = array();
        $notice = new Notice($this->con);
        $query = "SELECT * FROM  `noticeboards` WHERE  `user_no` = '$user_no'";
        $result = mysqli_query($this->con, $query);
        $rows = mysqli_num_rows($result);
        $res['count'] = $rows;
        $counter = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $res[$counter] = array(
                'noticeboard_no' => $row['noticeboard_no'],
                'user_no' => $row['user_no'],
                'avatar_no' => $row['avatar_no'],
                'type' => $row['type'],
                'title' => $row['title'],
                'desc' => $row['desc'],
                'date_added' => $row['date_added'],
                'date_updated' => $row['date_updated'],
                //Get all notices for the current noticeboard
                'notices' => $notice->load_all($row['noticeboard_no'])
            );
            ++$counter;
        }
        return $res;
    }

    //load all noticeboards belonging to a particular user
    public function load($user_no)
    {
        $res = array();
        $query = "SELECT `noticeboard_no`, `avatar_no`, `title` FROM  `noticeboards` WHERE  `user_no` = '$user_no'";
        $result = mysqli_query($this->con, $query);
        $rows = mysqli_num_rows($result);
        $res['count'] = $rows;
        $counter = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $res[$counter] = array(
                'noticeboard_no' => $row['noticeboard_no'],
                'avatar_no' => $row['avatar_no'],
                'title' => $row['title'],
            );
            ++$counter;
        }
        return $res;
    }

    /**
     * @param $user_no userno for the current user
     * @param $keyword title of the noticeboard to be searched
     * @param $lower the index to start returning results from
     * @param $limit the no of results to be returned
     * @return array results found or response
     */
    public function search($user_no, $keyword, $lower, $limit)
    {
        $query = "SELECT `noticeboard_no`,`title`, `avatar_no` FROM `noticeboards` WHERE `user_no` != '$user_no' AND `title` LIKE '%$keyword%' LIMIT $lower, $limit";
        $result = mysqli_query($this->con, $query);
        $response = array();
        $follower = new Follower($this->con);
        $response['count'] = mysqli_num_rows($result);
        $counter = 0;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $response[$counter] = array(
                'noticeboard_no' => $row['noticeboard_no'],
                'title' => $row['title'],
                'avatar_no' => $row['avatar_no'],
                'follow_status' => $follower->get_follower_status($user_no, $row['noticeboard_no'])
            );
            ++$counter;
        }
        return $response;
    }

    /**
     * Gets the noticeboard type of the noticeboard specified
     * @param $noticeboard_no
     * @return int
     */
    public function get_type($noticeboard_no)
    {
        $query = "SELECT `type` FROM `noticeboards` WHERE `noticeboard_no` = '$noticeboard_no' LIMIT 1";
        $result = mysqli_query($this->con, $query);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $type = $row['type'];
        } else {
            $type = -1;
        }

        return $type;
    }

    public function load_noticeboard($noticeboard_no)
    {
        $query = "SELECT `desc` FROM `noticeboards` WHERE `noticeboard_no` = '$noticeboard_no'";
        $result = mysqli_query($this->con, $query);
        $response = array();
        $response['res'] = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $response['res'] = 1;
            $response['desc'] = $row['desc'];
        }

        return $response;
    }
}

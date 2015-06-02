<?php
/*
 * Class to deal with all follower transactions
 */
class Follower
{
    /*
     * Follower status constants
     */
    const FOLLOWER_FOLLOWED = 1;
    const FOLLOWER_PENDING = 2;
    const FOLLOWER_NEW = 3;

    //Connection to the db
    var $con;

    /**
     * @param $con connection to the db
     */
    public function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * @param $user_no the user to check
     * @param $noticeboard_no the noticeboard to check
     * @return int integer representing the follower status
     */
    public function get_follower_status($user_no, $noticeboard_no)
    {
        $query = "SELECT `followed` FROM `followers` WHERE `user_no` = '$user_no' AND `noticeboard_no` = '$noticeboard_no' LIMIT 1";
        $result = mysqli_query($this->con, $query);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $followed = $row['followed'];
            $follower_status = ($followed == 1 ? self::FOLLOWER_FOLLOWED : self::FOLLOWER_PENDING);
        } else {
            $follower_status = self::FOLLOWER_NEW;
        }

        return $follower_status;
    }

    /**
     * Follow a noticeboard
     * @param $user_no user following a noticeboard
     * @param $noticeboard_no the noticeboard being followed
     */
    public function follow($user_no, $noticeboard_no){
        //Response array
        $res = array();
        $res['res'] = 0;

        //Get the type of the noticeboard
        $noticeboard = new NoticeBoard($this->con);
        $noticeboard_type = $noticeboard -> get_type($noticeboard_no);

        if($noticeboard_type == 1 || $noticeboard_type == 2){
            $date = date('Y-m-d H:i:s');
            $followed = ($noticeboard_type == 1 ? 1 : 0);
            $date_followed = ($noticeboard_type == 1? $date : "0000-00-00 00:00:00");
            $query = "INSERT INTO `followers` (`follower_no`, `noticeboard_no`, `user_no`, `followed`, `date_added`, `date_followed`, `date_updated`) VALUES (NULL, '$noticeboard_no', '$user_no', '$followed', '$date', '$date_followed', '$date')";
            if(mysqli_query($this->con, $query)){
                $res['res'] = 1;
                $res['follower_no'] = mysqli_insert_id($this->con);
                $res['date'] = $date;
            }
        }

        return $res;
    }

    /**
     * @param $noticeboard_no noticebord to load followers
     * @param $lower the index to start returning results from
     * @param $limit the no of results to be returned
     * @return array results found or response
     */
    public function load_followers($noticeboard_no, $lower, $limit){
        $query = "SELECT `user_no` FROM  `followers` WHERE  `noticeboard_no` = '$noticeboard_no' AND `followed` = 1 LIMIT $lower , $limit";
        $result = mysqli_query($this->con, $query);
        $response = array();
        $response['count'] = mysqli_num_rows($result);
        $counter = 0;
        $user = new User($this->con);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $user_data  = $user -> get($row['user_no']);
            $response[$counter] = array(
                'user_no' => $row['user_no'],
                'user_name' => $user_data['user_name'],
                'avatar_no' => $user_data['avatar_no']
            );
            ++$counter;
        }
        return $response;
    }
}

<?php

/*
 * Class to deal with all user transactions
 */


class User
{
    var $con;

    //to pass in the connection
    public function __construct($con)
    {
        $this->con = $con;
    }

    //Check for username availability
    public function user_name_exists($user_name)
    {

        $count = 0;

        if (($stmt = $this->con->prepare("SELECT COUNT(*) FROM users WHERE user_name=?"))) {

            $stmt->bind_param("s", $user_name);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            return ($count > 0 ? 1 : 0);
        }

        return -1;
    }

    //add a new user
    public function add($user_name, $email, $user_pass)
    {

        //Get the link to the user info table
        $user_info_no = $this->get_info_no($email);

        //Get the link to the avatar table
        $avatar_no = $this->get_avatar_no();

        //Hash the password
        $user_pass = hash('ripemd128', $user_pass);

        $date = date('Y-m-d H:i:s');

        if (($stmt = $this->con->prepare("INSERT INTO users (`user_info_no`, `avatar_no`,`user_name`, `user_pass`, `date_added`) VALUES(?,?,?,?,?)"))) {

            $stmt->bind_param("ddsss", $user_info_no, $avatar_no, $user_name, $user_pass, $date);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();

            return $id;
        }

        return 0;
    }

    //get user info no
    public function get_info_no($email)
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO user_info (fullname, phone, email, date_added, date_updated) VALUES('', '', '$email', '$date', '$date')";
        $this->con->query($query);

        return $this->con->insert_id;
    }

    //get avatar no
    public function get_avatar_no()
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO avatars (is_set, date_added, date_updated) VALUES('0', '$date', '$date')";
        $this->con->query($query);

        return $this->con->insert_id;
    }

    //update avatar    
    public function updateAvatar($avatar_no, $is_set)
    {

        $date = date('Y-m-d H:i:s');

        if (($stmt = $this->con->prepare("UPDATE avatars SET is_set = ? , date_updated = ? WHERE avatar_no = ?"))) {

            $stmt->bind_param("dsd", $is_set, $date, $avatar_no);
            $stmt->execute();
            $stmt->close();

            return 1;
        }

        return -1;
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

    //login the user
    public function login($user_name, $user_pass)
    {

        //Hash the password
        $user_pass = hash('ripemd128', $user_pass);

        $pass = "";
        $no = "";

        if (($stmt = $this->con->prepare("SELECT `user_no`, `user_pass` FROM `users` WHERE `user_name` = ?"))) {

            $stmt->bind_param("s", $user_name);
            $stmt->execute();
            $stmt->store_result();
            $rows = $stmt->num_rows;

            if ($rows > 0) {
                $stmt->bind_result($no, $pass);
                $stmt->fetch();
                $stmt->close();

                if (strcmp($user_pass, $pass) == 0) {
                    return $no;
                } else {
                    return -3;
                }

            } else {
                $stmt->close();
                return -3;
            }

        }

        return -1;
    }

    //Get user info of a specific user
    public function get($user_no)
    {

        $res = array();
        $res['ok'] = 0;

        $user_info_no = $avatar_no = $user_name = $email = $date_added = "";

        if (($stmt = $this->con->prepare("SELECT `user_info_no`, `avatar_no`, `user_name`, `date_added` FROM users WHERE user_no=?"))) {

            $stmt->bind_param("d", $user_no);
            $stmt->execute();
            $stmt->bind_result($user_info_no, $avatar_no, $user_name, $date_added);

            while ($stmt->fetch()) {

                $res['ok'] = 1;
                $res['user_info_no'] = $user_info_no;
                $res['avatar_no'] = $avatar_no;
                $res['user_name'] = $user_name;
                $res['date_added'] = $date_added;
            }

            $stmt->close();
        }

        return $res;
    }

    //Get user info of a specific user
    public function get_user_info($user_info_no)
    {

        $res = array();
        $res['ok'] = 0;

        $fullname = $phone = $email = $date_added = $date_updated = "";

        if (($stmt = $this->con->prepare("SELECT `fullname`, `phone`, `email`, `date_added`, `date_updated` FROM user_info WHERE user_info_no=?"))) {

            $stmt->bind_param("d", $user_info_no);
            $stmt->execute();
            $stmt->bind_result($fullname, $phone, $email, $date_added, $date_updated);

            while ($stmt->fetch()) {

                $res['ok'] = 1;
                $res['user_info_no'] = $user_info_no;
                $res['fullname'] = $fullname;
                $res['phone'] = $phone;
                $res['email'] = $email;
                $res['date_added'] = $date_added;
                $res['date_updated'] = $date_updated;
            }

            $stmt->close();
        }

        return $res;
    }

    //Get user avatar
    public function get_user_avatar($avatar_no)
    {

        $res = array();
        $res['ok'] = 0;

        $is_set = $date_added = $date_updated = "";

        if (($stmt = $this->con->prepare("SELECT `is_set`, `date_added`, `date_updated` FROM avatars WHERE avatar_no = ?"))) {

            $stmt->bind_param("d", $avatar_no);
            $stmt->execute();
            $stmt->bind_result($is_set, $date_added, $date_updated);

            while ($stmt->fetch()) {

                $res['ok'] = 1;
                $res['avatar_no'] = $avatar_no;
                $res['is_set'] = $is_set;
                $res['date_added'] = $date_added;
                $res['date_updated'] = $date_updated;
            }

            $stmt->close();
        }

        return $res;
    }

    /**
     * @param $user_no userno for the current user
     * @param $keyword username or full name of user to be searched
     * @param $lower the index to start returning results from
     * @param $limit the no of results to be returned
     * @return array results found or response
     */
    public function search($user_no, $keyword, $lower, $limit){
        $query = "SELECT a.user_no, a.user_name, a.avatar_no, b.fullname FROM users a, user_info b WHERE (a.user_info_no = b.user_info_no AND a.user_no <> '$user_no') AND (a.user_name = '$keyword' OR b.fullname LIKE '%$keyword%') LIMIT $lower, $limit";
        $result = mysqli_query($this->con, $query);
        $response = array();
        $response['count'] = mysqli_num_rows($result);
        $counter = 0;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $response[$counter] = array(
                'user_no' => $row['user_no'],
                'user_name' => $row['user_name'],
                'avatar_no' => $row['avatar_no'],
                'fullname' => $row['fullname']
            );
            ++$counter;
        }
        return $response;
    }
}

<?php

/*
 * Class to deal with all notice transactions
 */


class Notice
{
    var $con;

    //to pass in the connection
    public function __construct($con)
    {
        $this->con = $con;
    }

    //add a new notice and return the notice no
    public function add($noticeboard_no, $type, $file_ext, $title, $desc, $date_expiry)
    {

        $response = array();
        $date = date('Y-m-d H:i:s');

        if (($stmt = $this->con->prepare("INSERT INTO notices (`noticeboard_no`, `type`, `file_ext`, `title`, `desc`, `date_expiry`, `date_added`, `date_updated`) VALUES(?,?,?,?,?,?,?,?)"))) {

            $stmt->bind_param("ddssssss", $noticeboard_no, $type, $file_ext, $title, $desc, $date_expiry, $date, $date);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();

            $response['res'] = 1;
            $response['notice_no'] = $id;
            $response['file_ext'] = $file_ext;
            $response['date'] = $date;

            return $response;
        }

        $response['res'] = 0;
        return $response;
    }

    //load all notices belonging to a particular notice
    public function load_all($noticeboard_no)
    {
        $res = array();
        $date = date('Y-m-d H:i:s');
        $query = "SELECT * FROM  `notices` WHERE  `noticeboard_no` = '$noticeboard_no' AND `date_expiry` > '$date'";
        $result = mysqli_query($this->con, $query);
        $rows = mysqli_num_rows($result);
        $res['count'] = $rows;
        $counter = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $res[$counter] = array(
                'notice_no' => $row['notice_no'],
                'noticeboard_no' => $row['noticeboard_no'],
                'type' => $row['type'],
                'file_ext' => $row['file_ext'],
                'title' => $row['title'],
                'desc' => $row['desc'],
                'date_expiry' => $row['date_expiry'],
                'date_added' => $row['date_added'],
                'date_updated' => $row['date_updated']
            );
            ++$counter;
        }
        return $res;
    }

    /**
     * Load all new and updated notices that have not yet expired
     * @param $user_no
     * @param $last_updated
     * @return array
     */
    public function load_all_new($user_no, $last_updated, $date)
    {
        $res = array();
        $query =    "SELECT b.notice_no, a.noticeboard_no, b.type, b.file_ext, b.title, b.desc, b.date_expiry, b.date_added, b.date_updated ".
                    "FROM followers a, notices b ".
                    "WHERE a.user_no = '$user_no' AND a.followed = 1 AND a.noticeboard_no = b.noticeboard_no AND b.date_updated > '$last_updated' AND b.date_expiry > '$date'";
        $result = mysqli_query($this->con, $query);
        $rows = mysqli_num_rows($result);
        $res['count'] = $rows;
        $counter = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $res[$counter] = array(
                'notice_no' => $row['notice_no'],
                'noticeboard_no' => $row['noticeboard_no'],
                'type' => $row['type'],
                'file_ext' => $row['file_ext'],
                'title' => $row['title'],
                'desc' => $row['desc'],
                'date_expiry' => $row['date_expiry'],
                'date_added' => $row['date_added'],
                'date_updated' => $row['date_updated']
            );
            ++$counter;
        }
        return $res;
    }

}

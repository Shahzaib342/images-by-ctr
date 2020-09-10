<?php


namespace Inc\Models;
include '../vendor/autoload.php';

use Inc\Conf\Conf as DB;


/**
 *
 * @type {{Created by Shahzaib 07 Sep,2020}}
 */
class Images
{
    private $conn;

    //construct function to initialize DB Connection
    function __construct($api = false)
    {
        $this->conn = DB::connectMe();
    }

    //get image data by highest CTR
    function getImage()
    {
        $sql = "SELECT ID, MAX(CTR) as CTR, HITS, CLICKS, URL  FROM best WHERE VIEWED=0 group by CTR desc limit 1";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //update view and hit status of a image once image is viewed
    function updateViewStatus($id)
    {
        $VIEWED = 1;
        $SQL = $this->conn->prepare("UPDATE best SET VIEWED=?, HITS = HITS + 1 WHERE ID=?");
        $SQL->bind_param('ss', $VIEWED, $id);
        $SQL->execute();
        if ($SQL->error) {
            return false;
        } else {
            $ctr = $this->updateCTR($id);
            if ($ctr) { //reset v
                return $this->resetViewStatus();
            } else {
                return false;
            }
        }
    }

    //update CTR after image is viewed or clicked
    public function updateCTR($id)
    {
        $SQL = $this->conn->prepare("UPDATE best SET CTR= ( CLICKS/HITS * 100) WHERE ID=?");
        $SQL->bind_param('s', $id);
        $SQL->execute();
        if ($SQL->error) {
            return false;
        }
        return true;
    }

    //reset view status once all images viewed
    public function resetViewStatus()
    {
        $sql = "SELECT id FROM best WHERE VIEWED=0";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 0) {
            $viewed = 0;
            $SQL = $this->conn->prepare("UPDATE best SET VIEWED= ?");
            $SQL->bind_param('s', $viewed);
            $SQL->execute();
            if ($SQL->error) {
                return false;
            }
            return true;
        }
        return true;
    }

    //update clicks after image is clicked
    function updateClicks($id)
    {
        $SQL = $this->conn->prepare("UPDATE best set CLICKS=CLICKS + 1 where id = ?");
        $SQL->bind_param('s', $id);
        $SQL->execute();
        if ($SQL->error) {
            return false;
        } else {
            return $this->updateCTR($id);
        }
    }


    //destroy DB connection in destruct function
    function __destruct()
    {
        $this->conn = NULL;
    }
}

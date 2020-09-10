<?php

namespace Inc\Conf;

/**
 *
 * @type {{Created by Shahzaib 07 Sep,2020}}
 */

class Conf
{

    function connectMe()
    {
        $serverName = "localhost";
        $username = "root";
        $password = "";
        $db = "show_best";
        /* Attempt to connect to MySQL database */
        $link = mysqli_connect($serverName, $username, $password, $db);
        // Check connection
        if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        } else
            return $link;
    }
}
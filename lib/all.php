<?php
include '../vendor/autoload.php';

use Inc\Models\Images as Images;

/**
 *
 * @type {{Created by Shahzaib 07 Sep, 2020}}
 */
$action = (isset($_GET['action'])) ? $_GET['action'] : die('Nothing to do');


$actions = array();
array_push($actions, array('name' => 'getImage', 'action' => 'getImage'));
array_push($actions, array('name' => 'updateStatus', 'action' => 'updateStatus'));
array_push($actions, array('name' => 'updateClicks', 'action' => 'updateClicks'));

// Go through the actions list and run the associated functions
foreach ($actions as $act) {
    if ($act['name'] == $action) {
        $functionName = $act['action'] . '();';

        eval($functionName);
    }
}

//get image by highest CTR
function getImage()
{
    $obj = new Images();
    $image = $obj->getImage();
    echo json_encode(['data' => $image]);
}

//update image status viewed
function updateStatus()
{
    $obj = new Images();
    $status = $obj->updateViewStatus($_GET['id']);
    echo json_encode(['data' => $status]);
}

//update clicks after image is clicked
function updateClicks()
{
    $obj = new Images();
    $update = $obj->updateClicks($_GET['id']);
    echo json_encode(['data' => $update]);
}
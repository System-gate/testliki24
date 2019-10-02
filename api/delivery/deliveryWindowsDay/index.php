<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 02.10.2019
 * Time: 1:00
 */

header('Content-Type: application/json; charset=UTF-8');

require_once ('../../../delivery/DeliveryWindowsDay.php');
$DeliveryWindowsDay = new DeliveryWindowsDay();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    if($data['method'] === 'add'){
        if(!empty($data['$id']) && !empty($data['$day'])){
            $DeliveryWindowsDay->addWindowsDay($data['id'], $data['day']);
            exit();
        }
    }
    elseif ($data['method'] === 'get'){
        if(!empty($data['day'])){
            exit(json_encode(array_values($DeliveryWindowsDay->getWindowsDayWithInfo($data['day']))));
        }
    }
    elseif ($data['method'] === 'delete'){
        if(!empty($data['id'])){
            $DeliveryWindowsDay->deleteWindowsDay($data['id']);
            exit();
        }
    }
    elseif ($data['method'] === 'update'){
        $DeliveryWindowsDay->updateDeliveryInfo($data['data']);
        exit();
    }
}
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
            $deliveryWindowsError = $DeliveryWindowsDay->addWindowsDay($data['id'], $data['day']);
        }
    }
    elseif ($data['method'] === 'get'){
        if(!empty($data['day'])){
            $deliveryWindowsArray = $DeliveryWindowsDay->getWindowsDayWithInfo($data['day']);
            if(!empty($deliveryWindowsArray['error'])){
                http_response_code(400);
                die(json_encode($deliveryWindowsArray));
            }
            else {
                http_response_code(200);
                exit(json_encode(array_values($deliveryWindowsArray)));
            }
        }
    }
    elseif ($data['method'] === 'delete'){
        if(!empty($data['id'])){
            $deliveryWindowsError = $DeliveryWindowsDay->deleteWindowsDay($data['id']);
        }
    }
    elseif ($data['method'] === 'update'){
        $deliveryWindowsError = $DeliveryWindowsDay->updateDeliveryInfo($data['data']);
    }
    if(!empty($deliveryWindowsError['error'])){
        http_response_code(400);
        die(json_encode($deliveryWindowsError));
    }
    else {
        http_response_code(200);
        exit();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 02.10.2019
 * Time: 0:58
 */

header('Content-Type: application/json; charset=UTF-8');

require_once ('../../../delivery/DeliveryWindows.php');
$DeliveryWindows = new DeliveryWindows();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $deliveryWindowsArray = $DeliveryWindows->getWindows();
    if(!empty($deliveryWindowsArray['error'])){
        http_response_code(400);
        die(json_encode($deliveryWindowsArray));
    }
    else {
        http_response_code(200);
        exit(json_encode(array_values($deliveryWindowsArray)));
    }

}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    if($data['method'] === 'add'){
        if(!empty($data['name']) && !empty($data['description']) && !empty($data['start']) && !empty($data['finish']) && !empty($data['type'])){
            $deliveryWindowsError = $DeliveryWindows->addWindow($data['name'], $data['description'], $data['start'], $data['finish'], $data['type']);

        }
    }
    elseif ($data['method'] === 'delete'){
        if(!empty($data['id'])){
            $deliveryWindowsError = $DeliveryWindows->deleteWindow($data['id']);
        }
    }
    elseif ($data['method'] === 'update'){
        if(!empty($data['id']) && !empty($data['name']) && !empty($data['description']) && !empty($data['start']) && !empty($data['finish']) && !empty($data['type'])){
            $deliveryWindowsError = $DeliveryWindows->updateWindow($data['id'], $data['name'], $data['description'], $data['start'], $data['finish'], $data['type']);
        }
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
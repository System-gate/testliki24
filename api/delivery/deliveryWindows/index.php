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
    exit(json_encode(array_values($DeliveryWindows->getWindows())));
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    if($data['method'] === 'add'){
        if(!empty($data['name']) && !empty($data['description']) && !empty($data['start']) && !empty($data['finish']) && !empty($data['type'])){
            $DeliveryWindows->addWindow($data['name'], $data['description'], $data['start'], $data['finish'], $data['type']);
            exit();
        }
    }
    elseif ($data['method'] === 'delete'){
        if(!empty($data['id'])){
            $DeliveryWindows->deleteWindow($data['id']);
            exit();
        }
    }
    elseif ($data['method'] === 'update'){
        if(!empty($data['id']) && !empty($data['name']) && !empty($data['description']) && !empty($data['start']) && !empty($data['finish']) && !empty($data['type'])){
            $DeliveryWindows->updateWindow($data['id'], $data['name'], $data['description'], $data['start'], $data['finish'], $data['type']);
        }
    }
}
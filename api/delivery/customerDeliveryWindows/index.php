<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 02.10.2019
 * Time: 1:00
 */

header('Content-Type: application/json; charset=UTF-8');

require_once ('../../../delivery/CustomerDeliveryWindows.php');
$CustomerDeliveryWindows = new CustomerDeliveryWindows();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if(!empty($data['currentDate']) && !empty($data['horizon'])){
        $customerDeliveryWindowsArray = $CustomerDeliveryWindows->getCustomerDeliveryWindows($data['currentDate'], $data['horizon']);
        if(!empty( $customerDeliveryWindowsArray['error'])){
            http_response_code(400);
            die(json_encode( $customerDeliveryWindowsArray));
        }
        else {
            http_response_code(200);
            exit(json_encode(array_values( $customerDeliveryWindowsArray)));
        }
    }
}
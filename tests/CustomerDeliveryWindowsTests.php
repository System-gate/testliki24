<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 08.10.2019
 * Time: 8:42
 */

require_once ('../delivery/CustomerDeliveryWindows.php');
use PHPUnit\Framework\TestCase;

class CustomerDeliveryWindowsTests extends TestCase
{
    public function testNotExpressDelivery(){
        $CustomerDeliveryWindows = new CustomerDeliveryWindows();
        $date = new DateTime('2019-08-10 23:59:00');
        $testDate = $date->format('Y-m-d H:i:s');
        $horizon = 2;
        $this->assertNotContains(['name' => 'Express delivery', 'description' => 'lorem ipsum', 'start' => '0000-00-00 07:00:00', 'finish' => '0000-00-00 21:00:00', 'price' => 100, 'type' => 'express', 'available' => 1], $CustomerDeliveryWindows->getCustomerDeliveryWindows($testDate, $horizon));
    }

    public function testDBError(){
        $CustomerDeliveryWindows = new CustomerDeliveryWindows();
        $horizon = 2;
        $this->assertArrayHasKey('error', $CustomerDeliveryWindows->getCustomerDeliveryWindows(strtotime('2019-08-10 23:59:00'), $horizon));
    }

    public function testType(){
        $CustomerDeliveryWindows = new CustomerDeliveryWindows();
        $date = new DateTime('2019-08-10 23:59:00');
        $testDate = $date->format('Y-m-d H:i:s');
        $horizon = 2;
        $this->assertContainsOnly('array', $CustomerDeliveryWindows->getCustomerDeliveryWindows($testDate, $horizon));
    }
}

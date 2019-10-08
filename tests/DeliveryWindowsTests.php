<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 08.10.2019
 * Time: 8:42
 */

require_once ('../delivery/DeliveryWindows.php');
use PHPUnit\Framework\TestCase;

class DeliveryWindowsTests extends TestCase
{
    public function testAddError(){
        $DeliveryWindows = new DeliveryWindows();
        $this->assertArrayHasKey('error', $DeliveryWindows->addWindow('name', 'desc', strtotime('2019-08-10 23:59:00'), strtotime('2019-08-10 23:59:00'), 2));
    }
}
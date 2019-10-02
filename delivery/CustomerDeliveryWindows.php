<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 02.10.2019
 * Time: 0:41
 */

class CustomerDeliveryWindows
{
    /**
     * @var \Medoo\Medoo|null
     */
    private $db = null;

    /**
     * @var array
     */
    private $deliveryWindows = [['name' => 'Express delivery', 'description' => 'lorem ipsum', 'start' => '0000-00-00 00:00:00', 'finish' => '0000-00-00 00:00:00', 'price' => 100, 'type' => 'express', 'available' => 1]];

    /**
     * CustomerDeliveryWindows constructor.
     */
    public function __construct()
    {
        require_once ('../config/Database.php');
        $Database = new Database();
        $this->db = $Database->conn;
    }

    /**
     * @param datetime $currentDate
     * @param int $horizon
     * @return array
     */
    public function getCustomerDeliveryWindows($currentDate, $horizon){
        for($i = 0; $i < $horizon; $i++) {
            $dayWindows = $this->getWindowsDay(date('D', strtotime($currentDate)));
            $this->customerWindows($currentDate, $dayWindows, $i);
        }
        return $this->deliveryWindows;
    }

    private function getWindowsDay($day){
        $windowsDay = $this->db->select('delivery_windows_day', ['[>]delivery_info' => ['id' => 'delivery_windows_day_id'], '[>]delivery_windows' => ['delivery_windows_id', 'id']], ['delivery_windows_day.id', 'windowInfo' => ['delivery_windows.*'], 'deliveryInfo' => ['delivery_info.price', 'delivery_info.delay', 'delivery_info.available']], ['delivery_windows_day.day_of_the_week' => $day]);
        if(!empty($this->db->error())){
            http_response_code(400);
            die($this->db->error());
        }
        return $windowsDay;
    }

    private function customerWindows($currentDate, $dayWindows, $currentHorizon){
        foreach ($dayWindows as $dayWindow){
            if($dayWindow['deliveryInfo']['available'] == true){
                $start = strtotime(date('Y-m-d', strtotime($currentDate))) + strtotime($dayWindow['windowInfo']['start']) + $currentHorizon * 24 * 60 * 60;
                $finish = strtotime(date('Y-m-d', strtotime($currentDate))) + strtotime($dayWindow['windowInfo']['finish']) + $currentHorizon * 24 * 60 * 60;
                if((strtotime($currentDate) + strtotime($dayWindow['deliveryInfo']['delay'])) <= ($start)){
                    $available = 1;
                }
                else {
                    $available = 0;
                }
                $this->deliveryWindows[] = ['name' => $dayWindow['windowInfo']['name'], 'description' => $dayWindow['windowInfo']['description'], 'start' => $start, 'finish' => $finish, 'price' => $dayWindow['deliveryInfo']['price'], 'type' => $dayWindow['windowInfo']['type'], 'available' => $available];
            }
        }
    }
}
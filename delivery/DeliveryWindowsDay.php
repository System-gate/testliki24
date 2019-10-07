<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 01.10.2019
 * Time: 21:12
 */

class DeliveryWindowsDay
{
    /**
     * @var \Medoo\Medoo|null
     */
    private $db = null;

    /**
     * DeliveryWindowsDay constructor.
     */
    public function __construct()
    {
        require_once ('../config/Database.php');
        $Database = new Database();
        $this->db = $Database->conn;
    }

    /**
     * @param int $id
     * @param string $day
     * @return array|false
     */
    public function addWindowsDay($id, $day){
        if($this->db->has('delivery_windows', ['id' => $id]) && !$this->db->has('delivery_windows_day', ['delivery_windows_id' => $id])){
            $this->db->insert('delivery_windows_day', ['delivery_windows_id' => $id, 'day_of_the_week' => $day]);
            $this->db->insert('delivery_info', ['delivery_windows_day_id' => $this->db->id()]);
            if(!empty($this->db->error())){
                return ['error' => $this->db->error()];
            }
        }
        return false;
    }

    /**
     * @param int $id
     * @return array|false
     */
    public function deleteWindowsDay($id){
        if($this->db->has('delivery_windows_day', ['id' => $id])) {
            $this->db->delete('delivery_windows_day', ['id' => $id]);
            $this->db->delete('delivery_info', ['delivery_windows_day_id' => $id]);
            if(!empty($this->db->error())){
                return ['error' => $this->db->error()];
            }
        }
        return false;
    }

    /**
     * @param array $deliveryInfos
     * @return array|false
     */
    public function updateDeliveryInfo($deliveryInfos){
        foreach ($deliveryInfos as $deliveryInfo){
            $this->db->update('delivery_info', ['price' => $deliveryInfo['price'], 'delay' => $deliveryInfo['price'], 'available' => $deliveryInfo['available'], ['delivery_windows_day_id' => $deliveryInfo['id']]]);
            if(!empty($this->db->error())){
                return ['error' => $this->db->error()];
            }
        }
        return false;
    }

    /**
     * @param string $day
     * @return array|bool
     */
    public function getWindowsDayWithInfo($day){
        $windowsDayWithInfo = $this->db->select('delivery_windows_day', ['[>]delivery_info' => ['id' => 'delivery_windows_day_id'], '[>]delivery_windows' => ['delivery_windows_id', 'id']], ['delivery_windows_day.id', 'delivery_windows.name', 'delivery_info.price', 'delivery_info.delay', 'delivery_info.available'], ['delivery_windows_day.day_of_the_week' => $day]);
        if(!empty($this->db->error())){
            return ['error' => $this->db->error()];
        }
        return $windowsDayWithInfo;
    }
}
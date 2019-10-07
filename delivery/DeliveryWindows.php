<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 01.10.2019
 * Time: 20:06
 */

class DeliveryWindows
{

    /**
     * @var \Medoo\Medoo|null
     */
    private $db = null;

    /**
     * DeliveryWindows constructor.
     */
    public function __construct()
    {
        require_once ('../config/Database.php');
        $Database = new Database();
        $this->db = $Database->conn;
    }

    /**
     * @param string $name
     * @param string $description
     * @param datetime $start
     * @param datetime $finish
     * @param string $type
     * @return array|false
     */
    public function addWindow($name, $description, $start, $finish, $type){
        $this->db->insert('delivery_windows', ['name' => $name, 'description' => $description, 'start' => $start, 'finish' => $finish, 'type' => $type]);
        if(!empty($this->db->error())){
            return ['error' => $this->db->error()];
        }
        return false;
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param datetime $start
     * @param datetime $finish
     * @param string $type
     * @return array|false
     */
    public function updateWindow($id, $name, $description, $start, $finish, $type){
        if($this->db->has('delivery_windows', ['id' => $id])) {
            $this->db->update('delivery_windows', ['name' => $name, 'description' => $description, 'start' => $start, 'finish' => $finish, 'type' => $type], ['id' => $id]);
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
    public function deleteWindow($id){
        if($this->db->has('delivery_windows', ['id' => $id])) {
            $this->db->delete('delivery_windows', ['id' => $id]);
            $deliveryWindowsDayIds = $this->db->select('delivery_windows_day', 'id', ['delivery_windows_id' => $id]);
            if(!empty($deliveryWindowsDayIds)) {
                foreach ($deliveryWindowsDayIds as $deliveryWindowsDayId) {
                    if($this->db->has('delivery_info', ['delivery_windows_day_id' => $deliveryWindowsDayId])) {
                        $this->db->delete('delivery_info', ['delivery_windows_day_id' => $deliveryWindowsDayId]);
                    }
                }
                $this->db->delete('delivery_windows_day', ['delivery_windows_id' => $id]);
            }
            if(!empty($this->db->error())){
                return ['error' => $this->db->error()];
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function getWindows(){
        $windows = $this->db->select('delivery_windows', '*');
        if(!empty($this->db->error())){
            return ['error' => $this->db->error()];
        }
        return $windows;
    }
}
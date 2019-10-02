<?php
/**
 * Created by PhpStorm.
 * User: shevl
 * Date: 16.10.2018
 * Time: 01:24
 */

class Database
{

    // specify your own database credentials
    private $host = "shevlyak.mysql.tools";
    private $db_name = "shevlyak_liki24";
    private $username = "shevlyak_liki24";
    private $password = "mv3S%45^Fb";
    public $conn;

    // get the database connection
    public function __construct()
    {

        require __DIR__.'/../vendor/autoload.php';
        $this->conn = new Medoo\Medoo([
            'charset' => 'utf8',
            'database_type' => 'mysql',
            'database_name' => $this->db_name,
            'server' => $this->host,
            'username' => $this->username,
            'password' => $this->password
        ]);
    }
}
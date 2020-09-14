<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 2:22 μμ
 */

namespace SinHelper\Models;

use SinHelper\Config\ConstantMapper;
use \PDO;

/**
 * You can ovveride this with w/e connection DB you want
 * Class BaseModel
 * @package SinHelper\Models
 */

class BaseModel
{
    public $db;
    public $prefix;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $dsn = "mysql:host=" . ConstantMapper::DB_HOSTNAME . ";dbname=" . ConstantMapper::DB_DATABASE . ';charset=utf8;';
        $this->db = new PDO($dsn, ConstantMapper::DB_USERNAME, ConstantMapper::DB_PASSWORD, $options);
        $this->prefix = ConstantMapper::DB_PREFIX;
    }

    /**
     * @param string $query
     * @param array $preparedVals
     * @return bool|\PDOStatement
     */
    public function query(string $query, array $preparedVals = [])
    {
        $q = $this->db->prepare($query);
        $q->execute($preparedVals);
        return $q;
    }

    /**
     * @param string $query
     * @param array $preparedVals
     * @return array
     */
    public function prepareAndFetch(string $query, array $preparedVals = [])
    {

        return $this->query($query, $preparedVals)->fetchAll();
    }

    /**
     * @param string $query
     * @param array $preparedVals
     * @return mixed
     */
    public function prepareAndFetchOne(string $query, array $preparedVals = [])
    {
        return $this->query($query, $preparedVals)->fetch();

    }
}
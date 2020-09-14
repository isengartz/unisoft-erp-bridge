<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 14/9/2020
 * Time: 1:54 μμ
 */


namespace SinHelper\Scripts;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('../../vendor/autoload.php');


use SinHelper\adapter\CustomerAdapter;
use \SinHelper\Mappers\CustomerMapper;
use \SinHelper\CustomerRequestHelper;
use \SinHelper\Models\CustomerModel;

echo "<pre>";


$customerHelper = new CustomerRequestHelper();
$customerHelper->generateSessionId();
$customerMapper = new CustomerMapper();
$customerModel = new CustomerModel();
$customerAdapter = new CustomerAdapter();

$customerSyncer = new SyncCustomers($customerHelper, $customerModel, $customerMapper, $customerAdapter);

$customerSyncer->syncOne(232);

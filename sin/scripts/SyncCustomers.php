<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 14/9/2020
 * Time: 1:24 μμ
 */

namespace SinHelper\Scripts;

use SinHelper\adapter\CustomerAdapter;
use SinHelper\CustomerRequestHelper;
use SinHelper\mappers\CustomerMapper;
use SinHelper\models\CustomerModel;

class SyncCustomers
{
    private $helper;
    private $mapper;
    private $adapter;
    private $model;


    public function __construct(CustomerRequestHelper $helper, CustomerModel $customerModel, CustomerMapper $customerMapper, CustomerAdapter $customerAdapter)
    {
        $this->helper = $helper;
        $this->model = $customerModel;
        $this->mapper = $customerMapper;
        $this->adapter = $customerAdapter;
    }

    public function syncAll() {
        $customers = $this->model->getCustomers();
        foreach ($customers as $customer) {
          $result = $this->syncOne($customer->customer_id);
        }

    }

    public function syncOne($id) {

        $customer= $this->model->getCustomer($id);

        return $this->syncService($this->helper->objToArray($customer),false);

    }


    private function syncService(array $data, bool $multiple=true) {
        // Adapt the Fields
        $data = $this->adapter->adaptEntity($data);
        // Remove all the unused fields
        $allowedFields = $this->mapper->clean($data);
        // Map Base Data
        $mappedFields = $this->mapper->map($allowedFields, $this->mapper::BASE_DATA);
        // if we have a single one we need to put in in an array
       return $this->helper->createRequest($multiple ? $mappedFields : [$mappedFields]);

    }
}
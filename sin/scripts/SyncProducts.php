<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 2:14 μμ
 */

namespace SinHelper\Scripts;

use SinHelper\adapter\ProductAdapter;
use SinHelper\Mappers\ProductMapper;
use SinHelper\Models\ProductModel;
use SinHelper\ProductRequestHelper;

class SyncProducts
{

    private $helper;
    private $model;
    private $mapper;
    private $adapter;

    public function __construct(ProductRequestHelper $helper, ProductModel $productModel, ProductMapper $productMapper, ProductAdapter $productAdapter)
    {
        $this->helper = $helper;
        $this->model = $productModel;
        $this->mapper = $productMapper;
        $this->adapter = $productAdapter;
    }


    public function syncOne(int $productId)
    {
        try {
            $product = $this->model->getProduct($productId);
            $categories = $this->model->getProductMainCategory($product->product_id);
            $product->website_category_id = $categories["category_id"];
            $product->website_category_name = $categories["name"];


            if (!$product) {
                throw new \Exception("Product with id: {$productId} Not found.", 404);
            }
         return $this->syncService($this->helper->objToArray($product),false);


        } catch (\Exception $e) {
            $this->helper->logError($e->getMessage());
        }

    }

    private function syncService(array $data, bool $multiple=true) {
        // Remove all the unused fields
        $allowedFields = $this->mapper->clean($data);
        // Adapt the allowed fields
        $allowedFields = $this->adapter->adaptEntity($allowedFields);

        // Map Base Data
        $mappedFields = $this->mapper->map($allowedFields, $this->mapper::BASE_DATA);
        $mappedFields = $this->mapper->mapProductSpecialFields($mappedFields);

        // if we have a single one we need to put in in an array
       return $this->helper->createRequest($multiple ? $mappedFields : [$mappedFields]);


    }
}
<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 2:30 μμ
 */


namespace SinHelper\Scripts;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('../../vendor/autoload.php');


use SinHelper\adapter\ProductAdapter;
use \SinHelper\Mappers\ProductMapper;
use \SinHelper\ProductRequestHelper;
use \SinHelper\Models\ProductModel;

echo "<pre>";

// Dependencies
$productHelper = new ProductRequestHelper();
$productHelper->generateSessionId();
$productModel = new ProductModel();
$productMapper = new ProductMapper();
$productAdapter = new ProductAdapter();

// Init the Syncer
$productSyncer = new SyncProducts($productHelper, $productModel, $productMapper, $productAdapter);
$productSyncer->syncOne(228);


//echo "<pre>";
//var_dump($productModel->getProducts());
//var_dump($productModel->getProduct(262));

echo 'test';
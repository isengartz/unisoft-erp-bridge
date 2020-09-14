<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 2:20 μμ
 */

namespace SinHelper\Models;

/**
 * You should adapt the queries based on the CMS/App
 * Class ProductModel
 * @package SinHelper\Models
 */
class ProductModel extends BaseModel
{
    /**
     * Return All Products
     * @return array
     */
    public function getProducts(): array
    {
        $prefix = $this->prefix;

        $sql = "SELECT prod.*,pdesc.* from {$prefix}product as prod 
                left join {$prefix}product_description as pdesc
                on prod.product_id = pdesc.product_id
                
                    ";
        return $this->prepareAndFetch($sql);

    }

    /**
     * @param int $id
     * @return array
     */
    public function getProduct(int $id)
    {
        $prefix = $this->prefix;

        $sql = "SELECT prod.*,pdesc.*,spcl.price as special_price from {$prefix}product as prod 
                left join {$prefix}product_description as pdesc
                on prod.product_id = pdesc.product_id 
                LEFT JOIN {$prefix}product_special as spcl 
                on prod.product_id = spcl.product_id
                WHERE prod.product_id=?
                    ";
        return $this->prepareAndFetchOne($sql, [$id]);
    }


    public function getAllProductCategories()
    {
        $prefix = $this->prefix;
        $sql = "SELECT category_id,name from {$prefix}category_description";

        return $this->prepareAndFetch($sql);

    }


    public function getProductCategories($product_id)
    {
        $prefix = $this->prefix;
        $sql = "SELECT pc.category_id,pc.name,c.parent_id from {$prefix}category_description as pc
                LEFT JOIN {$prefix}product_to_category as ptc
                ON ptc.category_id = pc.category_id
                LEFT JOIN {$prefix}category as c 
                ON c.category_id = pc.category_id
                WHERE ptc.product_id= ?
                ORDER BY c.sort_order";

        return $this->prepareAndFetch($sql, [$product_id]);

    }

    /**
     * Returns an Array with ID and Name
     * @param $product_id
     * @return array
     */
    public function getProductMainCategory($product_id) : array
    {
        $cat = ["category_id" => null, "name" => null];
        $categories = $this->getProductCategories($product_id);
        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $cat = ["category_id" => $category->category_id, "name" => $category->name];
                break;

            }
        }
        return $cat;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 10/9/2020
 * Time: 4:03 μμ
 */

namespace SinHelper\adapter;


use SinHelper\Config\ConstantMapper;

class ProductAdapter extends AbstractAdapter
{
    public function adaptEntity(array $fields): array
    {
        $adapted = $fields;

        $adapted["image"] = $this->adaptPathToUrl(ConstantMapper::WEBSITE_BASE_URL,$fields["image"]);
        $adapted["price"] = $this->adaptFloat($fields["price"]);
        $adapted["special_price"] = $this->adaptFloat($fields["special_price"]);

        return $adapted;
    }
}
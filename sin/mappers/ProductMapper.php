<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 5:02 μμ
 */

namespace SinHelper\Mappers;


/**
 * Override these fields with CMS ones
 * Class ProductMapper
 * @package SinHelper\Mappers
 */
class ProductMapper extends AbstractMapper
{

    const ALLOWED_DATA = [
        "product_id",
        "model",
        "image",
        "tax_class_id",
        "price",
        "special_price",
        "website_category_id",
        "website_category_name"
    ];

    const BASE_DATA = [
        "product_id" => "relcode",
        "model" => "code",
        "image" => "webpicture",
        "tax_class_id" => "vatid",
        "price" => "rtlprice",
        "special_price" => "webdiscount",
        "website_category_id" => "wctid",
        "website_category_name" => "wctdescr"

    ];

    /**
     * Maps the VALUES of product fields
     * @param array $fields
     * @return array
     */
    public function mapProductSpecialFields($fields = [])
    {

        $fields["vatid"] = $this->mapVatIds($fields["vatid"]);
        $fields["webrtlprice"] = $fields["rtlprice"];
        $fields["webactive"] = true;

        return $fields;
    }


    /**
     * Maps the Eshop Ids with the ERP IDs
     * @param $vat
     * @return int | null
     */
    public function mapVatIds($vat): ?int
    {
        if (!$vat) {
            return null;
        }
        switch ($vat) {
            case 9 :
                return 1;
            default :
                return 1;
        }
    }

}
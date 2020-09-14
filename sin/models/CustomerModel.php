<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 14/9/2020
 * Time: 10:36 πμ
 */

namespace SinHelper\models;


class CustomerModel extends BaseModel
{
    public function getCustomer(int $id)
    {
        $prefix = $this->prefix;

        $sql = "SELECT c.*,ad.address_1,ad.city,ad.postcode,ad.country_id,ad.zone_id,ctr.name as country_name,zn.name as zone_name from {$prefix}customer as c
                LEFT JOIN {$prefix}address as ad
                ON c.customer_id=ad.customer_id
                LEFT JOIN {$prefix}country as ctr
                ON ctr.country_id = ad.country_id
                LEFT JOIN {$prefix}zone as zn
                ON zn.zone_id=ad.zone_id  WHERE c.customer_id=?";
        return $this->prepareAndFetchOne($sql, [$id]);
    }

    public function getCustomers()
    {
        $prefix = $this->prefix;

        $sql = "SELECT c.*,ad.address_1,ad.city,ad.postcode,ad.country_id,ad.zone_id,ctr.name as country_name,zn.name as zone_name from {$prefix}customer as c
                LEFT JOIN {$prefix}address as ad
                ON c.customer_id=ad.customer_id
                LEFT JOIN {$prefix}country as ctr
                ON ctr.country_id = ad.country_id
                LEFT JOIN {$prefix}zone as zn
                ON zn.zone_id=ad.zone_id ";
        return $this->prepareAndFetch($sql);
    }
}
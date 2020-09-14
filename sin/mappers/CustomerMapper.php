<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 14/9/2020
 * Time: 1:24 μμ
 */

namespace SinHelper\mappers;


class CustomerMapper extends AbstractMapper
{
    const ALLOWED_DATA = [
        "customer_id",
        "firstname",
        "lastname",
        "email",
        "telephone",
        "city_name",
        "country_name",
//        "zone_name",
        "address_1",
        "postcode",
//        "cusdescr"

    ];

    const BASE_DATA = [
        "customer_id" => "code",
        "country_name" => "cntdescr",
        "address_1" => "address",
        "postcode" => "zipcode",
        "city_name" => "city",
//        "zone_name" =>"geocode",
        "telephone" => "phone",
        "email" => "email",
        "cusdescr" => "cusdescr"

    ];
}
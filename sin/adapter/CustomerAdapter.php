<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 14/9/2020
 * Time: 1:24 μμ
 */

namespace SinHelper\adapter;


class CustomerAdapter extends AbstractAdapter
{
    public function adaptEntity(array $fields): array
    {
        $adapted = $fields;

        $adapted["cusdescr"] = $fields["lastname"] .' '. $fields["firstname"];


        return $adapted;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 5:00 μμ
 */

namespace SinHelper\Mappers;

/**
 * Used to Map columns from one table to other
 * Class AbstractMapper
 * @package SinHelper\Mappers
 */
abstract class AbstractMapper
{
    const ALLOWED_DATA = [];

    const BASE_DATA = [];


    /**
     * Clean the data leaving only the allowed fields
     * @return array
     */
    public function clean(array $array): array
    {
        $allowed = [];
        foreach ($array as $key => $val) {
            if (in_array($key, static::ALLOWED_DATA)) {
                $allowed[$key] = $val;
            }
        }
        return $allowed;
    }


    /**
     * Return a new array with the keys of the Mapper Array
     *
     * @param array $data
     * @param array $mapperData
     * @return array
     */
    public function map(array $data, array $mapperData): array
    {
        $result = [];

        foreach ($data as $key => $val) {

            if (in_array($key, array_keys($mapperData))) {
                $result[$mapperData[$key]] = $val;
            }
        }
        return $result;
    }


}
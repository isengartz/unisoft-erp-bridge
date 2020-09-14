<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 10/9/2020
 * Time: 4:03 μμ
 */

namespace SinHelper\adapter;

/**
 * Used so we can adapt the fields for the destination
 * Class AbstractAdapter
 * @package SinHelper\adapter
 */
abstract class AbstractAdapter
{

    /**
     * Adapt var as Integer
     * @param $var
     * @return int|null
     */
    public function adaptInt($var): ?int
    {
        return parseInt($var);
    }

    /**
     * Adapt var as Float
     * @param $var
     * @return float|null
     */
    public function adaptFloat($var): ?float
    {
        return floatval($var);
    }

    /**
     * Adapt var as String
     * @param $var
     * @return null|string
     */
    public function adaptString($var): ?string
    {
        return (string)$var;
    }

    /**
     * Attach Url before path
     * @param string $url
     * @param string $path
     * @return null|string
     */
    public function adaptPathToUrl(string $url, string $path): ?string
    {
        return $url . $path;
    }

    /**
     * Extend it and add the adapt logic inside
     * @param array $fields
     * @return array
     */
    abstract function adaptEntity(array $fields): array;
}
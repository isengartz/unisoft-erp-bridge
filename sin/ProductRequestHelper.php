<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 9/9/2020
 * Time: 12:54 μμ
 */

namespace SinHelper;


use SinHelper\Config\ConstantMapper;

class ProductRequestHelper extends RequestHelper
{
    const ENTITY_NAME = "STOCKITEMS";
    const DEFAULT_SELECT_FIELDS = ["id", "code", "relcode"];

    /**
     * Select products ( specific fields only ) from ERP
     * @param array $fields
     * @return object
     */
    public function getRequest($fields = []): object
    {


        $jsonFields=$this->getRequestInitializer($fields);

        $payload = $this->makeHttpJsonCall('POST', ConstantMapper::API_BASE_URL, $jsonFields);

        /**
         * todo: add implementation
         */
    }

    /**
     * Add a new Product to ERP
     * @param $jsonData
     */
    public function createRequest($jsonData)
    {
        try {

            $jsonFields=$this->createRequestInitializer($jsonData);
            $payload = $this->makeHttpJsonCall('POST', ConstantMapper::API_BASE_URL, $jsonFields);

            // For some reason they return 2 different type of messages
            // Need to check for both of them
            if (!empty($payload["errormessage"])) {
                throw new \Exception($payload["errormessage"]);
            }

            if (!empty($payload[static::ENTITY_NAME][0]["errormessage"])) {
                throw new \Exception($payload[static::ENTITY_NAME][0]["errormessage"]);
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return $this->buildErrorPayload($payload["statusCode"],$e->getMessage());
        }

        return $this->buildSuccessPayload($payload["statusCode"]);

    }
}
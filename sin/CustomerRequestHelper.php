<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 14/9/2020
 * Time: 10:38 πμ
 */

namespace SinHelper;
use SinHelper\Config\ConstantMapper;


class CustomerRequestHelper extends RequestHelper
{
    const ENTITY_NAME = "CUSTOMERS";
    const DEFAULT_SELECT_FIELDS = ["id", "code", "relcode"];

    public function getRequest(array $fields = []): object
    {

        $jsonFields=$this->getRequestInitializer($fields);
        $payload = $this->makeHttpJsonCall('POST', ConstantMapper::API_BASE_URL, $jsonFields);
        /**
         * @todo: add Implementation
         */
    }

    public function createRequest(array $jsonData): array
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
            return $this->buildErrorPayload($payload["errorcode"] && null,$e->getMessage());

        }
        return $this->buildSuccessPayload($payload["statusCode"]);

    }
}
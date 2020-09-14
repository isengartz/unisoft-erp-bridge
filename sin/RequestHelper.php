<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 8/9/2020
 * Time: 5:05 μμ
 */

namespace SinHelper;

use GuzzleHttp\Client;
use SinHelper\Config\ConstantMapper;

abstract class RequestHelper

{
    public $client;

    public $session_id;

    const ENTITY_NAME = "";
    const DEFAULT_SELECT_FIELDS = [];


    /**
     * Normally I would DepedencyInjection the Client but I added a layer
     * over the http call function so anyone can override the guzzle with w/e
     * RequestHelper constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     *
     */
    public abstract function createRequest(array $jsonData);

    /**
     * @return object
     */
    public abstract function getRequest(array $fields = []): object;

    /**
     * @param $session
     */
    public function setSession($session): void
    {
        $this->session_id = $session;
    }

    /**
     * @return null|string
     */
    public function getSession(): ?string
    {
        return $this->session_id;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateSessionId(): void
    {

        // Request for Session ID
        $sessionData = [
            "service" => "login",
            "company" => ConstantMapper::API_COMPANY_ID,
            "fiscalyear" => ConstantMapper::API_FIRST_SCALAR_YEAR,
            "branch" => ConstantMapper::API_BRANCH,
            "username" => ConstantMapper::API_USERNAME,
            "password" => ConstantMapper::API_PASSWORD
        ];
        $payload = $this->makeHttpJsonCall('POST', ConstantMapper::API_BASE_URL, $sessionData);

        // If we got one
        if ($payload["success"]) {
            $this->setSession($payload["sessionid"]);
        } else {
            $this->logError('Couldnt get a session key');
        }

        return;

    }

    /**
     * Performs a HTTP Request with Json Data as body and return the payload decoded
     * @param string $method
     * @param string $url
     * @param array $jsonData
     * @return array|mixed|null
     */
    protected function makeHttpJsonCall(string $method, string $url, array $jsonData = [])
    {
        try {
            $res = $this->client->request($method, $url, [
                'json' => $jsonData

            ]);

            $payload = json_decode($res->getBody()->getContents(), true);
            $payload["statusCode"] = $res->getStatusCode(); // attach statusCode
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            $this->logError($e->getMessage());
        }
        /**
         * @todo: Build an Error Response Payload
         */
        return $payload ?? [];
    }


    /**
     * Returns the default Payload for a get Request
     * @param array $fields
     * @return array
     */
    protected function getRequestInitializer(array $fields = []): array
    {
        return [
            "service" => ConstantMapper::API_SERVICE_GET_DATA,
            "sessionid" => $this->getSession(),
            "action" => ConstantMapper::API_ACTION_READ,
            "fields" => $this->arrayToString(array_merge(static::DEFAULT_SELECT_FIELDS, $fields)), // merge 2 arrays and make them a string delimetered by ;
            "tablename" => static::ENTITY_NAME
        ];
    }

    /**
     * Returns the default Payload for a create Request
     * @param $jsonData
     * @return array
     */
    protected function createRequestInitializer(array $jsonData): array
    {
        return [
            "service" => ConstantMapper::API_SERVICE_SET_DATA,
            "sessionid" => $this->getSession(),
            "action" => ConstantMapper::API_ACTION_WRITE,
            "tablename" => static::ENTITY_NAME,
            static::ENTITY_NAME => $jsonData
        ];
    }

    /**
     * Builds a success Payload
     * @param int $statusCode
     * @param null $data
     * @return array
     */
    protected function buildSuccessPayload(int $statusCode,$data=null) {
        return [
            "success" => true,
            "status" => $statusCode,
            "data" => $data
        ];
    }

    /**
     * Builds an Error Payload
     * @param int $statusCode
     * @param null $errors
     * @return array
     */
    protected function buildErrorPayload(int $statusCode, $errors=null) {
        return [
            "success" => false,
            "status" => $statusCode,
            "errors" => $errors
        ];
    }


    /**
     * Log the error
     * @param string $message
     */
    public function logError(string $message): void
    {
        // 3 is the message type of logging to a different file than the server's default
        // addslashes as message is not binary safe
        error_log(addslashes($message), 3, dirname(__FILE__) . '/error.log');

    }

    /**
     * Mail to admin
     * @param string $title
     * @param string $subject
     */
    public function notifyAdmin(string $subject, string $message): void
    {
        if (ConstantMapper::NOTIFY_ADMIN_ON_ERROR) {
            mail(ConstantMapper::ERROR_NOTIFIER_EMAIL, $subject, wordwrap($message));
        }
    }

    /**
     * @param array $array
     * @param string $seperator
     * @return string
     */
    public function arrayToString(array $array, string $seperator = ';'): ?string
    {
        return implode($seperator, $array);
    }

    /**
     * @param object $obj
     * @return mixed|null
     */
    public function objToArray(object $obj): ?array
    {
        return json_decode(json_encode($obj), true);
    }

    /**
     * @param array $array
     * @return null|object
     */
    public function arrayToObj(array $array): ?object
    {
        return json_encode($array);
    }

    /**
     * @param $var
     * @return null
     */
    public function emptyToNull($var): ?string
    {
        return empty($var) ? null : $var;
    }
}
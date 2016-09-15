<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 15.09.2016
 */
namespace v3toys\v3project\api;

use skeeks\cms\helpers\StringHelper;
use v3toys\v3project\api\helpers\ApiResponseError;
use v3toys\v3project\api\helpers\ApiResponseOk;
use yii\base\Component;
use yii\helpers\Json;
use yii\httpclient\Client;

/**
 * Class ApiBase
 * @property string $version    read-only
 * @property string $baseUrl    read-only
 *
 * @see http://api.v3project.ru/v5/schema.yaml
 * @package v3toys\v3project\api
 */
abstract class ApiBase extends Component
{
    /**
     * версия api, на настоящий момент v5
     */
    const VERSION = 'v5';

    /**
     * @var string
     */
    public $schema = 'http://';

    /**
     * @var string
     */
    public $host = 'api.v3project.ru';

    /**
     * @var null|string ключ аффилиата в системе V3Project, если он передается то контроль доступа происходит по IP+"affiliate_key"
     */
    public $affiliate_key = '';


    /**
     * @var int set timeout to 15 seconds for the case server is not responding
     */
    public $timeout = 30;



    /**
     * @param $method           вызываемый метод, список приведен далее
     * @param array $params     параметры соответствующие методу запроса
     *
     * @return ApiResponseError|ApiResponseOk
     */
    public function send($method, array $params = [])
    {
        $apiUrl = $this->baseUrl . $method . "?aff_key=" . $this->affiliate_key;

        $client = new Client([
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ]
        ]);

        $response = $client->createRequest()
                ->setMethod("POST")
                ->setUrl($apiUrl)
                ->addHeaders(['Content-type' => 'application/json'])
                ->addHeaders(['user-agent' => 'JSON-RPC PHP Client'])
                ->setData($params)
                ->setOptions([
                    'timeout' => $this->timeout
                ])
            ->send();
        ;

        $apiResponse = null;

        try
        {
            $dataResponse = (array) Json::decode($response->content);
        } catch (\Exception $e)
        {
            \Yii::warning("Json api response error: " . $e->getMessage() . ". Response: \n{$response->content}", self::className());
            $apiResponse = new ApiResponseError();
            $apiResponse->error_message = $e->getMessage();
        }


        if (!$apiResponse)
        {
            if (!$response->isOk)
            {
                \Yii::error($response->content, self::className());
                $apiResponse = new ApiResponseError();
            } else
            {
                $apiResponse = new ApiResponseOk();
            }
        }


        $apiResponse->api            = $this;
        $apiResponse->statusCode     = $response->statusCode;

        $apiResponse->requestMethod  = $method;
        $apiResponse->requestParams  = $params;
        $apiResponse->requestUrl     = $apiUrl;

        $apiResponse->content        = $response->content;
        $apiResponse->data           = $dataResponse;

        return $apiResponse;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return static::VERSION;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->schema . $this->host . "/" . $this->version;
    }
}
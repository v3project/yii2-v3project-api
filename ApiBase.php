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
                ->setData($data)
                ->setOptions([
                    'timeout' => $this->timeout
                ])
            ->send();
        ;

        //Нам сказали это всегда json. А... нет, все мы люди, бывает и не json )
        try
        {
            $dataResponse = (array) Json::decode($response->content);
        } catch (\Exception $e)
        {
            \Yii::warning("Json api response error: " . $e->getMessage() . ". Response: \n{$response->content}", self::className());
            //Лайф хак, вдруг разработчики апи оставили var dump
            if ($pos = strpos($response->content, "{"))
            {
                $content = StringHelper::substr($response->content, $pos, StringHelper::strlen($response->content));

                try
                {
                    $dataResponse = (array) Json::decode($content);
                } catch (\Exception $e)
                {
                    \Yii::warning("Api response error: " . $response->content, self::className());
                }
            }
        }


        if (!$response->isOk)
        {
            \Yii::error($response->content, self::className());
            $responseObject = new ApiResponseError($dataResponse);
        } else
        {
            $responseObject = new ApiResponseOk($dataResponse);
        }

        $responseObject->statusCode = $response->statusCode;

        return $responseObject;

        return $this->_send($request);
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
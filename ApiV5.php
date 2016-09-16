<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 15.09.2016
 */
namespace v3toys\v3project\api;
/**
 * Class ApiV5
 *
 * @package v3toys\v3project\api
 */
class ApiV5 extends ApiBase
{
    const VERSION = 'v5';

    /**
     * Работа с товарам
     * @param array $params
     *
     * @return helpers\ApiResponseError|helpers\ApiResponseOk
     */
    public function productFind($params = [])
    {
        return $this->send('/product/find', $params);
    }
}
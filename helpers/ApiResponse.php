<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 15.07.2016
 */
namespace v3toys\v3project\api\helpers;

use yii\base\Component;

/**
 * Описание общих полей запросов
 *
 * @property bool isError
 * @property bool isOk
 *
 * @package v3toys\v3project\api\helpers
 */
abstract class ApiResponse extends Component
{
    /**
     * @var
     */
    public $api;

    /**
     * вызыванный метод, список приведен далее
     * @var string
     */
    public $method;

    /**
     * данные соответствующие методу запроса
     * @var mixed
     */
    public $data;


    /**
     * Seerver response code
     * @var int
     */
    public $statusCode;

    /**
     * Ответны запрос ошибочный?
     * @return bool
     */
    abstract public function getIsError();

    /**
     * @return bool
     */
    public function getIsOk()
    {
        return !$this->isError;
    }
}
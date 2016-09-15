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
 * Class ApiResponseOk
 *
 * @package v3toys\v3project\api\helpers
 */
class ApiResponseOk extends ApiResponse
{
    /**
     * @return bool
     */
    public function getIsError()
    {
        return false;
    }
}
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
     * Получение информации о товарах
     * 
     * @param array $params 
     * exemple:
     * [
            'filters' =>
            [
                'v3p_product_ids' => [186893]
            ],
            'params' =>
            [
                'format' => 'without_features'
            ]
        ]
     *
     * @return helpers\ApiResponse
     */
    public function productFind($params = [])
    {
        return $this->send('/product/find', $params);
    }

    /**
     * Возвращает ориентировочную информацию по доставке
     *
     * @param array $params
     *
     * @return helpers\ApiResponse
     */
    public function orderGetGuidingShippingData($params = [])
    {
        return $this->send('/order/get-guiding-shipping-data', $params);
    }


    /**
     * Возвращает информацию по пунктам выдачи заказов (ПВЗ)
     *
     * @param array $params
     *
     * @return helpers\ApiResponse
     */
    public function orderFindOutlets($params = [])
    {
        return $this->send('/order/find-outlets', $params);
    }
}
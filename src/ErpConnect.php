<?php

namespace ErpConnect;


use ErpConnect\Params\PlatformClass;
use Illuminate\Support\Facades\Cache;

class ErpConnect extends Api
{
//    use PlatformClass;

    public function __construct(\Illuminate\Config\Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * 获取交易号
     * @return mixed
     */
    public function getTranSactionNum($param)
    {
       return $this->get('tradeid/get',$param);
    }

    /**
     * 订单状态
     */
    public function getOrderStatus($param)
    {
        return $this->get('api/orderstatus/get',$param);
    }

    /**
     * 获取数据源配置
     */
    public function getDataOne()
    {

    }

    /**
     * 批量获取数据源配置
     */
    public function getDataBetween()
    {

    }


}
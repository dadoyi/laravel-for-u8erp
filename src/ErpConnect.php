<?php

namespace ErpConnect;


use ErpConnect\Params\PlatformClass;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class ErpConnect extends Api
{

    public function __construct(\Illuminate\Config\Repository $repository)
    {
        parent::__construct($repository);
    }

    /***********************平台类接口*************************/

    /**
     * 获取交易号
     * @return mixed
     */
    protected function getTranSactionNum(array $param = [])
    {
        $config = [
            'app_key',
            'from_account',
        ];
       return $this->get('system/tradeid',array_merge($param,$config));
    }

    /**
     * 订单状态
     */
    public function getOrderStatus(array $param = [])
    {
        $config = [
            'app_key',
            'to_account',
        ];
        return $this->get('api/orderstatus/get',array_merge($param,$config));
    }

    /**
     * 获取数据源配置
     */
    public function getDataOne(array $param = [])
    {
        $config = [
            'app_key',
            'to_account',
            'from_account',
        ];
        return $this->get('system/datasource/get',array_merge($param,$config));
    }

    /**
     * 批量获取数据源配置
     */
    public function getDataBetween(array $param = [])
    {
        $config = [
            'app_key',
            'to_account',
        ];
        return $this->get('system/datasource/batch_get',array_merge($param,$config));
    }



    /********************************基础档案类****************************/


    /**
     * 获取单个U8帐套信息
     * @param array $param
     * @return mixed
     */
    public function baseBooks(array $param = [])
    {
        $config = [
            'from_account',
            'app_key',
            'to_account',
            'to_account',
        ];
        return $this->get('api/account/get',array_merge($param,$config));
    }


    /**
     * 批量获取U8帐套信息
     * @param array $param
     * @return mixed
     */
    public function baseBooksAll(array $param = [])
    {
        $config = [
            'from_account',
            'app_key',
            'to_account',
        ];
        return $this->get('api/account/batch_get',array_merge($param,$config));
    }


    /**
     * 添加pn 存货档案
     */
    public function inventoryAdd(array $param = [])
    {
        $result = $this->getTranSactionNum();
        $config = [
            'from_account',
            'app_key',
            'to_account',
            'sync'=>1,
            'tradeid'=>$result['trade']['id']
        ];

        return $this->requestMethod('api/inventory/add',$config,'POST',['json'=>['inventory'=>$param]]);
    }


    /**
     * 查看供应商档案
     */
    public function vendorGet($id)
    {
        $config = [
            'from_account',
            'app_key',
            'to_account',
            'id'=>$id
        ];

        return $this->requestMethod('api/vendor/get',$config,'GET');
    }



    /**
     * 供应商添加
     * @param array $param
     */
    public function vendorAdd(array $param = [])
    {
        $result = $this->getTranSactionNum();
        $config = [
            'from_account',
            'app_key',
            'to_account',
            'sync'=>1,
            'tradeid'=>$result['trade']['id']
        ];

        return $this->requestMethod('api/vendor/add',$config,'POST',['json'=>['vendor'=>$param]]);

    }


    public function vendorClassAdd(array $param = [])
    {
        $result = $this->getTranSactionNum();
        $config = [
            'from_account',
            'app_key',
            'to_account',
            'ds_sequence',
            'sync'=>1,
            'tradeid'=>$result->trade->id,
        ];
        return $this->requestMethod('api/vendorclass/add',$config,'POST',['json'=>['vendorclass'=>$param]]);
    }


    /**
     * 客户档案查询
     * @param $id
     * @return mixed
     */
    public function customerGet($id)
    {
        $config = [
            'from_account',
            'app_key',
            'to_account',
            'id'=>$id
        ];

        return $this->requestMethod('api/customer/get',$config,'GET');
    }




}
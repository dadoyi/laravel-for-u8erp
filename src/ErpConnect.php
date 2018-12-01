<?php

namespace ErpConnect;


use Illuminate\Support\Facades\Cache;

class ErpConnect extends Api
{
    protected function __construct(\Illuminate\Config\Repository $repository)
    {
        parent::__construct($repository);
    }

    public function getTranSactionNum()
    {
        $response->get('erpconnect.FROM_ACCOUNT')
    }

    public function getOrderStatus()
    {

    }

    public function getDataOne()
    {

    }

    public function getDataBetween()
    {

    }


}
<?php

namespace ErpConnect\Params;
use Illuminate\Config\Repository;

/**
 * 平台类参数配置
 * @copyright Maitrox Smart Supply Chain
 * Class PlatformClass
 * @package ErpConnect\Params
 */

trait PlatformClass
{
    protected $param;

    protected $arr;

//        return  [

//        ];

    public function getParamMerge($arr)
    {
        foreach ($arr as $k => $item){
            if(array_key_exists($item,$this->config())){
                $arr[$item] = $this->config()[$item];
            }
        }

        return $arr;
    }





}

<?php

namespace ErpConnect\Params;
use Illuminate\Config\Repository;

/**
 * 平台类参数配置
 * @copyright Maitrox Smart Supply Chain
 * Class PlatformClass
 * @package ErpConnect\Params
 */

class PlatformClass
{
    static private $_instance = null;

    private $config;

    protected $form_account;

    protected $app_key;

    protected $app_secret;

    private function __construct(Repository $repository,$key)
    {
        $this->config = $repository;
    }

    static public function getInstance($key)
    {
        if(!(self::$_instance instanceof PlatformClass)){
            self::$_instance = new self($key);
        }
        return self::$_instance;
    }


    private function getkey()
    {

    }

    public function getArr($key)
    {

    }



    public function tokenGet()
    {
        return [
            'from_account' => $this->form_account,
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret,
        ];
    }





}

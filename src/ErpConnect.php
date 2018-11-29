<?php

namespace ErpConnect;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;

class ErpConnect extends Erp
{
    /**
     * 对应url code
     * @var
     */
    protected $code;


    /**
     * 获取用户登录token
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getToken()
    {
        $this->request_url = sprintf($this->token_code,$this->from_account,$this->erp_key,$this->erp_secret);
        Cache::set('erp_token',$this->get()->token->id,120);
    }

    /**
     * 获取请求路径
     */
    protected function getUrl()
    {
        $str = $this->config->get('erpconnect.'.$this->code);
//        $this->request_url =
    }


    public function is_token()
    {

    }


    /**
     * 设置
     * @param $code
     * @param $data
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function setData($code,$data)
    {
        if(!Cache::has('erp_token')){
            $this->getToken();
        }
        $this->data = $data;
        $this->code = $code;
        $this->getUrl();
        return $this;
    }


    public function splicingUrl()
    {

    }


}
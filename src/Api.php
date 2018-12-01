<?php
namespace ErpConnect;

use Hanson\Foundation\AbstractAPI;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;

class Api extends AbstractAPI
{
    /**
     * base config
     * @var Repository
     */
    protected $config;

    /**
     * erp token
     * @var
     */
    protected $token;

    /**
     * send data
     * @var
     */
    protected $data;

    /**
     * @var
     */
    protected $tokenkey;

    /**
     * methond url
     */
    const URL = 'https://api.yonyouup.com';

    protected function __construct(Repository $repository)
    {
        $this->config = $repository;
        $this->checkHttp();
        if(!Cache::get($this->gettokenkey())){
            $this->getToken();
        }
    }

    /**
     * @throws \Hanson\Foundation\Exception\HttpException
     */
    public function getToken()
    {
        $http = $this->getHttp();
        $this->tokenData();
        $response = $http->get(self::URL.'/system/token',$this->data);

        $result = json_decode(strval($response->getBody()), true);
        $this->setToken($result['token']['id']);
    }

    /**
     * @param $token
     * @param int $time
     */
    protected function setToken($token,$time = 120)
    {
        if($time){
            Cache::set($this->getTokenkey(),$token,$time);
        }
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getTokenkey()
    {
        if(is_null($this->tokenkey)){
            return $this->data['from_account'];
        }
        return $this->tokenkey;
    }


    /**
     * @param string $method
     * @param array $params
     * @return mixed
     */
    protected function get(string $method , array $params)
    {
        $params = array_merge($params,[
            'token'=>$this->token
        ]);

        $response = $this->http->get(self::URL.$method, $params);

        return $this->response($response);

    }

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     */
    protected function post(string $method , array $params)
    {
        $params = array_merge($params,[
            'token'=>$this->token
        ]);

        $response = $this->http->post(self::URL.$method, $params);

        return $this->response($response);
    }


    /**
     * 请求token参数
     * @return array
     */
    private function tokenData()
    {
        return $this->data = [
            'from_account' => $this->config->get('erpconnect.FROM_ACCOUNT'),
            'app_key' => $this->config->get('erpconnect.ERP_AppKey'),
            'app_secret' => $this->config->get('erpconnect.ERP_AppSecret')
        ];
    }


    /**
     * @return mixed
     */
    public function response()
    {
        return json_decode(strval($response->getBody()), true);
    }



    /**
     * @return \Hanson\Foundation\Http
     */
    public function checkHttp()
    {
        return $this->http ?: $this->getHttp();
    }

}
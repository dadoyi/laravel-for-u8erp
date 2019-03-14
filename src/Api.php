<?php
namespace ErpConnect;

use GuzzleHttp\Client;
use Hanson\Foundation\AbstractAPI;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Self_;

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
     * @var
     */
    protected $configData;


    /**
     * methond url
     */
    const URL = 'https://api.yonyouup.com/';

    public function __construct(Repository $repository)
    {
        $this->config = $repository;
        $this->checkHttp();
        if(Cache::get($this->gettokenkey())){
            $this->token = Cache::get($this->gettokenkey());
        }else{
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
        $response = $http->get(self::URL.'system/token',$this->data);

        $result = json_decode(strval($response->getBody()), true);
        \Log::info('url:'.self::URL.'system/token,result:'.json_encode($result));
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
            $this->tokenData();
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
        $params = array_merge($this->paramMerge($params),[
            'token'=>$this->token
        ]);
        $response = $this->http->get(self::URL.$method, $params);
        return $this->response($response,self::URL.$method);

    }

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     */
    protected function post(string $method , array $params,$json = null)
    {
        $params = array_merge($this->paramMerge($params),[
            'token'=>$this->token
        ]);

        $response = $this->http->post(self::URL.$method, $params);

        return $this->response($response,self::URL.$method);
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
    public function response($response,$url = null)
    {
        $msg = json_decode($response->getBody(),true);
//        \Log::info('url:'.$url.',result:'.json_encode($msg));
        return $msg;
    }



    /**
     * @return \Hanson\Foundation\Http
     */
    public function checkHttp()
    {
        return $this->http ?: $this->getHttp();
    }


    /**
     * 配置文件
     * @return array
     */
    protected function getConfigData()
    {
        return $this->configData ?: [
             'erp_server' => $this->config->get('erpconnect.ERP_SERVER'),
             'ds_sequence' => $this->config->get('erpconnect.DS_SEQUENCE'),
             'app_key' => $this->config->get('erpconnect.ERP_AppKey'),
             'app_secret' => $this->config->get('erpconnect.ERP_AppSecret'),
             'from_account' => $this->config->get('erpconnect.FROM_ACCOUNT'),
             'to_account' => $this->config->get('erpconnect.TO_ACCOUNT')
        ];
    }

    /**
     * @param $param
     * @return mixed
     */
    protected function paramMerge($param)
    {
        foreach ($param as $key => $item) {
            if(!is_array($item)){
                if(array_key_exists($item,$this->getConfigData())){
                    $param[$item] = $this->getConfigData()[$item];
                    unset($param[$key]);
                }
            }
        }
        return $param;
    }


    public function requestMethod($url,$option = [],$method,$params = [])
    {
        if(!empty($option)){
            $option = $this->paramMerge($option);
            $option['token'] = $this->token;
            $option['ds_sequence']=1;
            $queryString = '?';
            foreach ($option as $key => $value) {
                $queryString .= $key . '=' . $value . '&';
            }
            $url = self::URL.$url . rtrim($queryString, '&');
        }

        $config['headers'] = [
            'Content-Type'=>'application/json'
        ];

        $client = new Client($config);
        $request = $client->request(strtoupper($method),$url,$params);
        return $this->response($request,$url);
    }



}
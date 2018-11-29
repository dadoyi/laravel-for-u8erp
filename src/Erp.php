<?php

namespace ErpConnect;

use Illuminate\Config\Repository;
use GuzzleHttp\Client;

class Erp {

    /**
     * @var Repository
     */
    protected $config;

    /**
     * ERP_SERVER
     * @var
     */
    protected $erp_server;

    /**
     * DS_SEQUENCE
     * @var
     */
    protected $ds;

    /**
     * ERP_AppKey
     * @var
     */
    protected $erp_key;

    /**
     * ERP_AppSecret
     * @var
     */
    protected $erp_secret;

    /**
     * FROM_ACCOUNT
     * @var
     */
    protected $from_account;

    /**
     * TO_ACCOUNT
     * @var
     */
    protected $to_account;

    /**
     * 获取token的url code
     * @var
     */
    protected $token_code;

    /**
     * 路径code
     * @var
     */
    protected $url_code;

    /**
     * 请求路径
     * @var
     */
    protected $request_url;

    /**
     * 数据包
     * @var
     */
    protected $data;

    /**
     * token
     * @var
     */
    protected $token;
    /**
     * Erp constructor.
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->config = $repository;
        $this->getBaseConfig();
    }

    /**
     * 获取基础ERP配置
     */
    protected function getBaseConfig()
    {
        $this->erp_server = $this->config->get('erpconnect.ERP_SERVER');
        $this->ds = $this->config->get('erpconnect.DS_SEQUENCE');
        $this->erp_key = $this->config->get('erpconnect.ERP_AppKey');
        $this->erp_secret = $this->config->get('erpconnect.ERP_AppSecret');
        $this->from_account = $this->config->get('erpconnect.FROM_ACCOUNT');
        $this->to_account = $this->config->get('erpconnect.TO_ACCOUNT');
        $this->token_code =  $this->config->get('erpconnect.code');
    }

    /**
     * get 方式
     * @return mixed
     */
    public function get()
    {
        $response = (new Client())->get(
            $this->request_url
        );
        return json_decode($response->getBody());
    }

    public function post()
    {
        $response = (new Client(['base_url' => $this->request_url]))->request();
    }

    public function put()
    {
        $response = (new Client(['base_url' => $this->request_url]))->request();
    }

    public function delete()
    {
        $response = (new Client(['base_url' => $this->request_url]))->request();
    }
}
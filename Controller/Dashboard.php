<?php

namespace OxidProfessionalServices\Proxy\Controller;

use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\Admin\ModuleConfiguration;

class Dashboard extends AdminController
{

    public function __construct()
    {
        $this->_sThisTemplate = "proxyTest.tpl";
    }

    public function render()
    {
        $textHeaders = "";
        $url = Registry::getRequest()->getRequestParameter('url');
        if ($url) {
            try {
                $textHeaders = Registry::getRequest()->getRequestParameter('header');
                $mc = new ModuleConfiguration();
                $headers = $mc->_serializeConfVar('aarr', '', $textHeaders);

                $client = new \GuzzleHttp\Client([
                    'timeout' => 6.0,
                ]);

                $response = $client->request('GET', $url, [
                    'headers' => $headers
                ]);
                print_r($response);
            } catch (\Exception $e){
                print $e->getMessage();
            }
        } else {
            $textHeaders = "";
            $url = "";
        }
        $res = parent::render();
        $this->addTplParam('proxy',getenv('HTTPS_PROXY'));
        $this->addTplParam('header', $textHeaders);
        $this->addTplParam('url', $url);



        return $res;
    }



}
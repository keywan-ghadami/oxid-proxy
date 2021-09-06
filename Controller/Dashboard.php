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
        #####################################################################################
        #                          IMPORTANT CHANGE                                         #
        #####################################################################################
        # Sanitize url parameters to prevent cross site scripting                           #
        #####################################################################################
        $url = filter_var($url, FILTER_SANITIZE_URL);

        if ($url) {
            if ($this->validateURL($url)) {
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
                $this->addTplParam('error_message','Please enter valid url!');
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

    /**
     * Validate URL
     *
     * @param string $URL         URL parameter
     *
     * @return boolean
     */
    public function validateURL($URL) {
        // TODO: regex can be improved more by referring https://mathiasbynens.be/demo/url-regex
        $pattern_1 = "/^(http|https|ftp|tcp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+.([A-Z0-9]{1,7})$)(:(\d+))?\/?/i";
        $pattern_2 = "/^(www)((\.[A-Z0-9][A-Z0-9_-]*)+.([A-Z0-9]{1,7})$)(:(\d+))?\/?/i";
        $pattern_3 = "/^(http(s?):\/\/)?(((www\.)?+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+)|(\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b))(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/i";
        if(preg_match($pattern_1, $URL) || preg_match($pattern_2, $URL) || preg_match($pattern_3, $URL)){
            return true;
        } else{
            return false;
        }
    }
}

<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @author        OXID Professional services
 * @link          http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG
 * Created at 01.12.2016 12:16 by Keywan Ghadami
 * Modernised: 2019-05-23, JA
 */

namespace OxidProfessionalServices\Proxy\Core;

use OxidEsales\Eshop\Core\Registry;

/**
 * Class oxpsprox_oxcurl
 *
 */
class Curl extends Curl_parent
{

    public function __construct()
    {
        //CURLOPT_PROXY

        $this->_aOptions['CURLOPT_CONNECTTIMEOUT'] = 1;
        //$this->_aOptions['CURLOPT_TIMEOUT'] = 1;

    }

    protected function _setOptions() {
        $targetUrl = $this->getUrl();
        $proxy = $this->getProxyForUrl($targetUrl);
        if ($proxy) {
            $proxyParts = parse_url($proxy);
            $this->_setOpt(CURLOPT_PROXYTYPE, $proxyParts['scheme']);
            $this->_setOpt(CURLOPT_PROXY, $proxyParts['host']);
            $this->_setOpt(CURLOPT_PROXYPORT, $proxyParts['port']);
        }
        parent::_setOptions();
    }


    /**
     * @param $url
     * @return string|null
     */
    public function getProxyForUrl($url){
        $targetUrlParts = parse_url($url);
        $protocol = $targetUrlParts['scheme'];
        $proxy = $this->getProxy($protocol);
        return $proxy;
    }

    /**
     * @param string $scheme
     * @return string|null
     */
    public function getProxy($scheme){
        /**
         * We are reading module proxy config first and then default config
         */
        $proxy_conf = Registry::getConfig()->getConfigParam('oxpsproxy');
        $schemeConfRequest = strtoupper($scheme);
        if (is_array($proxy_conf) && array_key_exists($schemeConfRequest, $proxy_conf)) {
            $proxy = $proxy_conf[$schemeConfRequest];
            return $proxy;
        }

        return null;
    }

}

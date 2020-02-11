<?php


namespace OxidProfessionalServices\Proxy\Core;


class Config extends Config_parent
{
    /**
     * Load config values from DB
     *
     * @param string $shopID shop ID to load parameters
     * @param array $onlyVars array of params to load (optional)
     * @param string $module module vars to load, empty for base options
     *
     * @return bool
     */
    protected function _loadVarsFromDb($shopID, $onlyVars = null, $module = '')
    {
        $res = parent::_loadVarsFromDb($shopID, $onlyVars, $module);
        if ($module == "module:") {
            $proxy = $this->getConfigParam('oxpsproxy', []);

            $httpProxy = isset($proxy['HTTPS']) ? $proxy['HTTPS'] : '';
            //Setting this for guzzel http client
            putenv("HTTPS_PROXY=$httpProxy");

            //TODO: support proxy settings for php streams
            //this not done yet because for my current project this is done already by the hoster
            //but if someone needs the following pseudo code may help:
            /*$stream_default_opts = [];
            foreach ($proxy as $protocol => $proxyUrl) {
                $proxyUrlParts =  parse_url($proxyUrl);
                $tcpProxyUrl = 'tcp://'.$proxyUrlParts['host'].':'.$proxyUrlParts['port'];
                $stream_default_opts[$protocol] = [
                    'proxy' => $tcpProxyUrl,
                    'request_fulluri'=>true
                ];
            }*/

            //stream_context_set_default($stream_default_opts);
        }
        return $res;
    }
}
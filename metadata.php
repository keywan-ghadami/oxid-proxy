<?php

/**
 * Metadata version
 */

use OxidProfessionalServices\Proxy\Core\Config;
use OxidProfessionalServices\Proxy\Core\Curl;
use OxidProfessionalServices\Proxy\Controller\Dashboard;

$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'          => 'oxps/proxy',
    'title'       => [
        'de'    =>  'OXPS :: Proxy',
        'en'    =>  'OXPS :: proxy',
    ],
    'description' => [
        'de'    =>  'Ermöglicht das Festlegen eines Proxy-Servers',
        'en'    =>  'Enables you to define a proxy server',
    ],
    'thumbnail'   => 'out/pictures/picture.png',
    'version'     => '2.0.0',
    'author'      => 'oxps',
    'url'         => 'https://www.oxid-esales.com',
    'controllers'  => [
        'oxpsproxydashboard' => Dashboard::class
    ],
    'extend'      => [
        \OxidEsales\Eshop\Core\Curl::class =>  Curl::class,
        \OxidEsales\Eshop\Core\Config::class =>  Config::class,
    ],
    'events'      => [
//        'onActivate'   => 'oxpsProxyEvents::onActivate',
//        'onDeactivate' => 'oxpsProxyEvents::onDeactivate',
    ],
    'templates' => [
        "proxyTest.tpl" => "oxps/proxy/tpl/proxyTest.tpl"
    ],
    'settings'    => [
        [
            'group'    => 'main',
            'name'     => 'oxpsproxy',
            'type'     => 'aarr',
            'value'    => ['HTTP'=>'', 'HTTPS'=>''],
        ],
    ],
];

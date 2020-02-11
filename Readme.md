#Proxy Module

alows to set a proxy server for request made by shop
it covers
- Curl Object uses by extenting the Curl Objec
- Guzzel http by injecting HTTPS_PROXY environment variable
- php stream by documentation



#setup:

install the module and set the proxy configuration within the module setting
e.g.:
```
'http' =>  'http://127.0.0.1:8888'
'https' => 'http://127.0.0.1:8888
```

and setup the stream default option within 
in php prepend script or within config.inc.php
```
$stream_default_opts = array(
    'ftp' => array(
        'proxy' => "tcp://127.0.0.2:8888",
        'request_fulluri'=>true
    ),
    'http'=>array(
        'proxy'=>"tcp://127.0.0.2:8888",
        'request_fulluri' => true
    ),
    'https'=>array(
        'proxy'=>"tcp://127.0.0.2:8888",
        'request_fulluri' => true
    )
);
stream_context_set_default($stream_default_opts);
```
if stream default opts are set they overrule the module setting for 
Curl. 
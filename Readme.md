# Proxy Module

alows to set a proxy server for request made by shop
it covers
- Curl Object uses by extenting the Curl Objec
- Guzzel http by injecting HTTPS_PROXY environment variable
- php stream by documentation

# Before you start using this module

Every oxid module creates overhead for maintainance and run time complexity.
For stting a proxy normally it should be enough to set the enviroment variables http_proxy and https_proxy

## Setting Proxy for FPM
e.g. for php fpm: you can do it like this (given your proxy IP is 127.0.0.1 and the Port is 8080):
; Start a new pool named 'www'.
; the variable $pool can be used in any directive and will be replaced by the
; pool name ('www' here)
; replace http://127.0.0.1:8080 with your proxy
[oxid]
env["http_proxy"] = "http://127.0.0.1:8080"
env["https_proxy"] = "http:///127.0.0.1:8080"

## Setung up a proxy for testing

This module was tested with mitmproxy.

you can find a full documententaion at https://docs.mitmproxy.org/stable/

the following only gives a brief description of the most importants points:

### certificates
Make sure you install the certificates on the server otherwise the connection will not work.

see https://docs.mitmproxy.org/stable/concepts-certificates/

given oxid is runing on an ubuntu server:
From the server where mitmproxy is installed copy from the folder ~/.mitmproxy/mitmproxy-ca-cert.pem to the server where oxid is running
/usr/local/share/ca-certificates/mitmproxy-ca-cert.crt
and run
sudo apt-get install -y ca-certificates
sudo update-ca-certificates

now php will accept the certificates that mitmproxy will generate.

### run mitmproxy in normal mode

```mitmproxy```

### run mitmproxy in socks5 mode 

```mitmproxy --mode socks5 ```


# Setup:

install the module and set the proxy configuration within the module setting
e.g.:
```
'http' =>  'http://127.0.0.1:8080'
'https' => 'http://127.0.0.1:8080
```

## troubleshooting

### test the proxy from the server where oxid is installed

run a curl request to check if your proxy is reachable and allow requests:
```curl -X POST --data-urlencode "myversion=7.1.0" --proxy http://127.0.0.1:8080 https://admin.oxid-esales.com/CE/onlinecheck.php/de```
you should receive a response like this:
```
<font face="Arial,Verdana,Geneva,Arial,Helvetica,sans-serif">
    OXID eShop Update Status:<br/><br/>
    Ihre OXID eShop Version ist: <b>7.1.0</b><br/>
    Die aktuellste OXID eShop Version ist: <b>7.1.0</b><br/><br/>

    <b>Ihre OXID eShop Version ist aktuell.</b><br/>
</font>
```

### test with a socks5 proxy

if you run a socks5 proxy make sure you pass the correct protocoll: 
curl -X POST --data-urlencode "myversion=7.1.0" --proxy socks5://85.215.66.251:8080 https://admin.oxid-esales.com/CE/onlinecheck.php/de
(you can also runt mitm proxy 

### try optional settings
setup the stream default option within 
in php prepend script or within config.inc.php
```
$stream_default_opts = array(
    'ftp' => array(
        'proxy' => "tcp://127.0.0.1:8080",
        'request_fulluri'=>true
    ),
    'http'=>array(
        'proxy'=>"tcp://127.0.0.1:8080",
        'request_fulluri' => true
    ),
    'https'=>array(
        'proxy'=>"tcp://127.0.0.1:8080",
        'request_fulluri' => true
    )
);
stream_context_set_default($stream_default_opts);
```

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="oxpsproxydashboard" />
    <input type="hidden" name="fnc" value="" />
    <label>Proxy</label>: [{$proxy}]<br />
    <lable>Headers (key => value)</lable>:
    <textarea name="header">[{$header}]</textarea><br/>
    <label>URL</label>: <input type="text" name="url" value="[{$url}]"><br />
    <input type="submit" />
</form>
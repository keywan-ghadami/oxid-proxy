[{*
#####################################################################################
#                          IMPORTANT CHANGE                                         #
#####################################################################################
# Sanitize fields to prevent cross site scripting                                   #
#####################################################################################
*}]
[{if $error_message}]
    <div style="color: #ff0000">
        <label>Error</label>: [{$error_message}]
    </div>
    <br />
[{/if}]

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="oxpsproxydashboard" />
    <input type="hidden" name="fnc" value="" />
    <label>Proxy</label>: [{$proxy}]<br />
    <lable>Headers (key => value)</lable>:
    <textarea name="header">[{$header|escape}]</textarea><br/>
    <label>URL</label>: <input type="text" name="url" value="[{$url|escape}]"><br />
    <input type="submit" />
</form>
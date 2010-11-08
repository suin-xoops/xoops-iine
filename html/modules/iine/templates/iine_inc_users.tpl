<div id="iine_users">
<div id="iine_voters">
<{if count($voters) > 0 || $guests > 0}>
<h3 class="iine_title"><{$smarty.const._MD_IINE_LANG_USERS}></h3>
<div class="iine_users_body">
<{foreach from=$voters item=voter name=voters}>
<div class="<{cycle values="odd,even"}>" style="float:left; margin:5px; width:80px; height:110px; text-align:center;">
<a href="<{$xoops_url}>/userinfo.php?uid=<{$voter.uid}>">
<img src="<{$voter.avatar.url}>" width="<{$voter.avatar.width.resized}>" height="<{$voter.avatar.height.resized}>" />
</a>
<div style="white-space:nowrap">
<a href="<{$xoops_url}>/userinfo.php?uid=<{$voter.uid}>">
<{$smarty.const._MD_IINE_LANG_SAN|sprintf:$voter.uname}>
</a>
</div>
<div>
<span style="font-size:0.7em;"><{$voter.created|xoops_formattimestamp:'Y.m.d'}></span>
</div>
</div>
<{foreachelse}>
<div class="<{cycle values="odd,even"}>" style="float:left; margin:5px; width:80px; text-align:left;">
<{$smarty.const._MD_IINE_MESSAGE_NO_VOTERS}>
</div>
<{/foreach}>
<{if $guests > 0}>
<div class="<{cycle values="odd,even"}>" style="float:left; margin:5px; width:80px; text-align:left;">
<{$smarty.const._MD_IINE_MESSAGE_GUESTS|sprintf:$guests}>
</div>
<{/if}>
<div style="clear:left"></div>
</div>
<{/if}>
</div>
</div>
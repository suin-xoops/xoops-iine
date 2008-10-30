<div id="iine_users">
<div id="iine_voters">
<{if count($voters) > 0 || $guests > 0}>
<h3 class="iine_title"><{$smarty.const._MD_IINE_LANG_USERS}></h3>
<div class="iine_users_body">
<{foreach from=$voters item=voter name=voters}>
<div class="<{cycle values="odd,even"}>" style="float:left; margin:5px; width:80px; text-align:center;">
<a href="<{$xoops_url}>/userinfo.php?uid=<{$voter.uid}>">
<img src="<{$voter.uid|xoops_user_avatarize}>" width="80" />
</a>
<br />
<a href="<{$xoops_url}>/userinfo.php?uid=<{$voter.uid}>">
<{$smarty.const._MD_IINE_LANG_SAN|sprintf:$voter.uname}>
</a>
<br />
<span style="font-size:0.7em;"><{$voter.created|xoops_formattimestamp:'Y.m.d'}></span>
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
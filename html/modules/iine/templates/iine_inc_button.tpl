<div id="iineButton">
<form action="<{$form_action}>" method="post">
<div id="iine_form">
<span style="color:#ff6600"><big><big><strong><{$total}></strong></big></big><{$smarty.const._MD_IINE_LANG_IINE}></span>
<{if $voted}>
<input type="submit" name="unvote" value="<{$smarty.const._MD_IINE_LANG_UNVOTE}>" />
<{else}>
<input type="submit" name="vote" value="<{$smarty.const._MD_IINE_LANG_VOTE}>" />
<{/if}>
<span id="iineResult"></span>
<input type="hidden" name="dirname" value="<{$target.dirname}>" />
<input type="hidden" name="id" value="<{$target.id}>" />
<input type="hidden" name="url" value="<{$url}>" />
</div>
</form>
</div>
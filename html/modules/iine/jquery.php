<?php
define('_LEGACY_PREVENT_LOAD_CORE_', 1);
require '../../mainfile.php';

if (function_exists('mb_http_output')) {
	mb_http_output('pass');
}
header('Content-Type:application/x-javascript; charset=utf-8');
header('Cache-control: must-revalidate');
header('Expires: '.gmdate('D, d M Y H:i:s', time() + 60 * 60 * 24 * 7).' GMT');

?>$(document).ready(function(){
	
	if ( $("#iineButton") == null ) {
		return false;
	}

	$("#iineButton form").removeAttr('action');

	$("#iineButton form").submit(function() {

		$("input[@name=vote]", this).attr("disabled","disabled");
		$("input[@name=unvote]", this).attr("disabled","disabled");

		$("#iineResult").html("<img src=\"<?=XOOPS_URL?>/modules/iine/ajax-loader.gif\" alt=\"Now loading\" />");

		var dirname = $("input[@name=dirname]", this).val();
		var id = $("input[@name=id]", this).val();
		var url = $("input[@name=url]", this).val();

		if ( $("input[@name=vote]", this).val() != undefined ) {
			var post = { 
				vote : "1", 
				dirname : $("input[@name=dirname]", this).val(), 
				id : $("input[@name=id]", this).val(), 
				url : $("input[@name=url]", this).val() 
				};
		} else {
			var post = { 
				unvote : "1", 
				dirname : $("input[@name=dirname]", this).val(), 
				id : $("input[@name=id]", this).val(), 
				url : $("input[@name=url]", this).val() 
				};
		}

		$.post("<?=XOOPS_URL?>/modules/iine/index.php?action=voteByAjax", post, function(data){


			if ( data == 'voted' || data == 'unvoted' ) {

<? if ( isset($_GET['EUC']) ) : ?>
					/*
					  * If the encoding of your xoops is not UTF-8, 
					  * please make below activate and change, if you need, the charset.
					  */

					jQuery().ajaxSend(function(event, XMLHttpRequest, options){
						XMLHttpRequest.overrideMimeType("text/plain; charset=euc-jp");
					});
<? endif ?>

					$("#iineButton form").load("<?=XOOPS_URL?>/modules/iine/index.php?action=button&dirname="+dirname+"&id="+id+"&url="+url+" #iine_form");
					$("#iine_users").load("<?=XOOPS_URL?>/modules/iine/index.php?action=users&dirname="+dirname+"&id="+id+" #iine_voters");

				} else {
					$("#iineResult").text(data);
				}
		});
		return false;
	});

});
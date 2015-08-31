{if $flash != ''}
<script type="text/javascript" >
{literal}
	$(document).ready(function(){
		setTimeout(function(){
			$("#flash").fadeOut("slow", 
				function () {
					$("#flash").remove();
				}); 
		}, 6000);

	});
{/literal}
</script>
<div align="center"><div id="flash" class='flash{$flash.type}'>{$flash.message}</div></div>
{/if}

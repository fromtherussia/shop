<?php
	$redirectUrl = Command::GetRedirectUrl('Admin');
?>
<div id="logout-dialog" title="Выход">
	<p>
		Через 10 секунд Вы будете перенаправлены на стартовую страницу.&nbsp;<a href="<?= $redirectUrl; ?>">Перейти сейчас.</a>
	</p>
</div>
<script>
$(function(){
	$("#logout-dialog").dialog({
			width: 400,
			resizable: false,
			draggable: false
		}
	).bind("dialogbeforeclose", function() {return false});
	
	var timerObject = new $.timer({
			'timeout': 10000, 
			'repeat': false,
			'callback': function() {
				window.location = '<?= $redirectUrl; ?>';
			}
		}
	);
});
</script>
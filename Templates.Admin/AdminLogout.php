<?php
	$redirectUrl = Command::GetRedirectUrl('Admin');
?>
<div id="logout-dialog" title="�����">
	<p>
		����� 10 ������ �� ������ �������������� �� ��������� ��������.&nbsp;<a href="<?= $redirectUrl; ?>">������� ������.</a>
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
<div id="login-dialog" title="¬ход">
	<form method="post" action="<?= Command::GetRedirectUrl('AdminLogin'); ?>">
		<table>
			<tr>
				<td>Ћогин:</td>
				<td>
					<input type="text" name="login" value="<?php printText($login) ?>"/>
				</td>
			</tr>
			<tr>
				<td>ѕароль:</td>
				<td>	
					<input type="password" name="password"/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="¬ход" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$("#login-dialog").dialog({
				resizable: false,
				draggable: false
			}
		).bind("dialogbeforeclose",
			function() {
				return false
			}
		);
	});
</script>
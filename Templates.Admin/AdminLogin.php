<div id="login-dialog" title="����">
	<form method="post" action="<?= Command::GetRedirectUrl('AdminLogin'); ?>">
		<table>
			<tr>
				<td>�����:</td>
				<td>
					<input type="text" name="login" value="<?php printText($login) ?>"/>
				</td>
			</tr>
			<tr>
				<td>������:</td>
				<td>	
					<input type="password" name="password"/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="����" />
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
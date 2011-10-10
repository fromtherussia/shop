<style>
	#auth-info {
		height: 400px;
		padding: 20px;
		border-right: 1px solid #ccc;
	}
	
	#auth-form {
		padding: 20px;
		padding-left: 30px;
	}
	
	div.client-dialog {
		padding: 10px;
	}
	div.client-dialog form {
		margin-bottom: 20px;
	}
	
	div.client-dialog label {
		font-weight: bold;
	}
	
	div.client-dialog td {
		padding: 3px;
		padding-right: 20px;
	}
</style>
<script>
	function hideDialogs() {
		$('#login-dialog').hide();
		$('#register-dialog').hide();
		$('#recover-dialog').hide();
	}
	
	function showRegisterDialog() {
		hideDialogs();
		$('#register-dialog').fadeIn();
	}
	
	function showLoginDialog() {
		hideDialogs();
		$('#login-dialog').fadeIn();
	}
	
	function showRecoverDialog() {
		hideDialogs();
		$('#recover-dialog').fadeIn();
	}
	
	$(function() {
		showRegisterDialog();
	});
</script>
<!--<td id="auth-info" width="300px">
	<h3>����� ����������!</h3>
	<p>
		����� �� ����� ��������� ��� �����
		����� <a href="#" onclick="showRegisterDialog(); return false;">������������������</a> �� �����,
		������� ��� ����������� ��� ��������
		��������.<br /><br />
		���� �� ��� ���������������� <a href="#" onclick="showLoginDialog(); return false;">�������</a>
		Email � ������.<br /><br />
		������ ������? ������ ���������! <a href="#" onclick="showRecoverDialog(); return false;">������� ����</a>.
		<br /><br />
		���� � ��� �������� �������� � ������� ������:
		<a href="mailto:support@mir-ribalki-ru">support@mir-ribalki-ru</a>.
	</p>
</td>-->
<div style="padding: 10px; border: 1px solid #ccc">
<?php
	renderArticle('registerTop');
?>
</div>
<div id="auth-form">
	<div class="client-dialog" id="login-dialog">
		<h3>�� ��� ���������� ������ � ���?</h3>
		<h4>����� ������� email � ������, ��������� ��� ����������� � �� �������� ���� ���������� ������!</h4>
		<small><a href="#" onclick="showRegisterDialog(); return false;">��� �� � ��� �������</a></small>&nbsp;/&nbsp;
		<small><a href="#" onclick="showRecoverDialog(); return false;">�� ���� ��������� ������</a></small>
		<hr />
		<form method="post" action="<?= Command::GetRedirectUrl('ClientLogin', array('act' => 'login')); ?>">
			<table>
				<tr>
					<td><label for="login_dialog_login">�����:</label></td>
					<td>
						<input type="text" id="login_dialog_login" name="login" size="40" value="<?php printText($login) ?>"/>
					</td>
				</tr>
				<tr>
					<td><label for="login_dialog_password" size="30">������:</label></td>
					<td>	
						<input type="password" id="login_dialog_password" name="password"/>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" value="����" />
						<input type="hidden" name="act" value="login" />
					</td>
				</tr>
			</table>
		</form>
		<hr />
	</div>

	<div class="client-dialog" id="register-dialog">
		<h3>
			������� ���������� ������ ��� ����� � ����<br />
			<small><a href="#" onclick="showLoginDialog(); return false;">� ��� ���������������</a></small>
		</h3>
		<hr />
		<form method="post" action="<?= Command::GetRedirectUrl('ClientLogin', array('act' => 'register')); ?>">
			<table>
				<tr>
					<td width="200px">
						<label for="register_dialog_organization_type">�������� ��� ������:</label>
					</td>
					<td>
						<input type="radio" id="register_dialog_organization_type" name="organization_type" value="2" checked="checked" onclick="showWholesaleInfo()" />�������<br />
						<div style="padding: 10px; border: 1px solid #ccc" id="wholesale-info">
							<?php
								renderArticle('registerWholesaleInfo');
							?>
						</div>
						<input type="radio" id="register_dialog_organization_type" name="organization_type" value="1" onclick="showRetailInfo()" />���������<br />
						<div style="padding: 10px; border: 1px solid #ccc" id="retail-info">
							<?php
								renderArticle('registerRetailInfo');
							?>
						</div>
						<script>
							function hideAllInfo() {
								$('#wholesale-info').hide();
								$('#retail-info').hide();
							}
							function showRetailInfo() {
								hideAllInfo();
								$('#retail-info').show();
								$('#register_dialog_name_label').text('���:');
							}
							function showWholesaleInfo() {
								hideAllInfo();
								$('#wholesale-info').show();
								$('#register_dialog_name_label').text('����������� / ��� ��:');
							}
							$(function() {
								showWholesaleInfo();
							});
						</script>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					</td>
				</tr>
				<tr>
					<td>
						<label id="register_dialog_name_label" for="register_dialog_name">��� � ��������:</label><br />
					</td>
					<td>
						<input type="text" id="register_dialog_name" name="name" size="40" value="<?php printText($name) ?>" /><br />
						
					</td>
				</tr>
				<tr>
					<td>
						<label for="register_dialog_phone">���������� �������:</label><br />
					</td>
					<td>
						<input type="text" id="register_dialog_phone" name="phone" size="40" value="<?php printText($phone) ?>" /><br />
						
					</td>
				</tr>
								<tr>
					<td><label for="register_dialog_login">�����:</label></td>
					<td>
						<input type="text" id="register_dialog_login" name="login" size="40" value="<?php printText($login) ?>"/>
					</td>
				</tr>
				<tr>
					<td><label for="register_dialog_email">Email:</label></td>
					<td>
						<input type="text" id="register_dialog_email" name="email" size="40" value="<?php printText($email) ?>"/>
					</td>
				</tr>
				<tr>
					<td><label for="register_dialog_password">������:</label></td>
					<td>	
						<input type="password" id="register_dialog_password" size="30" name="password"/>
					</td>
				</tr>
				<tr>
					<td><label for="register_dialog_password_confirm">��������� ������:</label></td>
					<td>	
						<input type="password" id="register_dialog_password_confirm" size="30" name="confirm_password"/>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" value="������� � ���������� ������" />
						<input type="hidden" name="act" value="register" />
					</td>
				</tr>
			</table>
		</form>
		<hr />
		<br />
	</div>
	
	<div class="client-dialog" id="recover-dialog">
		<h3>
			������� Email, ��������� ��� ����������� � �� ������ ��� ������ ��� �������������� ������<br />
			<small><a href="#" onclick="showLoginDialog(); return false;">��������� �����</a></small>
		</h3>
		<hr />
		<form method="post" action="<?= Command::GetRedirectUrl('ClientLogin', array('act' => 'recover')); ?>">
			<table>
				<tr>
					<td><label for="recover_dialog_email">Email:</label></td>
					<td>
						<input type="text" id="recover_dialog_email" name="login" size="40"/>
						<input type="submit" value="������������ ������" />
						<input type="hidden" name="act" value="recover" />
					</td>
				</tr>
			</table>
		</form>
		<hr />
	</div>
</div>
<div style="padding: 10px; border: 1px solid #ccc">
<?php
	renderArticle('registerBottom');
?>
</div>
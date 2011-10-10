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
	<h3>Добро пожаловать!</h3>
	<p>
		Чтобы мы могли выполнить ваш заказ
		нужно <a href="#" onclick="showRegisterDialog(); return false;">зарегистрироваться</a> на сайте,
		сообщив нам необходимые для доставки
		сведения.<br /><br />
		Если вы уже зарегистрированы <a href="#" onclick="showLoginDialog(); return false;">введите</a>
		Email и пароль.<br /><br />
		Забыли пароль? Ничего страшного! <a href="#" onclick="showRecoverDialog(); return false;">Нажмите сюда</a>.
		<br /><br />
		Если у Вас возникли проблемы с заказом пишите:
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
		<h3>Вы уже заказывали товары у нас?</h3>
		<h4>Тогда введите email и пароль, указанные при регистрации и мы вспомним ваши контактные данные!</h4>
		<small><a href="#" onclick="showRegisterDialog(); return false;">Все же я тут впервые</a></small>&nbsp;/&nbsp;
		<small><a href="#" onclick="showRecoverDialog(); return false;">Не могу вспомнить пароль</a></small>
		<hr />
		<form method="post" action="<?= Command::GetRedirectUrl('ClientLogin', array('act' => 'login')); ?>">
			<table>
				<tr>
					<td><label for="login_dialog_login">Логин:</label></td>
					<td>
						<input type="text" id="login_dialog_login" name="login" size="40" value="<?php printText($login) ?>"/>
					</td>
				</tr>
				<tr>
					<td><label for="login_dialog_password" size="30">Пароль:</label></td>
					<td>	
						<input type="password" id="login_dialog_password" name="password"/>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" value="Вход" />
						<input type="hidden" name="act" value="login" />
					</td>
				</tr>
			</table>
		</form>
		<hr />
	</div>

	<div class="client-dialog" id="register-dialog">
		<h3>
			Укажите контактные данные для связи с Вами<br />
			<small><a href="#" onclick="showLoginDialog(); return false;">Я уже зарегистрирован</a></small>
		</h3>
		<hr />
		<form method="post" action="<?= Command::GetRedirectUrl('ClientLogin', array('act' => 'register')); ?>">
			<table>
				<tr>
					<td width="200px">
						<label for="register_dialog_organization_type">Выберите вид заказа:</label>
					</td>
					<td>
						<input type="radio" id="register_dialog_organization_type" name="organization_type" value="2" checked="checked" onclick="showWholesaleInfo()" />Оптовый<br />
						<div style="padding: 10px; border: 1px solid #ccc" id="wholesale-info">
							<?php
								renderArticle('registerWholesaleInfo');
							?>
						</div>
						<input type="radio" id="register_dialog_organization_type" name="organization_type" value="1" onclick="showRetailInfo()" />Розничный<br />
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
								$('#register_dialog_name_label').text('ФИО:');
							}
							function showWholesaleInfo() {
								hideAllInfo();
								$('#wholesale-info').show();
								$('#register_dialog_name_label').text('Организация / ФИО ИП:');
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
						<label id="register_dialog_name_label" for="register_dialog_name">Имя и отчество:</label><br />
					</td>
					<td>
						<input type="text" id="register_dialog_name" name="name" size="40" value="<?php printText($name) ?>" /><br />
						
					</td>
				</tr>
				<tr>
					<td>
						<label for="register_dialog_phone">Контактный телефон:</label><br />
					</td>
					<td>
						<input type="text" id="register_dialog_phone" name="phone" size="40" value="<?php printText($phone) ?>" /><br />
						
					</td>
				</tr>
								<tr>
					<td><label for="register_dialog_login">Логин:</label></td>
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
					<td><label for="register_dialog_password">Пароль:</label></td>
					<td>	
						<input type="password" id="register_dialog_password" size="30" name="password"/>
					</td>
				</tr>
				<tr>
					<td><label for="register_dialog_password_confirm">Повторите пароль:</label></td>
					<td>	
						<input type="password" id="register_dialog_password_confirm" size="30" name="confirm_password"/>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" value="Перейти к оформлению заказа" />
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
			Введите Email, указанный при регистрации и мы вышлем вам ссылку для восстановления пароля<br />
			<small><a href="#" onclick="showLoginDialog(); return false;">Вернуться назад</a></small>
		</h3>
		<hr />
		<form method="post" action="<?= Command::GetRedirectUrl('ClientLogin', array('act' => 'recover')); ?>">
			<table>
				<tr>
					<td><label for="recover_dialog_email">Email:</label></td>
					<td>
						<input type="text" id="recover_dialog_email" name="login" size="40"/>
						<input type="submit" value="Восстановить пароль" />
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
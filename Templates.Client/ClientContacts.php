<h3>Моя контактная информация</h3>
<hr />
<table>
	<tr>
		<td><label>Email</label></td>
		<td><?= $userInfo['login']; ?></td>
	</tr>
	<tr>
		<td><label>Имя</label></td>
		<td><?= $userInfo['name']; ?></td>
	</tr>
	<tr>
		<td><label>Номер телефона</label></td>
		<td><?= $userInfo['phone']; ?></td>
	</tr>
</table>
<hr />
<a href="#">Изменить</a>
<div class="tab-content-wrapper">
	<form method="post" action="<?= Command::GetRedirectUrl('AdminEditCompanyInfo'); ?>">
		<table>
			<tr>
				<td>
					Важная информация
				</td>
				<td>
					<?php
						render_wisywig('important_info', $important_info);
					?>
				</td>
			</tr>
			<tr>
				<td>
					Контактная информация
				</td>
				<td>
					<?php
						render_wisywig('contact_info', $contact_info);
					?>
				</td>
			</tr>
			<tr>
				<td>
					Информация о компании
				</td>
				<td>
					<?php
						render_wisywig('company_info', $company_info);
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="Сохранить изменения" />
				</td>
			</tr>
		</table>
	</form>
</div>
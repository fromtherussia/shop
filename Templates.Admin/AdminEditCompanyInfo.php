<div class="tab-content-wrapper">
	<form method="post" action="<?= Command::GetRedirectUrl('AdminEditCompanyInfo'); ?>">
		<table>
			<tr>
				<td>
					������ ����������
				</td>
				<td>
					<?php
						render_wisywig('important_info', $important_info);
					?>
				</td>
			</tr>
			<tr>
				<td>
					���������� ����������
				</td>
				<td>
					<?php
						render_wisywig('contact_info', $contact_info);
					?>
				</td>
			</tr>
			<tr>
				<td>
					���������� � ��������
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
					<input type="submit" value="��������� ���������" />
				</td>
			</tr>
		</table>
	</form>
</div>
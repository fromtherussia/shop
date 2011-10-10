<?php

class VerifiableForm {
	private $m_formRows;
	private $m_url;
	private $m_id;

	public function __construct($id, $url) {
		$this->m_id = $id;
		$this->m_url = $url;
		$this->m_formRows = array();
	}
	
	public function AddRow($rowName, FormRow $formRow) {
		$this->m_formRows[$rowName] = $formRow;
	}
	
	public function GetRow($rowName) {
		if (!isExists($rowName, $this->m_formRows)) {
			return NULL;
		}
		
		return $this->m_formRows[$rowName];
	}
	
	// Validate all form
	public function Validate() {
		foreach ($this->m_formRows as $rowName => $row) {
			if (!$row->Validate() && $row->IsRequired()) {
				return false;
			}
		}
		return true;
	}
	
	// Render all form
	public function Render() {
		?>
		<form method="post" action="<?= $this->m_url; ?>" id="<?= $this->m_id; ?>">
			<table>
				<?php
					$renderInfo = array(
						'formId' => $this->m_id
					);
					foreach ($this->m_formRows as $rowName => $row) {
						$row->Render($renderInfo);
					}
				?>
			</table>
		</form>
		<?php
	}
	
	// Render all form
	public function RenderRows() {
		?>
		<table>
			<?php
				$renderInfo = array(
					'formId' => $this->m_id
				);
				foreach ($this->m_formRows as $rowName => $row) {
					$row->Render($renderInfo);
				}
			?>
		</table>
		<?php
	}
	
	public function BeginForm() {
		?>
		<form method="post" action="<?= $this->m_url; ?>" id="<?= $this->m_id; ?>">
		<?php
	}
	
	public function EndForm() {
		?>
		</form>
		<?php
	}
}

abstract class FormRow {
	abstract public function Validate();
	abstract public function IsRequired();
	abstract public function IsFieldSet();
	abstract public function GetRowValue();
	abstract public function Render($renderInfo);
}

class HtmlRow extends FormRow {
	private $m_fieldContent;
	
	public function __construct($fieldContent) {
		$this->m_fieldContent = $fieldContent;
	}
	
	// FormRow interface impl.
	public function Validate() {
		return true;
	}
	
	public function IsRequired() {
		return false;
	}
	
	public function IsFieldSet() {
		return true;
	}
	
	public function GetRowValue() {
		return '';
	}
	
	public function Render($renderInfo) {
		echo '<tr><td colspan="2">' . $this->m_fieldContent . '</td></tr>';
	}
	// FormRow interface impl.
}

class SubmitField extends FormRow {
	private $m_title;
	
	public function __construct($title) {	
		$this->m_title = $title;
	}
	
	// FormRow interface impl.
	public function Validate() {
		return true;
	}
	
	public function IsRequired() {
		return false;
	}
	
	public function IsFieldSet() {
		return true;
	}
	
	public function GetRowValue() {
		return '';
	}
	
	public function Render($renderInfo) {
		echo '<tr><td>&nbsp;</td><td><button type="submit">' . $this->m_title . '</button></td></tr>';
	}
	// FormRow interface impl.
}

abstract class VerifiableFormField extends FormRow {
	private $m_fieldLabel;
	private $m_fieldId;
	private $m_defaultValue;
	private $m_isValid;
	private $m_fieldInitialValue;

	public function __construct($fieldLabel, $fieldId, $fieldInitialValue, $isRequired) {
		$this->m_fieldLabel = $fieldLabel;
		$this->m_fieldId = $fieldId;
		$this->m_isRequired = $isRequired;
		$this->m_fieldInitialValue = $fieldInitialValue;
	}
	
	// FormRow interface impl.
	public function Validate() {
		$this->m_isValid = $this->ValidateField();
		return $this->m_isValid;
	}
	
	public function IsRequired() {
		return $this->m_isRequired;
	}
	
	public function IsFieldSet() {
		return isExists($this->m_fieldId, $_POST);
	}
	
	// Through this method (if form valid) client gets submited data
	public function GetRowValue() {
		if ($this->IsFieldSet()) {
			return $this->GetFieldValue();
		} else if (!$this->IsRequired()) {
			return $this->GetDefaultValue();
		}
		
		return NULL;
	}
	
	// Through this method derrived classes recives current field value
	protected function GetRowValueToRender() {
		if ($this->IsFieldSet()) {
			return $this->GetFieldValue();
		} else {
			return $this->m_fieldInitialValue;
		}
	}
	
	public function Render($renderInfo) {
		$label = $this->m_fieldLabel;
		$id = $this->m_fieldId;
		echo "<tr><td width=\"200px\"><label for=\"$id\">$label</label></td><td>";
		$this->RenderField($renderInfo);
		echo "</td></tr>";
	}
	// FormRow interface impl.
	
	private function GetFieldValue() {
		return $_POST[$this->m_fieldId];
	}
	
	// Not used if field required
	private function GetDefaultValue() {
		return $this->m_defaultValue;
	}
	
	public function SetDefaultValue($defaultValue) {
		$this->m_defaultValue = $defaultValue;
	}
	
	abstract public function ValidateField();
	abstract public function RenderField($renderInfo);
} 

class TextInputWithLengthValidation extends VerifiableFormField {
	private $m_fieldId;
	private $m_minLength;
	private $m_maxLength;
	private $m_successMessage;
	private $m_errorMessage;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$successMessage,
		$errorMessage,
		$lengthMin,
		$lengthMax = 1000000,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_minLength = $lengthMin;
		$this->m_maxLength = $lengthMax;
		$this->m_successMessage = $successMessage;
		$this->m_errorMessage = $errorMessage;
	}
	
	public function RenderField($renderInfo) {
		?>
		<input type="text" id="<?= $this->m_fieldId; ?>" name="<?= $this->m_fieldId; ?>" value="<?= $this->GetRowValueToRender(); ?>" size="60" />
		<script>
			$(function () {
				// Adding length input checker
				checker = $('#<?= $this->m_fieldId; ?>').inputChecker({
					'validateCallback': getInputLengthValidator(
						'<?= $this->m_successMessage; ?>',
						'<?= $this->m_errorMessage; ?>',
						<?= $this->m_minLength; ?>,
						<?= $this->m_maxLength; ?>
					)
				})
				$('#<?= $renderInfo['formId']; ?>').formChecker().addChecker(checker);
			});
		</script>
		<?php
	}
	
	public function ValidateField() {
		$length = strlen($this->GetRowValue());
		return $length >= $this->m_minLength && $length <= $this->m_maxLength;
	}
}

class TextInputWithRegexpValidation extends VerifiableFormField {
	private $m_fieldId;
	private $m_regexp;
	private $m_successMessage;
	private $m_errorMessage;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$successMessage,
		$errorMessage,
		$regexp,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_regexp = $regexp;
		$this->m_successMessage = $successMessage;
		$this->m_errorMessage = $errorMessage;
	}
	
	public function RenderField($renderInfo) {
		?>
		<input type="text" id="<?= $this->m_fieldId; ?>" name="<?= $this->m_fieldId; ?>" value="<?= $this->GetRowValueToRender(); ?>" size="60"  />
		<script>
			$(function () {
				// Adding regexp input checker
				checker = $('#<?= $this->m_fieldId; ?>').inputChecker({
					'validateCallback': getRegexpInputValidator(
						'<?= $this->m_successMessage; ?>',
						'<?= $this->m_errorMessage; ?>',
						<?= $this->m_regexp; ?>
					)
				});
				$('#<?= $renderInfo['formId']; ?>').formChecker().addChecker(checker);
			});
		</script>
		<?php
	}
	
	public function ValidateField() {
		return true;
	}
}

class MultipleImagePicker extends VerifiableFormField {
	private $m_fieldId;
	private $m_minLength;
	private $m_maxLength;
	private $m_successMessage;
	private $m_errorMessage;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$successMessage,
		$errorMessage,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_successMessage = $successMessage;
		$this->m_errorMessage = $errorMessage;
	}
	
	public function RenderField($renderInfo) {
		?>
		<?php
			renderImageUpload($this->m_fieldId, 'foo');
		?>
		<script>
			function foo() {
				alert('foo');
			}
			$(function () {
				// Adding length input checker
				/*checker = $('#<?= $this->m_fieldId; ?>').inputChecker({
					'validateCallback': getInputLengthValidator(
						'<?= $this->m_successMessage; ?>',
						'<?= $this->m_errorMessage; ?>',
						<?= $this->m_minLength; ?>,
						<?= $this->m_maxLength; ?>
					)
				})*/
				/*$('#<?= $renderInfo['formId']; ?>').formChecker().addChecker(checker);*/
			});
		</script>
		<?php
	}
	
	public function ValidateField() {
		return true;
	}
}

class CheckboxInput extends VerifiableFormField {
	private $m_fieldId;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_regexp = $regexp;
	}
	
	public function RenderField($renderInfo) {
		?>
		<input type="checkbox" id="<?= $this->m_fieldId; ?>" name="<?= $this->m_fieldId; ?>" <?= $this->GetRowValueToRender() ? 'checked="checked"' : ''; ?>" />
		<?php
	}
	
	public function ValidateField() {
		return true;
	}
}

class HiddenInputWithRegexpValidation extends VerifiableFormField {
	private $m_fieldId;
	private $m_regexp;
	
	public function __construct(
		$fieldId,
		$fieldValue,
		$regexp,
		$isRequired = true) {
		parent::__construct('', $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_regexp = $regexp;
	}
	
	public function RenderField($renderInfo) {
		?>
		<input type="hidden" id="<?= $this->m_fieldId; ?>" name="<?= $this->m_fieldId; ?>" value="<?= $this->GetRowValueToRender(); ?>" />
		<?php
	}
	
	public function ValidateField() {
		return true;
	}
}

class SelectWithIsSetValidation extends VerifiableFormField {
	private $m_fieldId;
	private $m_successMessage;
	private $m_errorMessage;
	private $m_values;
	private $m_valuesFields;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$values, // entities
		$valuesFiels,
		$successMessage,
		$errorMessage,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_successMessage = $successMessage;
		$this->m_errorMessage = $errorMessage;
		$this->m_values = $values;
		$this->m_valuesFields = $valuesFiels;
	}
	
	public function RenderField($renderInfo) {
		$actualValue = $this->GetRowValueToRender();
		?>
		<select id="<?= $this->m_fieldId; ?>" name="<?= $this->m_fieldId; ?>">
			<?php
				foreach ($this->m_values as $entity) {
					$value = $entity->Get($this->m_valuesFields[0]);
					$name = $entity->Get($this->m_valuesFields[1]);
					$selected = '';
					if ($value == $actualValue) {
						$selected = 'selected="selected"';
					}
					?>
						<option value="<?= $value; ?>" <?= $selected; ?>><?= $name; ?></option>
					<?php
				}
			?>
		</select>
		<script>
			$(function () {
				// Adding regexp input checker
				checker = $('#<?= $this->m_fieldId; ?>').inputChecker({
					'validateCallback': getSelectIsSetValidator(
						'<?= $this->m_successMessage; ?>',
						'<?= $this->m_errorMessage; ?>'
					)
				});
				$('#<?= $renderInfo['formId']; ?>').formChecker().addChecker(checker);
			});
		</script>
		<?php
	}
	
	public function ValidateField() {
		return true;
	}
}

class WysywygInputField extends VerifiableFormField {
	private $m_fieldId;
	private $m_minLength;
	private $m_maxLength;
	private $m_successMessage;
	private $m_errorMessage;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$successMessage,
		$errorMessage,
		$lengthMin,
		$lengthMax = 1000000,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_minLength = $lengthMin;
		$this->m_maxLength = $lengthMax;
		$this->m_successMessage = $successMessage;
		$this->m_errorMessage = $errorMessage;
	}
	
	public function RenderField($renderInfo) {
		?>
		<div id="<?= $this->m_fieldId; ?>-wrapper">
		<?php
			renderTextEditor($this->m_fieldId, $this->GetRowValueToRender(), '320');
		?>
		</div>
		<script>
			$(function() {
				/*var node = ;
				var wrapper = $('#<?= $this->m_fieldId; ?>-wrapper');
				
				// Hack. Creating tmp object to correctly process first validation
				// initiated on creation
				var editor = {};
				editor.getCode = function () {
					return "";
				}
				node.data('LCWisywygObject', editor);
				// End of hack.
				
				var checker = wrapper.inputChecker({
					'input': node,
					'validateCallback': getWysiwygLengthValidator(
						'<?= $this->m_successMessage; ?>',
						'<?= $this->m_errorMessage; ?>',
						<?= $this->m_minLength; ?>)
					}
				);
				$('#<?= $renderInfo['formId']; ?>').formChecker().addChecker(checker);
				*/
				editor = $('#<?= $this->m_fieldId; ?>').redactor();
				/*node.data('LCWisywygObject', editor);
				
				// HACK: Manualy calling "input" by timer
				setInterval(
					function() {
						node.change();
					},
					2500
				);
				node.change();*/
			});
		</script>
		<?php
	}
	
	public function ValidateField() {
		//$length = strlen($this->GetRowValue()) / 2; 
		// Because post data contains html tags we should extract it or.. hmm calculate length aproximately.
		// So we  divide length by two
		return true; //$length >= $this->m_minLength && $length <= $this->m_maxLength;
	}
}

class TextareaInputField extends VerifiableFormField {
	private $m_fieldId;
	private $m_minLength;
	private $m_maxLength;
	private $m_successMessage;
	private $m_errorMessage;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$successMessage,
		$errorMessage,
		$lengthMin,
		$lengthMax = 1000000,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_minLength = $lengthMin;
		$this->m_maxLength = $lengthMax;
		$this->m_successMessage = $successMessage;
		$this->m_errorMessage = $errorMessage;
	}
	
	public function RenderField($renderInfo) {
	?>
		<textarea id="<?= $this->m_fieldId; ?>" name="<?= $this->m_fieldId; ?>" rows="10" cols="60"><?= $this->GetRowValueToRender(); ?></textarea>
		<script>
			$(function() {
				checker = $('#<?= $this->m_fieldId; ?>').inputChecker({
					'validateCallback': getInputLengthValidator(
						'<?= $this->m_successMessage; ?>',
						'<?= $this->m_errorMessage; ?>',
						20)
					}
				);
				$('#<?= $renderInfo['formId']; ?>').formChecker().addChecker(checker);
			});
		</script>
		<?php
	}
	
	public function ValidateField() {
		$length = strlen($this->GetRowValue()); 
		return $length >= $this->m_minLength && $length <= $this->m_maxLength;
	}
}

class DatePickerInputField extends VerifiableFormField {
	private $m_fieldId;
	private $m_successMessage;
	private $m_errorMessage;
	
	public function __construct(
		$fieldLabel,
		$fieldId,
		$fieldValue,
		$successMessage,
		$errorMessage,
		$isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
		$this->m_fieldId = $fieldId;
		$this->m_successMessage = $successMessage;
		$this->m_errorMessage = $errorMessage;
	}
	
	public function RenderField($renderInfo) {
		?>
		<input id="<?= $this->m_fieldId; ?>" name="<?= $this->m_fieldId; ?>" value="<?= formatDate($this->GetRowValueToRender()); ?>" size="60" />
		<script>
			$(function() {
				var node = $('#<?= $this->m_fieldId; ?>');
				
				node.datepicker({
					'onSelect': function() {
						node.change();
					}
				});
				/*
				node.datepicker(
					'option', $.extend({showMonthAfterYear: false}, $.datepicker.regional["ru"])
				);
				*/
				// Adding length input checker
				checker = node.inputChecker({
					'validateCallback': getDatePickerIsSetValidator(
						'<?= $this->m_successMessage; ?>',
						'<?= $this->m_errorMessage; ?>'
					)
				})
				$('#<?= $renderInfo['formId']; ?>').formChecker().addChecker(checker);
			});
		</script>
		<?php
	}
	
	public function ValidateField() {
		return true;
	}
}

/*
class TextareaInputField extends VerifiableFormField {
	public function __construct($fieldLabel, $fieldId, $fieldValue, $isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
	}
}



class CheckboxInputField extends VerifiableFormField {
	public function __construct($fieldLabel, $fieldId, $fieldValue, $isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
	}
}

class SelectInputField extends VerifiableFormField {
	public function __construct($fieldLabel, $fieldId, $fieldValue, $fieldValues, $isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
	}
}

class AutocompleteInputField extends VerifiableFormField {
	public function __construct($fieldLabel, $fieldId, $fieldValue, $fieldValues, $isRequired = true) {
		parent::__construct($fieldLabel, $fieldId, $fieldValue, $isRequired);
	}
}
*/

?>
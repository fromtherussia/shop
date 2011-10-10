<?php

function limitString($text, $limit = 20, $ending = '...') {
	if (strlen($text) <= $limit) {
		return $text;
	}
	return substr($text, 0, $limit) . $ending;
}

function formatDate($date) {
	return date("d.m.Y", strtotime($date));
}

define("TEMPLATE_DEFAULT_COUNT_SYMBOLS", 60);
define("TEMPLATE_DEFAULT_COUNT_ROWS", 2);

class Template {
	private $m_params = array();
	private $m_templateName;
	private $m_templateDirectory;
	private $m_messageType;
	private $m_message;
	private static $m_defaultPath;
	
	const MESSAGE_TYPE_SUCCESS = 0;
	const MESSAGE_TYPE_ERROR = 1;
	
	const defaultCountSymbols = 60;
	const defaultCountRows = 2;
	
	public function __construct($templateName, $templateDirectory = "") {
		$this->m_templateName = $templateName;
		$this->m_templateDirectory = $templateDirectory;
	}
	
	public function CopyTemplate(Template $template) {
		$this->m_message = $template->m_message;
		$this->m_messageType = $template->m_messageType;
	}
	
	public function SetParam($paramName, $paramValue) {
		$this->m_params[$paramName] = $paramValue;
	}
	
	public function GetParam($paramName) {
		return $this->m_params[$paramName];
	}
	
	public function Render() {
		if ($this->m_templateDirectory == "") {
			$templatesDirectory = self::$m_defaultPath;
		} else {
			$templatesDirectory = $this->m_templateDirectory;
		}
		extract($this->m_params);
		require($templatesDirectory . '/' . $this->m_templateName . '.php');
	}
    
	public function RenderMessage() {
		$message = GlobalMessage::Get();
		if ($message == NULL) {
			return;
		}
		$text = $message['text'];
		$type = $message['type'];
		switch ($type) {
			case GlobalMessage::SUCCESS:
				$messageType = '$.popupMessageType.success';
				break;
			case GlobalMessage::ERROR:
				$messageType = '$.popupMessageType.error';
				break;
		}
		echo '<div class="status-message">&nbsp;</div>';
		?>
		<script>
			$(function() {
				$('div.status-message')
					.popupMessage({'hideByTimer': true, 'timeVisible': 5000})
					.show('<?= $text; ?>', <?= $messageType; ?>);
			});
		</script>
		<?php
	}
	
	public function RenderLocalMessage() {
		$type = $this->m_messageType;
		$text = $this->m_message;
		
		switch ($type) {
			case Template::MESSAGE_TYPE_SUCCESS:
				$messageType = '$.popupMessageType.success';
				break;
			case Template::MESSAGE_TYPE_ERROR:
				$messageType = '$.popupMessageType.error';
				break;
		}
		echo '<div class="status-message">&nbsp;</div>';
		?>
		<script>
			$(function() {
				$('div.status-message')
					.popupMessage({'hideByTimer': true, 'timeVisible': 5000})
					.show('<?= $text ?>', <?= $messageType; ?>);
			});
		</script>
		<?php
	}
	
	public function SetMessage($messageText) {
		$this->m_message = $messageText;
		$this->m_messageType = Template::MESSAGE_TYPE_SUCCESS;
	}
	
	public function SetError($errorText) {
		$this->m_message = $errorText;
		$this->m_messageType = Template::MESSAGE_TYPE_ERROR;
	}
	
	public static function SetTemplatesPath($defaultPath) {
		self::$m_defaultPath = $defaultPath;
	}
}

function render_select($id, $options, $selectedId) {
	if (count($options) > 0) {
		echo '<select id="' . returnText($id) . '" name="' . returnText($id) . '">';
		foreach ($options as $id => $option) {
			echo '<option value="' . returnText($id) . '"' . ($id == $selectedId ? ' selected="selected"' : '') . '>' . returnText($option) . '</option>';
		}
		echo '</select>';
	}
}

function render_simple_autocomplete($id, $initialValue, $autocompleteData, $minLength) {
?>
	<script>
	$(function() {
		var dataRows = [
		<?
			$first = true;
			foreach ($autocompleteData as $dataRow) {
				if (!$first) {
					echo ',';
				}
				echo '"' . returnText($dataRow) . '"';
				$first = false;
			}
		?>
		];

		$("#<?php printText($id) ?>").autocomplete({
			minLength: <?php printText($minLength) ?>,
			source: dataRows
		});
	});
	</script>
	<input size="60" id="<?php printText($id) ?>" name="<?php printText($id) ?>" value="<?php printText($initialValue) ?>" />
<?
}

function render_autocomplete ($inputId, $inputIdValue, $inputHiddenIdValue, $autocompleteData, $minLength) {
?>
	<script>
	$(function() {
		var dataRows = [
		<?
			$first = true;
			foreach($autocompleteData as $dataRow)
			{
				if(!$first)
				{
					echo ',';
				}
				echo '{';
				echo 'value: "' . returnText($dataRow['value']) . '",';
				echo 'label: "' . returnText($dataRow['label']) . '"';
				echo '}';
				$first = false;
			}
		?>
		];
		$("#<?php printText($inputId . "_input") ?>").autocomplete({
			minLength: <?php printText($minLength) ?>,
			source: dataRows,
			focus: function(event, ui) {
				$("#<?php printText($inputId . "_input") ?>").val(ui.item.label);
				return false;
			},
			select: function(event, ui) {
				$("#<?php printText($inputId . "_input") ?>").val(ui.item.label);
				$("#<?php printText($inputId) ?>").val(ui.item.value);
				return false;
			}
		})
		.data("autocomplete")._renderItem = function(ul, item) {
			return $("<li></li>").data("item.autocomplete", item).append("<a>" + item.label + "</a>").appendTo(ul);
		};
	});
	</script>
	<input size="60" id="<?php printText($inputId . "_input") ?>" name="<?php printText($inputId . "_input") ?>" value="<?php printText($inputIdValue) ?>" />
	<input type="hidden" id="<?php printText($inputId) ?>" name="<?php printText($inputId) ?>" value="<?php printText($inputHiddenIdValue) ?>" />
<?
}

function render_textarea ($id, $value, $symbols = TEMPLATE_DEFAULT_COUNT_SYMBOLS, $rows = TEMPLATE_DEFAULT_COUNT_ROWS) {
	?>
		<textarea id="<?php printText($id) ?>" name="<?php printText($id) ?>" rows="<?php printText($rows) ?>" cols="<?php printText($symbols) ?>"><?php printText($value) ?></textarea>
	<?php
}

function render_wisywig ($id, $value, $symbols = TEMPLATE_DEFAULT_COUNT_SYMBOLS, $rows = TEMPLATE_DEFAULT_COUNT_ROWS) {
	?>
		<textarea class="ckeditor" id="<?php printText($id) ?>" name="<?php printText($id) ?>" rows="<?php printText($rows) ?>" cols="<?php printText($symbols) ?>"><?php echo $value; ?></textarea>
	<?php
}

function render_checkbox ($id, $checked) {
	?>
	<input type="checkbox" id="<?php printText($id) ?>" name="<?php printText($id) ?>"<?php echo $checked ? ' checked="checked"' : '' ?> />
	<?php
}

function render_input ($id, $value, $symbols = TEMPLATE_DEFAULT_COUNT_SYMBOLS) {
	?>
		<input type="text" id="<?php printText($id) ?>" name="<?php printText($id) ?>" size="<?php printText($symbols) ?>" value="<?php printText($value) ?>" />
	<?php
}

function render_password_input ($id, $value, $symbols = TEMPLATE_DEFAULT_COUNT_SYMBOLS) {
	?>
		<input type="password" id="<?php printText($id) ?>" name="<?php printText($id) ?>" size="<?php printText($symbols) ?>" value="<?php printText($value) ?>" />
	<?php
}

function render_hidden_input ($id, $value, $symbols = TEMPLATE_DEFAULT_COUNT_SYMBOLS) {
	?>
		<input type="hidden" id="<?php printText($id) ?>" name="<?php printText($id) ?>" size="<?php printText($symbols) ?>" value="<?php printText($value) ?>" />
	<?php
}

function render_datepicker ($id, $value) {
	?>
		<input id="<?php printText($id) ?>" value="<?php printText($value) ?>" name="<?php printText($id) ?>" />
		<script>
			$('#<?php printText($id) ?>').datepicker();
			$('#<?php printText($id) ?>').datepicker(
				'option', $.extend({showMonthAfterYear: false}, $.datepicker.regional["ru"])
			);
		</script>
	<?php
}

function render_treeview ($id, $data, $categoriesPath = array(), $openedCategory = -1) {
	$idString = "";
	$classString = "";
	if ($id != "") {
		$idString = ' id="' . returnText($id) . '"';
	}
	echo "<ul$idString>";
	foreach ($data as $row) {
		$itemName = $row['tree_item_name'];
		$itemTitle = $row['tree_item_title'];
		$itemHref = $row['tree_item_href'];
		$itemId = $row['tree_item_id'];
		if (count($categoriesPath) > 0 && in_array($itemId, $categoriesPath)) {
			if ($openedCategory == $itemId) {
				echo "<li title=\"$itemTitle\" class=\"open\"><a href=\"$itemHref\"><b>$itemName</b></a>";
			} else {
				echo "<li title=\"$itemTitle\" class=\"open\"><a href=\"$itemHref\">$itemName</a>";
			}
		} else {
			echo "<li title=\"$itemTitle\"><a href=\"$itemHref\">$itemName</a>";
		}
		if (array_key_exists('tree_item_subnodes', $row)) {
			render_treeview("", $row['tree_item_subnodes'], $categoriesPath, $openedCategory);
		}
		echo "</li>";
	}
	echo "</ul>";
	if ($id != "") {
?>
	<script>
		$(document).ready(function () {
			$("#<?= $id; ?>").treeview({
				persist: "location",
				collapsed: true,
				unique: true
			});
		});
	</script>
<?
	}
}

function render_autocomplete_formated_data ($id, $selectedValue, $valueName, $labelNames, $formaterName, $minLength, $dataRows) {
    if (count($dataRows) > 0) {
        $selectedName = '';
        $selectedRows = array();
        foreach ($dataRows as $dataRow) {
            $value = returnText($dataRow[$valueName]);
            $labelRows = array();
            foreach ($labelNames as $labelName) {
                $labelRows[] = returnText($dataRow[$labelName]);
            }
            $label = '';
            eval('$label=' . $formaterName . '("' . implode($labelRows, '","') . '");');
            if ($value == $selectedValue) {
                $selectedName = $label;
            }
            $selectedRows[] = array('value' => $value, 'label' => $label);
        }
        render_autocomplete($id, $selectedName, $selectedValue, $selectedRows, $minLength);
    }
}
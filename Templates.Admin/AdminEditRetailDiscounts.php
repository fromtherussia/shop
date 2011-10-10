<?php
	renderActionsPanel(
		array(
			array(
				'href' => '#',
				'text' => 'Добавить диапазон для скидки',
				'onclick' => 'addRange'
			),
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditWholesaleDiscounts'),
				'text' => 'Перейти к оптовым скидкам'
			)
		)
	);
?>
<div class="tab-content">
	<style>
		#discounts {
			margin-bottom: 20px;
		}
		#discounts td {
			padding: 5px;
		}
		
		#discounts td.precent-input {
			width: 200px;
		}
		
		#discounts td.precent-input input {
			text-align: right;
			width: 50px;
		}
		
		#discounts td.range-input {
			padding: 10px;
			padding-right: 15px;
		}
		
		#discounts div.range-values {
			margin-top: 10px;
		}
	</style>
	<h3>Диапазоны розничных скидок</h3>
	<hr />
	<form method="POST" action="<?= $saveHref;?>">
		<div id="discounts">&nbsp;</div>
		<hr />
		<button type="submit">Сохранить</button>
	</form>
	<script>
		var rangeCounter = 0;
		function addDiscountRange(precent, begin, end) {
			rangePrecent = 'discount-precent[' + rangeCounter + ']';
			rangeBeginName = 'discount-range-begin[' + rangeCounter + ']';
			rangeEndName = 'discount-range-end[' + rangeCounter + ']';
			
			inputPrice = $('<div><span>Cкидка: <input type="text" maxlength="2" name="' + rangePrecent + '" value="' + precent + '"/>%</span></div>');
			rangeInput = $('<div><div class="slider" style="width: 100%">&nbsp;</div><div class="range-values"><div class="left">0 руб.</div><div class="right">100000 руб.</div><br class="clear" /></div></div>');
			range = $('<div><table><tr><td class="precent-input"></td><td class="range-input"></td></tr></table></div>');
			range.find('td:eq(0)').append(inputPrice);
			range.find('td:eq(1)').append(rangeInput);
			
			var rangeBeginInput = $('<input type="hidden" name="' + rangeBeginName + '" value="' + begin + '" />');
			var rangeEndInput = $('<input type="hidden" name="' + rangeEndName + '" value="' + end + '" />');
			var rangeText = $('<div>&nbsp;</div>');
			
			inputPrice.append(rangeText);
			rangeInput.append(rangeBeginInput).append(rangeEndInput);
			
			function updateRangeText(beginValue, endValue) {
				rangeBeginInput.val(beginValue);
				rangeEndInput.val(endValue);
				rangeText.text('От ' + beginValue + ' до ' + endValue + ' руб.')
			}
			
			range.find('div.slider').slider({
				range: true,
				min: 0,
				max: 100000,
				step: 1000,
				values: [begin, end],
				change: function(event, ui) {
					updateRangeText($(this).slider('values', 0), $(this).slider('values', 1));
				}
			});
			
			$('#discounts').dynamicList().addItem(range);
			updateRangeText(begin, end);
			rangeCounter++;
		}
		
		function addRange() {
			addDiscountRange(0, 0, 100000);
		}
		
		$(function() {
			<?php
				foreach ($discounts as $discount) {
					$precent = $discount['precent'];
					$rangeBegin = $discount['range_begin'];
					$rangeEnd = $discount['range_end'];
					echo "addDiscountRange($precent, $rangeBegin, $rangeEnd);";
				}
			?>
		});
	</script>
</div>

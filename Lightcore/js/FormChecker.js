(function($){
	function inputValidStateVisualizer(node) {
		var currentVisualizer = this;
		var wrapperHtml = '<div class="checkable-control" />';
		var statusIconHtml = '<div><div class="icon">&nbsp;</div><div class="message left">&nbsp;</div><br class="clear" /></div>';
		
		node.wrap(wrapperHtml).after(statusIconHtml);
		
		currentVisualizer.m_icon = node.parent().find('div.icon');
		currentVisualizer.m_message = node.parent().find('div.message');
		currentVisualizer.m_wrapper = node.parent();
		
		function setText(text) {
			currentVisualizer.m_message.text(text);
		}
		
		function clearIconClass() {
			return currentVisualizer.m_icon.removeClass();
		}
		
		function clearWrapperClass() {
			return currentVisualizer.m_wrapper.removeClass();
		}
		
		currentVisualizer.setError = function(text) {
			clearWrapperClass().addClass('error checkable-control');
			clearIconClass().addClass('error icon left');
			setText(text);
		}
		
		currentVisualizer.setSuccess = function(text) {
			clearWrapperClass().addClass('success checkable-control');
			clearIconClass().addClass('success icon left');
			setText(text);
		}
	}
	
	function inputChecker(node, options) {
		var currentInputChecker = this;
		currentInputChecker.m_validStateVisualizer = new inputValidStateVisualizer(node);
		currentInputChecker.m_validateCallback = options.validateCallback;
		
		function validate() {
			result = currentInputChecker.m_validateCallback($.isValid(options.input) ? options.input : node);
			
			if (result.isValid) {
				currentInputChecker.m_validStateVisualizer.setSuccess(result.successText);
			} else {
				currentInputChecker.m_validStateVisualizer.setError(result.errorText);
			}
			return result.isValid;
		}
		
		// Validate node when changed
		if ($.isValid(options.input)) {
			options.input.change(function() {
				validate();
			});
		} else {
			node.change(function() {
				validate();
			});
		}
		
		// Public interface.
		
		currentInputChecker.isValid = function() {
			return validate();
		}
		
		validate(); // Validate when constructed
	}
	
	function formChecker(node) {
		var checkerObj = this;
		checkerObj.m_checkers = new Array();
		
		function validateInputs() {
			for(checkerIndex in checkerObj.m_checkers) {
				if (!checkerObj.m_checkers[checkerIndex].isValid()) {
					return false;
				}
			}
			return true;
		}
		
		var submitButton = $(node).find('button[type="submit"]');
		submitButton.click(
			function () {
				result = validateInputs();
				if (result) {
					checkerObj.m_readyStateVisualizer.setSuccess("¬се пол€ заполнены");
				} else {
					checkerObj.m_readyStateVisualizer.setError("—охранение невозможно: заполнены не все об€зательные пол€");
				}
				return result;
			}
		);
		
		checkerObj.m_readyStateVisualizer = new inputValidStateVisualizer(submitButton);
        
		// Public interface.
		
		checkerObj.addChecker = function(checker) {
			checkerObj.m_checkers.push(checker);
        }
		
        return checkerObj;
    }
	
	/*
		inputChecker class.
		
		Usage: $().inputChecker(options)
		Options:
			validateCallback: function called when input value changed
	*/
	
	$.fn.inputChecker = function(options) {
		return $.cachedVisualPlugin(this, inputChecker, options);
	}
	
	/*
		formChecker class.
		
		Usage: $().formChecker()
		Options:
			none
	*/
	
	$.fn.formChecker = function(options) {
        return $.cachedVisualPlugin(this, formChecker, options);
    }
})(jQuery);

/*
	Validation functions
*/

function getValidationStatus(condition, successText, errorText) {
	if (condition) {
		return {
			isValid: true,
			successText: successText
		};
	} else {
		return {
			isValid: false,
			errorText: errorText
		};
	}
}

// Length in range [minLength, maxLength]
function getInputLengthValidator(successText, errorText, minLength, maxLength) {
	return function (input) {
		if ($.isValid(maxLength) && input.val().length >= minLength && input.val().length <= maxLength) {
			return {
				isValid: true,
				successText: successText
			};
		}
		return getValidationStatus(input.val().length >= minLength, successText, errorText);
	}
}

function getWysiwygLengthValidator(successText, errorText, minLength, maxLength) {
	return function (node) {
		text = $(node.data('LCWisywygObject').getCode()).text();
		isValid = $.isValid(maxLength) ? text.length >= minLength && text.length <= maxLength : text.length >= minLength;
		return getValidationStatus(isValid, successText, errorText);
	}
}

// Validates that some value choosen in autocomplete
function getAutocompleteChoosenValidator(successText, errorText) {
	return function validateCategoryInput(input) {
		value = input.find('input:hidden').val();
		return getValidationStatus($.isValid(value) && value.length != 0, successText, errorText);
	}
}

// Validates that value is numeric
function getNumericInputValidator(successText, errorText, isPositive) {
	return function validateArticleInput(input) {
		if ($.isValid(isPositive) && isPositive) {
			return getValidationStatus(input.val() != '' && !isNaN(input.val()) && input.val() > 0, successText, errorText);
		} else {
			return getValidationStatus(input.val() != '' && !isNaN(input.val()), successText, errorText);
		}
	}
}

// Validates that value is numeric
function getRegexpInputValidator(successText, errorText, regexp) {
	return function validateArticleInput(input) {
		return getValidationStatus(input.val() != '' && input.val().match(regexp), successText, errorText);
	}
}

// Validates that select  is set
function getSelectIsSetValidator(successText, errorText) {
	return function validateArticleInput(input) {
		return getValidationStatus(input.val() > 0, successText, errorText);
	}
}

// Validates that datepicker is set
function getDatePickerIsSetValidator(successText, errorText) {
	return function validateArticleInput(input) {
		return getValidationStatus(input.val().length > 0, successText, errorText);
	}
}

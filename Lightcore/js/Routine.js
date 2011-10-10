(function($){
	
	/*
		Enable/Disable text selection.
	*/
	
	jQuery.getAttributes=function(F,C){var F=((typeof F==="string")?jQuery(F)[0]:F[0]),D=0,F=F.attributes,B=F.length,E=["abort","blur","change","click","dblclick","error","focus","keydown","keypress","keyup","load","mousedown","mousemove","mouseout","mouseover","mouseup","reset","resize","select","submit","unload"],A={};for(D;D<B;D++){if(C||!C&&jQuery.inArray(F[D].nodeName.replace(/^on/,""),E)==-1){A[F[D].nodeName]=F[D].nodeValue}}return A}
	
	jQuery.fn.disableTextSelect = function() {
		return this.each(function() {
			$(this)
				.css({'MozUserSelect': 'none'})
				.bind('selectstart', function() {return false;})
				.mousedown(function() {return false;});
		});
	};

	jQuery.fn.enableTextSelect = function() {
		return this.each(function() {
			$(this).css({'MozUserSelect': ''})
				.unbind('selectstart')
				.mousedown(function() {return true;});
		});
	};

	/*
		Misc utility functions.
	*/

	$.debugPrint = function(obj) {
		var text = '';
		for (field in obj) {
			text += 'field: ' + field + ', value: ' + obj[field] + '\n';
		}
		alert(text);
	}
	
	$.assert = function(condition, message) {
		if (!condition) {
			alert(message);
		}
	}
	
    $.isValid = function(obj) {
        return obj != undefined && obj != null;
    }
    
	$.isKeyExists = function(arrayToCheck, key) {
        if (!$.isValid(arrayToCheck) || !$.isValid(key)) {
            return false;
        }
        
		if(!$.isValid(arrayToCheck[key])) {
            return false;
        }
        return true;
    }
	
    $.isKeysExists = function(arrayToCheck, arrayKeys) {
        if (!$.isValid(arrayToCheck) || !$.isValid(arrayKeys)) {
            return false;
        }
        
		for (key in arrayKeys) {
            if(!$.isValid(arrayToCheck[key])) {
                return false;
            }
        }	
        return true;
    }
})(jQuery);

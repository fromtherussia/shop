(function($){
	/* 
		Timer class.
		
		Usage: $.timer(options)
		Options:
			timeout: t/o in msecs
			callback: callback function
			repeat: true/false [default false]
	*/
	
	$.timer = function (options) {
        var currentTimerObject = this;
        
        function Start() {
            if ($.isValid(currentTimerObject.m_timeoutRef)) {
                if (!currentTimerObject.m_repeat) {
                    clearTimeout(currentTimerObject.m_timeoutRef);
                    currentTimerObject.m_timeoutRef = null;
                }
            }
            
            if (currentTimerObject.m_repeat) {
                currentTimerObject.m_timeoutRef = setInterval(
                    function () {
                        currentTimerObject.m_callback();
                    },
                    currentTimerObject.m_timeout
                );
            } else {
                currentTimerObject.m_timeoutRef = setTimeout(
                    function () {
                        currentTimerObject.m_timeoutRef = null;
                        currentTimerObject.m_callback();
                    },
                    currentTimerObject.m_timeout
                );
            }
        }
		
        function Stop() {
            if ($.isValid(currentTimerObject.m_timeoutRef)) {
                if (!currentTimerObject.m_repeat) {
                    clearTimeout(currentTimerObject.m_timeoutRef);
                } else {
                    clearInterval(currentTimerObject.m_timeoutRef);
                }
                currentTimerObject.m_timeoutRef = null;
            }
        }
        
		function Construct(options) {
			if (!$.isValid(options.timeout) || !$.isValid(options.callback)) {
				throw 'timer. not all options set';
			}
            
			currentTimerObject.m_timeout = options.timeout;
            currentTimerObject.m_callback = options.callback;
            currentTimerObject.m_repeat = $.isValid(options.repeat) ? options.repeat : false;
            
			Start();
        }
		
		// Public interface
		
        currentTimerObject.start = function () {
            Start();
        }
		
        currentTimerObject.stop = function () {
            Stop();
        }
		
        Construct(options);
        return currentTimerObject;
    }
})(jQuery);

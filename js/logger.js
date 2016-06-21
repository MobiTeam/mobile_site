;(function($){

	$(document).ready(function() {

		$(window).on('error', _sendErrorOnServer);

		function _sendErrorOnServer(e) {

			var originalEvent = e.originalEvent,
				stack = originalEvent.error.stack,
				msg = navigator.userAgent + '\n' + originalEvent.error.toString();

			if(stack) {
				msg += '\n' + stack;
			}	

			var name = getJSON('auth_inf') ? getJSON('auth_inf').FIO : 'Гость';
		
			
			new Image().src='oracle/errorReport.php?who=' + name + '&e=' + msg;

			return true;

		}

	})

})(jQuery)
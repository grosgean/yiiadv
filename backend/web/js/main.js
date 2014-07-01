/**
 * vano
 */
(function ($) {

	$('.goto').click(function(){
		document.location.href = this.getAttribute('rel');
	});

})(window.jQuery);

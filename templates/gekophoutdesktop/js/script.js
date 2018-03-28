/* Author:
	Eddy
	www.webdelta.nl
*/
jQuery.noConflict();
jQuery( document ).ready(function( $ ) {
	$('.nav .dropdown').hover(function() {
		$(this).find('.dropdown-menu').first().stop(true, true).slideDown();
	}, function() {
		$(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();
	});
});

jQuery( document ).ready(function( $ ) {
	jQuery('#toggle1').click(function(){
	    $(this).toggleClass('toggle-sluiten');
			$('.item1').toggleClass('item-open');
	});

	jQuery('#toggle2').click(function(){
			$(this).toggleClass('toggle-sluiten');
			$('.item2').toggleClass('item-open');
	});

	jQuery('#toggle3').click(function(){
			$(this).toggleClass('toggle-sluiten');
			$('.item3').toggleClass('item-open');
	});
});

( function( $ ) {

	$( '.query' ).each(function(i, el){
		var height = $(this).find("pre").height();

		$(this).find("textarea").css({
			height: height + 'px'
		});

	});

})( jQuery );
jQuery('document').ready( function($){

	$('.basepress-tab-switch').click( function(){
		var tab = $(this).attr('id');
		var url = new URL(window.location.href);
		url.searchParams.set("tab", tab);

		history.pushState( {'tab': tab}, '', url.href );
		$( 'input[name="_wp_http_referer"]' ).attr( 'value', url.href );
	});
});
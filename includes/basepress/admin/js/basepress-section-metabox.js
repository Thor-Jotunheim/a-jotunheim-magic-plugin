jQuery( document ).ready(function( $ ) {
	var is_not_empty =   $( '.basepress_section_mb' ).hasClass( 'smb_not_empty' );
	if ( is_not_empty === false ) {
		var product = $( '.basepress_product_mb' ).find(":selected").val();
		if( product != '' || product != null || product != 'undefined' ){
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
						action: 'basepress_get_product_sections',
						product: product
					},
				success: function( response ){
					var sections = $( '.basepress_section_mb' );
					sections.replaceWith( response );
				}
			});
		}
	}
});

jQuery( 'window' ).ready( function( $ ){
	$( '.basepress_product_mb' ).change( function(){
		var product = $( this ).val();

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
					action: 'basepress_get_product_sections',
					product: product
				},
			success: function( response ){
				var sections = $( '.basepress_section_mb' );
				sections.replaceWith( response );
			}
		});
	});
});
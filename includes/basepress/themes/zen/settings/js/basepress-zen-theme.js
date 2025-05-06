jQuery(function( $ ){

	$( document ).ready( function(){

		/**
		 * Toggle Settings
		 */
		$( '#enable-setting' ).change( function(){
			$( '.bpmt-card.settings-card' ).slideToggle( 'slow' );
		});

		if( $( '#enable-setting' ).prop( 'checked' )){
			$( '.bpmt-card.settings-card' ).slideToggle( 'slow' );
		}

		$('.bp-color-field').each( function(){
			$(this).wpColorPicker();
		});

		/**
		 * Save settings
		 */
		$( '#save-settings' ).click( function( e ){
			e.preventDefault();
			var settings = $( '#bpmt-zen-theme' ).serialize();

			$( this ).addClass( 'saving' ).prop( 'disabled', true );

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data:{
					action:	'basepress_zen_theme_save',
					settings: settings
				},

				success: function( response ){
					if( response.error ){
						console.log( response.data );
					}
					else{

					}
				},

				error: function(  jqXHR, textStatus, errorThrown){
					console.log( errorThrown );
				},

				complete: function(){
					$( '#save-settings' ).removeClass( 'saving' ).prop( 'disabled', false );
				}
			});

		});

	});//End jQuery
});
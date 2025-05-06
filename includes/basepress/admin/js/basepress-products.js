jQuery( 'document' ).ready( function($){
	
	
	/*
	 *	Add product image
	 */
	$( '#select-image' ).click( function(){
		var frame;

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create a new media frame
		frame = new wp.media({
			multiple: false,
			library: { type: 'image' }
		});

		frame.open();

		frame.on( 'select', function(){
			var image = frame.state().get( 'selection' ).toJSON();
			var imageWidth = image[0].width;
			var imageHeight = image[0].height;
			var orientation = imageWidth < imageHeight ? 'vertical' : 'horizontal';
			$( '#new-basepress-product img' )
				.attr( 'src', image[0].url )
				.removeClass()
				.addClass( orientation )
				.show();
			
			$( '#product-image-url' ).attr( 'value', image[0].url );
			$( '#product-image-width' ).attr( 'value', image[0].width );
			$( '#product-image-height' ).attr( 'value', image[0].height );
		});
	});
	
	
	/*
	 *	Remove product image
	 */
	$( '#remove-image' ).click( function(){
		$( '#new-basepress-product img' )
			.attr( 'src', '' )
			.removeClass()
			.hide();
		
		$( '#product-image-url' ).attr( 'value', '' );
		$( '#product-image-width' ).attr( 'value', '' );
		$( '#product-image-height' ).attr( 'value', '' );
	});
	
	
	/*
	 *	Add product
	 */
	$( '#add-product' ).click( function( event ){
		event.preventDefault();
		
		if( isFormValid( 'add' ) ){
			$( '#ajax-loader' ).show();
			
			var form = $( '#new-basepress-product' ).serialize();
			
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data:{
					action:	'basepress_new_product',
					form:	form,
				},

				success: function( response ){
					if( response.error ){
						console.log( response.data );
					}
					else{
						$( '#new-basepress-product' ).trigger( 'reset' );
						$( '#remove-image' ).click();
						$( '#products-table ul' ).append( response.data );
						//Refresh sortable items to include the new product
						$('#products-table ul').sortable( 'refresh' );
					}
				},

				error: function(  jqXHR, textStatus, errorThrown){
					console.log( errorThrown );
				},

				complete: function(){
					$( '#ajax-loader' ).hide();
				}
			});
		}
	});
	
	/*
	 *	Form validation function
	 */
	function isFormValid( form ){
		var title;
		if( form == 'add' ){
			title = $( '#product-name' );
		}
		else{
			title = $( '#product-name-edit' );
		}
		
		if( title.val() === '' ){
			title.parents( '.form-field' ).addClass( 'form-invalid' );
			return false;
		}
		else{
			title.parents( '.form-field' ).removeClass( 'form-invalid' );
			return true;
		}
	}
	
	/*
	 *	Delete Product
	 */
	
	$( '#products-table ul' ).on( 'click', '.product-actions .dashicons-trash', function(){
		var element = $( this );
		var productRow = element.parents( '.product-row' );
		var product = productRow.data( 'product' );
		var productName = productRow.data( 'productname' );
		var nonceString = productRow.data( 'nonce' );
		
		var confirmed = confirm( 'Are you sure you want to delete this product?' + productName );
		if( !confirmed ) return;
		
		$( '#ajax-loader' ).show();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data:{
				action:	'basepress_delete_product',
				product:	product,	
				nonce: 	nonceString,
			},
			success: function( response ){
				if( response === '1' ){
					productRow.fadeOut( 'normal', function(){
						$( this ).remove();
					});
				}
				else{
					
				}
			},
			
			complete: function(){
				$( '#ajax-loader' ).hide();
			}
		});
	});
	
	
	
	
	/*
	 *	Edit Product
	 */
	
	$( '#products-table ul' ).on( 'click', '.product-actions .dashicons-edit', function(){
		var element = $( this );
		var productRow = element.parents( '.product-row' );
		var product = productRow.data( 'product' );
		var nonceString = productRow.data( 'nonce' );
		
		$( '#edit-product-wrap' ).show();
		
		$( '#ajax-loader' ).show();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data:{
				action:	'basepress_get_product_data',
				product: product,	
				nonce: 	nonceString,
			},
			success: function( response ){
				var orientation = response.image.image_width < response.image.image_height ? 'vertical' : 'horizontal';
				$( '#product-id' ).attr( 'value', response.id );
				$( '#product-name-edit' ).val( response.name );
				$( '#product-slug-edit' ).val( response.slug );
				$( '#product-description-edit' ).val( response.description );
				$( '#edit-basepress-product img' )
					.attr( 'src', response.image.image_url )
					.removeClass()
					.addClass( orientation );
				if( response.image.image_url ){
					$( '#edit-basepress-product img' ).show();
				}
				$( '#product-image-url-edit' ).attr( 'value', response.image.image_url );
				$( '#product-image-width-edit' ).attr( 'value', response.image.image_width );
				$( '#product-image-height-edit' ).attr( 'value', response.image.image_height );
				var visibility = Number( response.visibility ) ? 'checked' : '';
				$( '#product-visibility' ).prop( 'checked', visibility );
				$( '#section-style-edit' ).val( response.sections_style.sections );
				$( '#subsection-style-edit' ).val( response.sections_style.sub_sections );
				if( response.restriction_roles ){
					$( '#basepress-edit-term-user-roles .basepress-restriction-role-list' ).html( response.restriction_roles );
				}
				$( '#default-category-edit a' ).attr( 'href', response.default_edit_link );
			},
			error: function( XMLHttpRequest, textStatus, errorThrown ){
				console.log( errorThrown );
			},
			complete: function(){
				$( '#ajax-loader' ).hide();
			}
		});
		
	});
	
	
	
	/*
	 *	Add product image on Edit form
	 */
	$( '#select-image-edit' ).click( function(){
		var frame;

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create a new media frame
		frame = new wp.media({
			multiple: false,
			library: { type: 'image' }
		});

		frame.open();

		frame.on( 'select', function(){
			var image = frame.state().get( 'selection' ).toJSON();
			var imageWidth = image[0].width;
			var imageHeight = image[0].height;
			var orientation = imageWidth < imageHeight ? 'vertical' : 'horizontal';
			$( '#edit-basepress-product img' )
				.attr( 'src', image[0].url )
				.removeClass()
				.addClass( orientation )
				.show();
			
			$( '#product-image-url-edit' ).attr( 'value', image[0].url );
			$( '#product-image-width-edit' ).attr( 'value', image[0].width );
			$( '#product-image-height-edit' ).attr( 'value', image[0].height );
		});
	});
	
	
	/*
	 *	Remove product image on Edit form
	 */
	$( '#remove-image-edit' ).click( function(){
		$( '#edit-basepress-product img' )
			.attr( 'src', '' )
			.removeClass()
			.hide();
		
		$( '#product-image-url-edit' ).attr( 'value', '' );
		$( '#product-image-width-edit' ).attr( 'value', '' );
		$( '#product-image-height-edit' ).attr( 'value', '' );
	});
	
	
	/*
	 *	Cancel Product Edit
	 */
	$( '#cancel-change' ).click( function( event ){
		event.preventDefault();
		$( '#edit-basepress-product' ).trigger( 'reset' );
		$( '#remove-image-edit' ).click();
		$( '#edit-basepress-product .form-invalid' ).removeClass( 'form-invalid' );
		$( '#edit-product-wrap' ).hide();
	});
	
	
	/*
	 *	Update Product Edit form
	 */
	$( '#save-change' ).click( function( event ){
		event.preventDefault();
		
		if( isFormValid( 'edit' ) ){
			$( '#ajax-loader' ).show();
			var form = $( '#edit-basepress-product' ).serialize();
			
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data:{
					action:	'basepress_update_product',
					form:	form
				},
				
				success: function( response ){
					if( response.error ){
						console.log( response.data );
					}
					else{
						var productRow = $( '#products-table li[data-product="' + response.id + '"]');
						productRow.find( '.product-image' ).css( 'background-image', 'url(' + response.image.image_url + ')' );
						productRow.find( '.product-name div' ).html( response.name);
						productRow.find( '.product-description div' ).html( response.description );
						productRow.find( '.product-slug div' ).html( response.slug );
						if( Number( response.visibility )){
							productRow.removeClass( 'invisible' );
						}
						else{
							productRow.addClass( 'invisible' );
						}
						$( '#cancel-change' ).click();
					}
				},
				
				error: function(  jqXHR, textStatus, errorThrown){
					console.log( errorThrown );
				},
				
				complete: function(){
					$( '#ajax-loader' ).hide();
				}
			});
		}
	});
	
	
	/*
	 *	Save Products Order
	 */
	$( '#save-product-order' ).click( function( event ){
		event.preventDefault();
		var elements = $( '#products-table li' );
		var nonceString = $( this ).data( 'nonce' );
		if( elements.length === 0 ) return;
		
		var order = [];
		elements.each( function( index, element ){
			order[ index ] = $( element ).data( 'product' );
		});
		
		$( '#ajax-loader' ).show();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data:{
				action:	'basepress_update_product_order',
				order: order,	
				nonce: 	nonceString,
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
				$( '#ajax-loader' ).hide();
			}
		});
	});

	/*
	 *	Make table items sortable
	 */
	$('#products-table ul').sortable({
		axis: 'y',
		delay: 150,
		helper: function(event, ui){
			var $clone =  $(ui).clone();
			$clone .css('position','absolute');
			return $clone.get(0);
		}
	});
	
	
	/*
	 * If we have a product id passed in the url we can edit it
	 */
	var editProduct = $( '#edit-basepress-product #product-id' ).val();
	if( editProduct ){
		var el = $( '#products-table ul li[data-product="' + editProduct + '"] .dashicons-edit' );
		el.click();
	}
}); //jQuery Closure

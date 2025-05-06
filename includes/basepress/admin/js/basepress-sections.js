jQuery( 'document' ).ready( function($){
	
	var form = '';
	var currentProduct = '';
	var currentSection = 0;
	var currentSectionName = '';
	var currentParent = '';
	
	/*
	 *	Load section table when a product is selected
	 */
	$( '#product-select' ).change( function(){
		currentProduct = $( this ).val();
		currentSection = 0;
		
		loadSections( currentProduct, currentSection );
		$( '#section-breadcrumb ul li').not( 'li:first' ).remove();
	});


	/*
	 * If there is a product already selected load the sections
	 * This is true if we are in single product mode
	 */
	if( $( '#product-select' ).find(":selected").val() != 0 ){
		$( '#product-select' ).change();
	}


	/*
	 *	Load Sub Sections on section's name click
	 */
	$( '#sections-table ul' ).on( 'click', '.section-name > div', function(){
		
		var selectedSection = $( this ).parents( 'li' );
		currentSection = selectedSection.data( 'section' );
		currentSectionName = selectedSection.data( 'name' );

		var breadcrumbs = $( '#section-breadcrumb ul li');
		if( breadcrumbs.length > 1 ){
			var sectionName = breadcrumbs.last().data( 'name' );
			breadcrumbs.last().html( '<a href="#">' + sectionName + '</a>' );
		}

		loadSections( currentProduct, currentSection );

		$( '#section-breadcrumb ul' ).append( '<li data-section="' + currentSection + '" data-name="' + currentSectionName + '">' + currentSectionName + '</li>' );
	});
	
	
	/*
	 *	Load Sections on breadcrumb click
	 */
	$( '#section-breadcrumb ul' ).on( 'click', 'li', function( event ){
		event.preventDefault();
		var selectedSection = $( this );
		var selectedSectionId = selectedSection.data( 'section' );

		if( selectedSectionId == currentSection ) return;

		currentSection = selectedSectionId;

		loadSections( currentProduct, currentSection );

		selectedSection.nextAll().remove();

		if( currentSection !== 0 ){
			currentSectionName = selectedSection.data( 'name' );
			selectedSection.html( currentSectionName );
		}
	});
		

	/*
	 * Load sections for the current selection
	 */
	function loadSections( product, section ){
		$( '#ajax-loader' ).show();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data:{
				action:	'basepress_get_section_list',
				product: product,
				section: section
			},
			
			success: function( response ){
				if( response.error ){
					console.log( response.data );
				}
				else{
					$( '#product-select' ).parent().removeClass( 'form-invalid' );
					$( '#sections-table ul' ).html( response.data );
					//Refresh sortable items to include the new section
					$('#sections-table ul').sortable( 'refresh' );
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
	
	
	/*
	 *	Add section image
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
			image = frame.state().get( 'selection' ).toJSON();
			var imageWidth = image[0].width;
			var imageHeight = image[0].height;
			var orientation = imageWidth < imageHeight ? 'vertical' : 'horizontal';
			$( '#new-basepress-section img' )
				.attr( 'src', image[0].url )
				.removeClass()
				.addClass( orientation )
				.show();
			
			$( '#section-image-url' ).attr( 'value', image[0].url );
			$( '#section-image-width' ).attr( 'value', image[0].width );
			$( '#section-image-height' ).attr( 'value', image[0].height );
		});
	});
	
	
	/*
	 *	Remove section image
	 */
	$( '#remove-image' ).click( function(){
		$( '#new-basepress-section img' )
			.attr( 'src', '' )
			.removeClass()
			.hide();
		
		$( '#section-image-url' ).attr( 'value', '' );
		$( '#section-image-width' ).attr( 'value', '' );
		$( '#section-image-height' ).attr( 'value', '' );
	});
	
	
	
	/*
	 *	Add section Icon
	 */
	
	//Open Icon Selector Panel
	$( '#select-icon' ).click( function(){
		//Stores witch form has requested an icon
		form = 'add-section';
		
		var selection = $( '#section-icon-class' ).attr( 'value' );
		if( selection ){
			$( '#icon-selector .basepress-icon[data-icon="' + selection +'"]' ).addClass( 'selected' );
		}
		$( '#icon-selector-wrap' ).show();
	});
	
	//Select Icon on Panel
	$( '.basepress-icon' ).click( function(){
		if( form != 'add-section' ) return;
		var iconClass = $( this ).data( 'icon' );
		$( '#icon-selector .basepress-icon.selected' ).removeClass( 'selected' );
		$( '#section-icon-class' ).attr( 'value', iconClass ).change();
		$( '#icon-selector-wrap' ).hide();
		form = '';
	});
	
	//Cancel Icon Selection
	$( '#cancel-icon-select' ).click( function(){
		$( '#icon-selector-wrap' ).hide();
	});
	
	//Update Icon
	$( '#section-icon-class' ).change( function(){
		var icon = $( this ).attr( 'value' );
		$( '#section-icon span' ).removeClass().addClass( icon );
	});
	
	//Remove section Icon
	$( '#remove-icon' ).click( function(){
		$( '#section-icon-class' ).attr( 'value', '' ).change();
	});
	
	
	/*
	 *	Add section
	 */
	$( '#add-section' ).click( function( event ){
		event.preventDefault();
		
		if( isFormValid( 'add' ) ){
			$( '#ajax-loader' ).show();
			
			var form = $( '#new-basepress-section' ).serialize();
			
			$.ajax({
					type: 'POST',
					url: ajaxurl,
					data:{
						action:	'basepress_new_section',
						product: currentProduct,
						section: currentSection,
						form:	form
					},
					
					
					success: function( response ){
						if( response.error ){
							console.log( response.data );
						}
						else{
							$( '#new-basepress-section' ).trigger( 'reset' );
							$( '#remove-icon' ).click();
							$( '#sections-table ul .section-row.notice' ).remove();
							$( '#sections-table ul' ).append( response.data );
							//Refresh sortable items to include the new section
							$('#sections-table ul').sortable( 'refresh' );
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
		var product = $( '#product-select' ).val();
		var title = '';
		
		
		if( form == 'add' ){
			if( !product ){
				$( '#product-select' ).parent().addClass( 'form-invalid' );
				$( '#product-select' ).get(0).scrollIntoView({block: "center", inline: "nearest"});
				alert( basepress_vars.missingProductNotice );
				return false;
			}
			title = $( '#section-name' );
		}
		else{
			title = $( '#section-name-edit' );
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
	 *	Delete Section
	 */
	$( '#sections-table ul' ).on( 'click', '.section-actions .dashicons-trash', function(){
		var element = $( this );
		var sectionRow = element.parents( '.section-row' );
		var section = sectionRow.data( 'section' );
		var sectionName = sectionRow.data( 'name' );
		var nonceString = sectionRow.data( 'nonce' );
		
		var confirmed = confirm( basepress_vars.confirmDelete + '\n\n' + sectionName );
		if( !confirmed ) return;
		
		$( '#ajax-loader' ).show();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data:{
				action:	'basepress_delete_section',
				section:	section,	
				nonce: 	nonceString,
			},
			success: function( response ){
				if( response === '1' ){
					sectionRow.fadeOut( 'normal', function(){
						$( this ).remove();
						var rows = $( '#sections-table ul li' );
						if( 0 == rows.length ){
							loadSections( currentProduct, currentSection );
						}
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
	 *	Edit Section form
	 */
	$( '#sections-table ul' ).on( 'click', '.section-actions .dashicons-edit', function(){
		var element = $( this );
		var sectionRow = element.parents( '.section-row' );
		var section = sectionRow.data( 'section' );
		var nonceString = sectionRow.data( 'nonce' );
		editSection( section, nonceString  );
	});
	
	function editSection( section, nonceString = '' ){
		
		$( '#edit-section-wrap' ).show();
		
		$( '#ajax-loader' ).show();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data:{
				action:	'basepress_get_section_data',
				section: section,	
				nonce: 	nonceString,
			},
			success: function( response ){
				var orientation = response.section.image.image_width < response.section.image.image_height ? 'vertical' : 'horizontal';
				$( '#section-id' ).attr( 'value', response.section.id );
				$( '#section-name-edit' ).val( response.section.name );
				$( '#section-slug-edit' ).val( response.section.slug );
				$( '#section-description-edit' ).val( response.section.description );
				$( '#section-icon-class-edit' ).attr( 'value', response.section.icon ).change();
				$( '#edit-basepress-section img' )
					.attr( 'src', response.section.image.image_url )
					.removeClass()
					.addClass( orientation );
				if( response.section.image.image_url ){
					$( '#edit-basepress-section img' ).show();
				}
				$( '#section-image-url-edit' ).attr( 'value', response.section.image.image_url );
				$( '#section-image-width-edit' ).attr( 'value', response.section.image.image_width );
				$( '#section-image-height-edit' ).attr( 'value', response.section.image.image_height );
				$( '#section-parent-edit' ).html( response.parents );
				$( '#default-category-edit a' ).attr( 'href', response.section.default_edit_link );
				currentParent = $( '#section-parent-edit select' ).val();
				if( response.section.restriction_roles ){
					$( '#basepress-edit-term-user-roles .basepress-restriction-role-list' ).html( response.section.restriction_roles );
				}
			},
			error: function( XMLHttpRequest, textStatus, errorThrown ){
				console.log( errorThrown );
			},
			complete: function(){
				$( '#ajax-loader' ).hide();
			}
		});

	}
	
	/*
	 *	Add section Icon on edit form
	 */
	
	//Open Icon Selector Panel
	$( '#select-icon-edit' ).click( function(){
		//Stores witch form has requested an icon
		form = 'edit-section';
		
		var selection = $( '#section-icon-class-edit' ).attr( 'value' );
		if( selection ){
			$( '#icon-selector .basepress-icon[data-icon="' + selection +'"]' ).addClass( 'selected' );
		}
		$( '#icon-selector-wrap' ).show();
	});
	
	//Select Icon on Panel
	$( '.basepress-icon' ).click( function(){
		if( form != 'edit-section' ) return;
		var iconClass = $( this ).data( 'icon' );
		$( '#icon-selector .basepress-icon.selected' ).removeClass( 'selected' );
		$( '#section-icon-class-edit' ).attr( 'value', iconClass ).change();
		$( '#icon-selector-wrap' ).hide();
		form = '';
	});
	
	//Cancel Icon Selection
	$( '#cancel-icon-select' ).click( function(){
		$( '#icon-selector-wrap' ).hide();
	});
	
	//Update Icon
	$( '#section-icon-class-edit' ).change( function(){
		var icon = $( this ).attr( 'value' );
		$( '#section-icon-edit span' ).removeClass().addClass( icon );
	});
	
	//Remove section Icon
	$( '#remove-icon-edit' ).click( function(){
		$( '#section-icon-class-edit' ).attr( 'value', '' ).change();
	});
	
	
	
	/*
	 *	Add section image on Edit form
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
			image = frame.state().get( 'selection' ).toJSON();
			var imageWidth = image[0].width;
			var imageHeight = image[0].height;
			var orientation = imageWidth < imageHeight ? 'vertical' : 'horizontal';
			$( '#edit-basepress-section img' )
				.attr( 'src', image[0].url )
				.removeClass()
				.addClass( orientation )
				.show();
			
			$( '#section-image-url-edit' ).attr( 'value', image[0].url );
			$( '#section-image-width-edit' ).attr( 'value', image[0].width );
			$( '#section-image-height-edit' ).attr( 'value', image[0].height );
		});
	});
	
	
	/*
	 *	Remove section image on Edit form
	 */
	$( '#remove-image-edit' ).click( function(){
		$( '#edit-basepress-section img' )
			.attr( 'src', '' )
			.removeClass()
			.hide();
		
		$( '#section-image-url-edit' ).attr( 'value', '' );
		$( '#section-image-width-edit' ).attr( 'value', '' );
		$( '#section-image-height-edit' ).attr( 'value', '' );
	});
	
	
	
	/*
	 *	Cancel Section Edit
	 */
	$( '#cancel-change' ).click( function( event ){
		event.preventDefault();
		$( '#edit-basepress-section' ).trigger( 'reset' );
		$( '#remove-icon-edit' ).click();
		$( '#edit-basepress-section .form-invalid' ).removeClass( 'form-invalid' );
		$( '#edit-section-wrap' ).hide();
	});
	
	
	/*
	 *	Update Section Edit form
	 */
	$( '#save-change' ).click( function( event ){
		event.preventDefault();
		
		if( isFormValid( 'edit' ) ){
			$( '#ajax-loader' ).show();
			var form = $( '#edit-basepress-section' ).serialize();
			
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data:{
					action:	'basepress_update_section',
					form:	form,	
				},
				
				
				success: function( response ){
					if( response.error ){
						console.log( response.data );
					}
					else{
						var newParent = $( '#section-parent-edit select' ).val();
						var sectionRow = $( '#sections-table li[data-section="' + response.id + '"]');
						if( newParent == currentParent ){
							sectionRow.find( '.section-icon > div span' ).removeClass().addClass( response.icon );
							sectionRow.find( '.section-image > div' ).css( 'background-image', 'url(' + response.image.image_url + ')' );
							sectionRow.find( '.section-name div' ).html( response.name);
							sectionRow.find( '.section-description div' ).html( response.description );
							sectionRow.find( '.section-slug div' ).html( response.slug );
						}
						else{
							sectionRow.remove();
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
	 *	Save Section Order
	 */
	$( '#save-section-order' ).click( function( event ){
		event.preventDefault();
		var elements = $( '#sections-table li' );
		var nonceString = $( this ).data( 'nonce' );
		if( elements.length === 0 ) return;
		
		var order = [];
		elements.each( function( index, element ){
			order[ index ] = $( element ).data( 'section' );
		});
		
		$( '#ajax-loader' ).show();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data:{
				action:	'basepress_update_section_order',
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
	$('#sections-table ul').sortable({
		axis: 'y',
		delay: 350,
		helper: function(event, ui){
			var $clone =  $(ui).clone();
			$clone .css('position','absolute');
			return $clone.get(0);
		}
	});
	
	/*
	 * If we have a product id passed in the url we can edit it
	 */
	var editSectionID = $( '#edit-basepress-section #section-id' ).val();
	var editSectionParentID = $( '#edit-basepress-section #parent-id' ).val();
	var editSectionProductID = $( '#edit-basepress-section #product-id' ).val();
	
	if( editSectionID ){
		currentProduct = editSectionProductID;
		currentSection = editSectionParentID;
		loadSections( currentProduct, currentSection );
		$( '#product-select' ).val( currentProduct );
		$( '#section-breadcrumb ul li').not( 'li:first' ).remove();
		if( editSectionParentID != editSectionProductID ){
			currentSectionName = $( '#edit-basepress-section #parent-name' ).val();
			$( '#section-breadcrumb ul').append( '<li data-section="' + currentSection + '">> ' + currentSectionName + '</li>' );
		}
		editSection( editSectionID );
	}
	
}); //jQuery Closure
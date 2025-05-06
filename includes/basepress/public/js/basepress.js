jQuery( document ).ready( function($){

	var basepressForms = [];

	function basepressSearch( element ){
		this.mainElement           = element;
		this.form                  = element.find( '.bpress-search-form' );
		this.searchField           = element.find( '.bpress-search-field' );
		this.searchNonce           = this.form.find( 'input[name="search-nonce"]' ).val()
		this.suggestions           = element.find( '.bpress-search-suggest' );
		this.product               = this.searchField.data( 'product' );
		this.deviceHeight          = Math.max( screen.height, screen.width );
		this.minDeviceHeight       = this.suggestions.data( 'minscreen' );
		this.suggestEnabled        = this.suggestions.length;
		this.skipSearchSuggestions = this.deviceHeight < this.minDeviceHeight;
		this.oldSearchInputValue   = '';
		this.min_chars             = parseInt( basepress_vars.min_chars );
		this.timer                 = null;
		this.selection             = -1;
		this.searchTerm            = '';
		this.language              = this.form.find( 'input[name="lang"]' ).val();
		this.foundPosts           = 0;

		/**
		 * If there is a search suggest element declare all functionalities
		 */
		if( this.suggestEnabled ){

			var _this = this;
			this.delay = function( callback, ms ){
				clearTimeout( this.timer );
				this.timer = setTimeout( callback, ms );
			};

			this.searchField.on( 'keyup', _this, function( e ){

				if( _this.skipSearchSuggestions ) return;

				e.preventDefault();

				switch( e.keyCode ){
					case 13: //Enter
					case 38: //Up
					case 40: //Down
					case 91: //Left window key
						return;
					case 27: //Esc
						_this.suggestions.hide();
						_this.selection = -1;
						_this.updateSelection();
						break;
					default:
						_this.searchTerm = $( this ).val();
						if( _this.searchTerm == _this.oldSearchInputValue ) return;
						_this.oldSearchInputValue = _this.searchTerm;

						if( _this.searchTerm && _this.searchTerm.length >= _this.min_chars ){
							_this.basepressGetSuggestions( _this.searchTerm, _this.product );
						}else{
							_this.suggestions.html( '' ).hide();
						}
				}
			} );

			/**
			 * Handles pasted text
			 */
			this.searchField.on( 'paste', _this, function(e){
				_this.searchTerm = e.originalEvent.clipboardData.getData('text');
				if( _this.searchTerm == _this.oldSearchInputValue ) return;
				_this.oldSearchInputValue = _this.searchTerm;
				if( _this.searchTerm && _this.searchTerm.length >= _this.min_chars ){
					_this.basepressGetSuggestions( _this.searchTerm, _this.product );
				}else{
					_this.suggestions.html( '' ).hide();
				}
			});

			/**
			 * Hide search results if clicked outside
			 */
			$( document ).on( 'mouseup', _this, function( e ){
				//Prevent search suggestions on touch devices
				if( _this.skipSearchSuggestions ) return;

				// if the target of the click isn't the container nor a descendant of the container
				if( ! _this.suggestions.is( e.target ) && _this.suggestions.has( e.target ).length === 0 ){
					_this.selection = -1;
					_this.updateSelection();
					_this.suggestions.hide();
				}
			} );

			/**
			 * Reopen search suggestions on click.
			 */
			this.searchField.on( 'click', _this, function( e ){
				//Prevent search suggestions on touch devices
				if( _this.skipSearchSuggestions ) return;

				_this.searchTerm = $( this ).val();
				if( _this.searchTerm && _this.searchTerm.length >= _this.min_chars && _this.suggestions.children().length ){
					_this.suggestions.show();
					return;
				}
				else if( _this.searchTerm && _this.searchTerm.length >= _this.min_chars && 0 == _this.suggestions.children().length ){
					_this.basepressGetSuggestions( _this.searchTerm, _this.product );
					return;
				}
				$( this ).keyup();
			} );


			/**
			 * Handle key interaction with search results
			 */
			this.mainElement.on( 'keydown', _this, function( e ){
				//Prevent search suggestions on touch devices
				if( _this.skipSearchSuggestions ) return;

				if( e.which != 38 && e.which != 40 && e.which != 13 ){
					return;
				}
				e.preventDefault();

				_this.lastItem = _this.suggestions.find( 'li' ).length - 1;
				switch( e.which ){
					case 38: //Up
						_this.selection = (_this.selection - 1) < -1 ? -1 : _this.selection -= 1;
						_this.updateSelection();
						break;

					case 40: //Down
						_this.selection = (_this.selection + 1) > _this.lastItem ? _this.lastItem : _this.selection += 1;
						_this.updateSelection();
						break;

					case 13: //Enter
						if( _this.selection != -1 ){
							_this.link = _this.suggestions.find( 'li' ).eq( _this.selection ).find( 'a' );
							_this.link[ 0 ].click();
							break;
						}
						_this.form.submit();
						break;
				}

			} );

			/**
			 *	Submit search form if suggest more is clicked
			 */
			this.suggestions.on( 'click', '.bpress-search-suggest-more span', _this, function( e ){
				_this.form.submit();
			} );
		}//End if

		/**
		 * Update selection on search suggestion
		 */
		this.updateSelection = function(){
			var els = this.suggestions.find( 'li' );
			els.removeClass( 'selected' );
			if( this.selection != -1 ){
				var currentSelection = els.eq( this.selection );
				currentSelection.addClass( 'selected' );
				let listContainer = this.suggestions.find('ul');
				listContainer.scrollTop( currentSelection[0].offsetTop - ( listContainer.height() / 2 ) );
			}
		}


		/**
		 * Get suggestions via Ajax
		 */
		this.basepressGetSuggestions = function( searchTerm, product ){

			this.form.addClass( 'searching' );
			let that = this;

			$.ajax( {
				type: 'GET',
				url: basepress_vars.ajax_url,
				data: {
					action: 'basepress_smart_search',
					terms: searchTerm,
					product: product,
					lang: that.language,
					nonce: that.searchNonce
				},
				success: function( response ){
					if( response.html ){
						that.suggestions.html( response.html ).show();
						that.foundPosts = Number( response.foundPosts );
					}else{
						that.suggestions.html( '' ).hide();
						that.foundPosts = 0;
					}
				},
				complete: function(){
					that.form.removeClass( 'searching' );
					if( basepress_vars.premium && basepress_vars.log_search ){
						that.delay( function(){
							that.logSearch( searchTerm, that.product, that.foundPosts );
						}, 1000 );
					}
				}
			} );
		}

		if( basepress_vars.premium ){
			this.logSearch = function( searchTerm, product ){
				var that = this;
				$.ajax( {
					type: 'GET',
					url: basepress_vars.ajax_url,
					data: {
						action: 'basepress_log_ajax_search',
						terms: searchTerm,
						product: product,
						found_posts: that.foundPosts
					},
					success: function( response ){

					},
					complete: function(){

					}
				} );
			}
		}
	}

	$('.bpress-search').each( function(i){
		basepressForms[i] = new basepressSearch( $(this) );
	});

	//Count post views
	if( basepress_vars.postID ){
		$.ajax( {
			type: 'POST',
			url: basepress_vars.ajax_url,
			data: {
				action: 'basepress_update_views',
				postID: basepress_vars.postID,
				productID: basepress_vars.productID,
			}
		});
	}

	/**
	 * Accordion Navigation
	 */
	$( '.bpress-nav-section' ).click( function( e ){
		if( 'A' != e.target.nodeName ){
			e.preventDefault();
			e.stopPropagation()
			var _this = $(this);
			var children = $(this).children('.children');
			var speed = children.children('li').length * 30;
			speed = speed < 150 ? 150 : speed;
			speed = speed > 750 ? 750 : speed;
			children.slideToggle( speed, function(){
				_this.toggleClass( 'open' );
			});
		}
	});

	//Prevent click event on articles to propagate to the parent section
	$( '.bpress-nav-article' ).click( function( e ){
		e.stopPropagation()
	});


	/**
	 * Hyperlink buttons
	 */
	$( '.bpress-copy-link').click( function( e ){
		let that = $(this);
		e.preventDefault();
		history.pushState({}, "", that.attr( 'href') );
		navigator.clipboard.writeText( new URL(window.location) );

		$( 'span.bpress-hl-tooltip').each( function(){
			$(this).text( $(this).data( 'bpress-copied-hl' ) );
		});
	} );

	$( '.bpress-copy-link').mouseenter( function( e ){
		let that = $(this);

		$( 'span.bpress-hl-tooltip').each( function(){
			$(this)
				.detach()
				.appendTo( that )
				.text( $(this).data( 'bpress-copy-hl' ) )
				.removeClass( 'hidden');
		});
	}).mouseleave( function( e ){
		$( 'span.bpress-hl-tooltip').addClass( 'hidden').text('');
	});


	/**
	 * Premium features
	 */
	if( basepress_vars.premium ){

		/**
		 * Activate vote buttons
		 */

		if( $( '.bpress-votes button' ).hasClass( 'enabled' ) ){
			$( '.bpress-votes' ).on( 'click', 'button', function( event ){
				event.preventDefault();
				var post = $( this ).data( 'post' );
				var vote = $( this ).data( 'vote' );
				var nonce = $( this ).data( 'nonce' );
				basepressUpdateVotes( post, vote, nonce );
				$( '.bpress-votes' ).off( 'click' );
				$( '.bpress-votes button' ).addClass( 'disabled' );
			} );
		}


		/**
		 * Update Votes on server
		 */
		function basepressUpdateVotes( post, vote, nonce ){
			showFeedbackForm( vote );

			$.ajax( {
				type: 'GET',
				dataType: 'json',
				url: basepress_vars.ajax_url,
				data: {
					action: 'basepress_update_votes',
					post: post,
					vote: vote,
					nonce: nonce,
				},
				success: function( response ){
					if( response ){
						setVotesCookie( post );
						updateVotingButtons( response );
						showConfirmation( response );
					}
				}
			} );
		}


		/**
		 * Update voting buttons to new values
		 */
		function updateVotingButtons( votes ){
			$( '.bpress-vote-like .bpress-vote' ).html( votes.like ).addClass( 'deactivated' );
			$( '.bpress-vote-dislike .bpress-vote' ).html( votes.dislike ).addClass( 'deactivated' );
		}

		/**
		 * Confirms vote submission
		 */
		function showConfirmation( votes ){
			if( votes.confirmation ){
				$( '.bpress-votes-confirm' ).html( votes.confirmation ).addClass( 'show' );
			}
		}


		/**
		 * Save voting cookie value
		 */
		function setVotesCookie( post ){
			var voted_ids = getVotes( 'basepress_votes' );

			if( voted_ids === '' ){
				voted_ids = [];
			}else{
				voted_ids = voted_ids.split( '|' );
			}

			if( !getVotes( post ) ){
				var date = new Date();
				date.setTime( date.getTime() + 30 * 24 * 3600 * 1000 );

				voted_ids.push( post );
				voted_ids = voted_ids.join( '|' );
				document.cookie = 'basepress_votes=' + voted_ids + '; path=/;expires = ';// + date.toGMTString();
			}

		}

		/**
		 * Get voting cookie value
		 */
		function getVotes( cname ){
			var name = cname + "=";
			var decodedCookie = decodeURIComponent( document.cookie );
			var ca = decodedCookie.split( ';' );
			for( var i = 0; i < ca.length; i++ ){
				var c = ca[ i ];
				while( c.charAt( 0 ) == ' ' ){
					c = c.substring( 1 );
				}
				if( c.indexOf( name ) === 0 ){
					return c.substring( name.length, c.length );
				}
			}
			return "";
		}


		/**
		 * FeedBacks
		 */

		function showFeedbackForm( vote ){
			var $showData = $( '.bpress-feedback' ).data( 'show' );
			if( $showData && ('like_dislike' == $showData || vote == $showData) ){
				$( '.bpress-feedback' ).removeClass( 'hidden' );
			}
		}

		$( '#bpress-feedback-form' ).submit( function( event, token ){
			event.preventDefault();

			if( $(this).find('bpress-submit-feedback').hasClass( 'grecaptcha-invisible' ) && ! token ){
				return;
			}
			if( $('#bpress-feedback-password').val() ){
				return;
			}
			submitFeedback( token );
		} );

		function submitFeedback( token ){
			var post = $( '.bpress-submit-feedback' ).data( 'post' );
			var feedback = $( '#bpress-feedback-message' ).val();
			var grecaptcha = token || $( '#g-recaptcha-response' ).val();
			var email = $('#bpress-feedback-email').val();
			var nonceString = $('#nonce').val();

			$( '.bpress-feedback-textarea textarea, .bpress-submit-feedback' ).attr( 'disabled', 'disabled' );
			$( '.bpress-feedback-textarea' ).addClass( 'sending' );
			$( '.bpress-feedback-confirm' ).html( '' ).removeClass( 'success fail' );

			$.ajax( {
				type: 'GET',
				dataType: 'json',
				url: basepress_vars.ajax_url,
				data: {
					action: 'basepress_submit_feedback',
					postID: post,
					feedback: feedback,
					grecaptcha: grecaptcha,
					email: email,
					nonce: nonceString,
				},
				success: function( response ){
					if( response ){
						$( '.bpress-feedback-confirm' ).html( response.message ).removeClass( 'success fail' ).addClass( response.state );
						if( 'success' == response.state ){
							$( '.bpress-feedback' ).remove();
						}
					}
				},
				complete: function(){
					$( '.bpress-feedback-textarea textarea, .bpress-submit-feedback' ).removeAttr( 'disabled' );
					$( '.bpress-feedback-textarea' ).removeClass( 'sending' );
				}
			} );
		}


		/**
		 * ToC ScrollSpy
		 */

		(function(){
			var running = false;

			function tocScrollSpy( element ) {
				this.tocAnchor        = $( '.bpress-anchor-link' );
				this.tocList          = element.find( '.bpress-toc-list li>a' );
				this.tocAnchorOffsets = [];
				this.offset           = 50;
				var _this             = this;

				this.tocAnchor.each( function( index, obj ){
					_this.tocAnchorOffsets.push( Math.round( $(obj).offset().top - _this.offset ) );
				} );

				this.setTocElement = function(){
					const match = _this.tocAnchorOffsets.reduce( function(a, b, index, offsets ){
						let windowScroll = window.scrollY;
						return ( windowScroll > a && windowScroll < b ) ? a : b;
					}, 0 );
					let dataCurrent = $(_this.tocAnchor[_this.tocAnchorOffsets.indexOf(match)]).data('index');
					$(_this.tocList).removeClass('active');
					$(_this.tocList).filter('[data-index="' + dataCurrent + '"]').addClass('active');
				}
			}

			$(window).on( 'scroll', function(e){
				if( !running ){
					window.requestAnimationFrame(function() {

						$('.widget_basepress_toc_widget, .bpress-toc').each( function(i){
							if( $(this).find('.bpress-toc-list[data-highlight="true"]').length ){
								new tocScrollSpy( $( this ) ).setTocElement();
							}
						});
						running = false;
					});

					running = true;
				}
			});
		}());
	}
});// End jQuery

if( basepress_vars.premium ){
	function basepressFeedbackEnableSubmit(){
		jQuery( '.bpress-submit-feedback').prop( 'disabled', false );
	}
	function basepressFeedbackDisableSubmit(){
		jQuery( '.bpress-submit-feedback').prop( 'disabled', true );
	}
	function basepressFeedbackOnSubmit( token ){
		jQuery( '.bpress-submit-feedback' ).trigger( 'click', token );
	}
}

( function( $ ) {

	var loadStatus = true;
	var count = 1;
	var loader = '';
	var total = 0;
	
	var PostsHandler = function( $scope, $ ) {
		
		var selector = $scope.find( '.blank-posts-grid' ),
			layout = $scope.find( '.blank-posts-grid' ).data( 'layout' ),
			$filters = $scope.find( '.blank-filters' ),
			$filter_1_tax = $filters.data( 'filter-1-tax' ),
			$filter_1 = '';
		
		loader = $scope.find( '.blank-posts-loader' );
		
		$scope.find( '.blank-filter-title' ).off( 'click' ).on( 'click', function() {
			$( this ).siblings('.blank-filter').toggle();
		});
		
		$scope.find( '.blank-filter-1 li' ).off( 'click' ).on( 'click', function() {
			var $filter_1 = $( this ).data('value');
			var $filter_1_text = $( this ).text();
			$scope.find( '.blank-filter' ).hide();
			
			$( this ).siblings().removeClass( 'blank-filter-current' );
			$( this ).addClass( 'blank-filter-current' );
			
			//var $filter_1_val = $filter_1;
			$('.blank-filter-1-wrap').find('.blank-filter-title').html($filter_1_text);
			/*if ( $filter_1_val == '*' ) {
				$filter_1_val = 'Any ' + $filter_1_tax;
			}*/
			
			//console.log($filter_2);
			
			//$( this ).parent().siblings( '.blank-selected-filter' ).attr('data-value', $filter_1);
			//$( this ).parent().html($filter_1_text);
			
			_postsFilterAjax( $scope, $filter_1_tax, $filter_1 );
		});
		
		/*$scope.find( '.blank-filter-2 li' ).off( 'click' ).on( 'click', function() {
			var $filter_2 = $( this ).data('value');
			var $filter_1 = $scope.find( '.blank-filter-1-wrap .blank-filter-current' ).data('value');
			$scope.find( '.blank-filter' ).hide();
			
			$( this ).siblings().removeClass( 'blank-filter-current' );
			$( this ).addClass( 'blank-filter-current' );
			
			var $filter_2_val = $filter_2;
			
			if ( $filter_2_val == '*' ) {
				$filter_2_val = 'Any ' + $filter_2_tax;
			}
			
			$( this ).parent().siblings( '.blank-selected-filter' ).html($filter_2_val);
			
			_postsFilterAjax( $scope, $filter_1_tax, $filter_1, $filter_2_tax, $filter_2 );
		});*/

		if ( selector.hasClass( 'blank-posts-infinite-scroll' ) ) {

			var windowHeight50 = jQuery( window ).outerHeight() / 1.25;

			$( window ).scroll( function () {

				if ( elementorFrontend.isEditMode() ) {
					loader.show();
					return false;
				}

				if ( ( $( window ).scrollTop() + windowHeight50 ) >= ( $scope.find( '.blank-post:last' ).offset().top ) ) {

					var $args = {
						'page_id':		$scope.find( '.blank-posts-grid' ).data('page'),
						'widget_id':	$scope.data( 'id' ),
						'filter':		$scope.find( '.blank-filter-current' ).data( 'filter' ),
						'skin':			$scope.find( '.blank-posts-grid' ).data( 'skin' ),
						'page_number':	$scope.find( '.blank-posts-pagination .current' ).next( 'a' ).html()
					};

					total = $scope.find( '.blank-posts-pagination-wrap' ).data( 'total' );

					if( true == loadStatus ) {

						if ( count < total ) {
							loader.show();
							_callAjax( $scope, $args, true );
							count++;
							loadStatus = false;
						}

					}
				}
			} );
		}
	}

	$( document ).on( 'click', '.blank-post-load-more', function( e ) {

		$scope = $( this ).closest( '.elementor-widget-blank-posts' );
		loader = $scope.find( '.blank-posts-loader' );

		e.preventDefault();

		if( elementorFrontend.isEditMode() ) {
			loader.show();
			return false;
		}

		var $args = {
			'page_id':		$scope.find( '.blank-posts-grid' ).data('page'),
			'widget_id':	$scope.data( 'id' ),
			'filter':		$scope.find( '.blank-filter-current' ).data( 'filter' ),
			'skin':			$scope.find( '.blank-posts-grid' ).data( 'skin' ),
			'page_number':	( count + 1 )
		};

		total = $scope.find( '.blank-posts-pagination-wrap' ).data( 'total' );

		if( true == loadStatus ) {

			if ( count < total ) {
				loader.show();
				$( this ).hide();
				_callAjax( $scope, $args, true );
				count++;
				loadStatus = false;
			}

		}
	} );

	$( 'body' ).delegate( '.blank-posts-pagination .page-numbers', 'click', function( e ) {

		$scope = $( this ).closest( '.elementor-widget-blank-posts' );

		e.preventDefault();

		$scope.find( '.blank-posts-grid .blank-post' ).last().after( '<div class="blank-post-loader"><div class="blank-loader"></div><div class="blank-loader-overlay"></div></div>' );

		var page_number = 1;
		var curr = parseInt( $scope.find( '.blank-posts-pagination .page-numbers.current' ).html() );

		if ( $( this ).hasClass( 'next' ) ) {
			page_number = curr + 1;
		} else if ( $( this ).hasClass( 'prev' ) ) {
			page_number = curr - 1;
		} else {
			page_number = $( this ).html();
		}

		$scope.find( '.blank-posts-grid .blank-post' ).last().after( '<div class="blank-post-loader"><div class="blank-loader"></div><div class="blank-loader-overlay"></div></div>' );

		var $args = {
			'page_id':		$scope.find( '.blank-posts-grid' ).data('page'),
			'widget_id':	$scope.data( 'id' ),
			'filter':		$scope.find( '.fn-filter__current' ).data( 'filter' ),
			'skin':			$scope.find( '.blank-posts-grid' ).data( 'skin' ),
			'page_number':	page_number
		};

		$('html, body').animate({
			scrollTop: ( ( $scope.find( '.blank-post-container' ).offset().top ) - 30 )
		}, 'slow');

		_callAjax( $scope, $args );

	} );

	var _postsFilterAjax = function( $scope, $filter_1_tax, $filter_1 ) {

		$scope.find( '.blank-posts-grid .blank-grid-item-wrap' ).last().after( '<div class="blank-posts-loader-wrap"><div class="blank-loader"></div><div class="blank-loader-overlay"></div></div>' );

		var $args = {
			'page_id':		$scope.find( '.blank-posts-grid' ).data('page'),
			'widget_id':	$scope.data( 'id' ),
			'filter_1_tax':	$filter_1_tax,
			'filter_1':		$filter_1,
			'page_number':	1
		};

		_callAjax( $scope, $args );
	}
    
    var _postsSearchAjax = function( $scope, $this ) {

		$scope.find( '.blank-posts-grid .blank-grid-item-wrap' ).last().after( '<div class="blank-posts-loader-wrap"><div class="blank-loader"></div><div class="blank-loader-overlay"></div></div>' );

		var $args = {
			'page_id':		$scope.find( '.blank-posts-grid' ).data('page'),
			'widget_id':	$scope.data( 'id' ),
			'page_number':	1
		};
        
		_callAjax( $scope, $args );
	}

	var _callAjax = function( $scope, $obj, $append ) {

		$.ajax({
			url: BlankElementsFrontendConfig.ajaxurl,
			data: {
				action:			'blank_get_post',
				page_id:		$obj.page_id,
				widget_id:		$obj.widget_id,
				filter_1_tax:	$obj.filter_1_tax,
				filter_1:		$obj.filter_1,
				page_number:	$obj.page_number
			},
			dataType: 'json',
			type: 'POST',
			success: function( data ) {

				//$scope.find( '.blank-posts-loader' ).remove();

				var sel = $scope.find( '.blank-posts-grid' );
				var posts_count = $scope.find( '.blank-posts-count' );
				
				//console.log(data.data.html);

				if ( true == $append ) {

					var html_str = data.data.html;
					//html_str = html_str.replace( 'blank-post-wrapper-featured', '' );
					sel.append( html_str );
				} else {
					sel.html( data.data.html );
					posts_count.html( data.data.blank_posts_count );
				}

				$scope.find( '.blank-posts-pagination-wrap' ).html( data.data.pagination );

				var layout = $scope.find( '.blank-posts-grid' ).data( 'layout' ),
					selector = $scope.find( '.blank-posts-grid' );

				if ( 'masonry' == layout ) {

					$scope.imagesLoaded( function() {
						selector.isotope( 'destroy' );
						selector.isotope({
							layoutMode: layout,
							itemSelector: '.blank-grid-item-wrap',
						});
					});
				}

				//	Complete the process 'loadStatus'
				loadStatus = true;
				if ( true == $append ) {
                    loader = $scope.find( '.blank-posts-loader' );
					loader.hide();
					$scope.find( '.blank-post-load-more' ).show();
				}

				if( count == total ) {
					$scope.find( '.blank-post-load-more' ).hide();
				}
			}
		});
	}

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/blank-posts.default', PostsHandler );

	});

} )( jQuery );
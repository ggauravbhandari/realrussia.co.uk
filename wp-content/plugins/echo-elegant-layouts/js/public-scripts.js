jQuery(document).ready(function($) {

	// Sidebar V1 ------------------------------------------------------------------------------------------------------/
	var sidebar = $('#elay-sidebar-layout-page-container');

	/********************************************************************
	 *
	 *                      SIDEBAR SETUP
	 *
	 ********************************************************************/

	{
		/**
		 * On page reload open all categories above the article
		 * Bold all those categories as well
		 */
		if ( $('#elay-sidebar-layout-page-container').length > 0 ) {
			elay_open_and_highlight_selected_article();
		}

		function elay_open_and_highlight_selected_article() {

			// active article id
			var id = $('.kb-article-id').attr('id');

			// true if we have article with multiple categories (locations) in the SBL; ignore old links
			if ( typeof $('.kb-article-id').data('kb_article_seq_no') !== 'undefined' && $('.kb-article-id').data('kb_article_seq_no') > 0 ) {
				var new_id = id + '_' + $('.kb-article-id').data('kb_article_seq_no');
				id = $('#sidebar_link_' + new_id).length > 0 ? new_id : id;
			}

			// after refresh highlight the Article link that is now active
			$('.sidebar-sections li').removeClass( 'active' );
			$('.elay-category-level-1').removeClass( 'active' );
			$('.elay-category-level-2-3').removeClass( 'active' );
			$('.elay_section_heading').removeClass( 'active' );
			$('#sidebar_link_' + id).addClass('active');

			// expand sub-categories if chosen article is hidden
			var list1 = $('#sidebar_link_' + id).closest('ul').parent();
			if (list1.length > 0) {
				list1.children('ul').show();
			}
			var list2 = list1.closest('li').closest('ul').parent();
			if (list2.length > 0) {
				list2.children('ul').show();
			}
			var list3 = list2.closest('li').closest('ul').parent();
			if (list3.length > 0) {
				list3.children('ul').show();
			}
			var list4 = list3.closest('li').closest('ul').parent();
			if (list4.length > 0) {
				list4.children('ul').show();
			}
			var list5 = list4.closest('li').closest('ul').parent();
			if (list5.length > 0) {
				list5.children('ul').show();
			}

			// highlight categories
			var level_a = $('#sidebar_link_' + id).closest('ul').closest('li');
			var icon1 = level_a.find('i').first();
			if (icon1.length > 0) {
				var match = icon1.attr('class').match(/\ep_font_icon_\S+/g);
				if ( match ) {
					elay_toggle_category_icons(icon1, match[0]);
				}
				
				level_a.find('div[class^=elay-category]').first().addClass( 'active' );
				// open the top category here
				level_a.find('.elay-section-body').css( 'display', 'block' );
				level_a.closest('.elay-section-body').css( 'display', 'block' );
			}
			var level_b = icon1.closest('ul').closest('ul').closest('li');
			var icon2 = level_b.find('i').first();
			if (icon2.length > 0) {
				var match = icon2.attr('class').match(/\ep_font_icon_\S+/g);
				if ( match ) {
					elay_toggle_category_icons(icon2, match[0]);
				}
				level_b.find('div[class^=elay-category]').first().addClass( 'active' );
			}
			var level_c = icon2.closest('ul').closest('ul').closest('li');
			var icon3 = level_c.find('i').first();
			if (icon3.length > 0) {
				var match = icon3.attr('class').match(/\ep_font_icon_\S+/g);
				if ( match ) {
					elay_toggle_category_icons(icon3, match[0]);
				}
				
				level_c.find('div[class^=elay-category]').first().addClass( 'active' );
			}
			
			var level_d = icon3.closest('ul').closest('ul').closest('li');
			var icon4 = level_d.find('i').first();
			if (icon4.length > 0) {
				var match = icon4.attr('class').match(/\ep_font_icon_\S+/g);
				if ( match ) {
					elay_toggle_category_icons(icon4, match[0]);
				}
				level_d.find('div[class^=elay-category]').first().addClass( 'active' );
			}
			
			var level_e = icon4.closest('ul').closest('ul').closest('li');
			var icon5 = level_e.find('i').first();
			if (icon5.length > 0) {
				var match = icon5.attr('class').match(/\ep_font_icon_\S+/g);
				if ( match ) {
					elay_toggle_category_icons(icon5, match[0]);
				}
				
				level_e.find('div[class^=elay-category]').first().addClass( 'active' );
			}

			// also show level 3 categories above level 2 article
			$('#sidebar_link_' + id).closest('ul').prev('.elay-sub-sub-category').css( 'display', 'block' );
		}

		/**
		 * 1. ICON TOGGLE for Top / Sub Category - toggle between open icon and close icon
		 */
		sidebar.on('click', '.sidebar-sections .elay-category-level-1, .sidebar-sections .elay-category-level-2-3', function () {
			var icon = $(this).find('span').eq(0);
			if ( icon.length > 0 ) {
				elay_toggle_category_icons(icon, icon.attr('class').match(/\ep_font_icon_\S+/g)[0]);
			}
		});

		function elay_toggle_category_icons( icon, icon_name ) {

			var icons_closed = [ 'ep_font_icon_plus', 'ep_font_icon_plus_box', 'ep_font_icon_right_arrow', 'ep_font_icon_arrow_carrot_right', 'ep_font_icon_arrow_carrot_right_circle', 'ep_font_icon_folder_add' ];
			var icons_opened = [ 'ep_font_icon_minus', 'ep_font_icon_minus_box', 'ep_font_icon_down_arrow', 'ep_font_icon_arrow_carrot_down', 'ep_font_icon_arrow_carrot_down_circle', 'ep_font_icon_folder_open' ];

			var index_closed = icons_closed.indexOf( icon_name );
			var index_opened = icons_opened.indexOf( icon_name );

			if ( index_closed >= 0 ) {
				icon.removeClass( icons_closed[index_closed] );
				icon.addClass( icons_opened[index_closed] );
			} else if ( index_opened >= 0 ) {
				icon.removeClass( icons_opened[index_opened] );
				icon.addClass( icons_closed[index_opened] );
			}
		}

		/**
		 *  2. SHOW ITEMS in TOP/SUB-CATEGORY
		 */
		// TOP-CATEGORIES: show or hide article in sliding motion
		sidebar.on('click', '.sidebar-sections .elay-top-class-collapse-on .elay-category-level-1', function () {
			$( this ).parent().toggleClass( 'elay-active-top-category' );
			$( this).parent().next().slideToggle();
		});
		// SUB-CATEGOREIS: show or hide article in sliding motion
		sidebar.on('click', '.sidebar-sections .elay-category-level-2-3', function () {
			
			// show lower level of categories and show articles in this category
			if ( $( this ).next().css('display') == 'none' ) { // prev state 
				$( this ).parent().children('ul').slideDown();
			} else {
				$( this ).parent().children('ul').slideUp();
			}
			
		});

		/**
		 * 3. SHOW ALL articles functionality
		 *
		 * When user clicks on the "Show all articles" it will toggle the "hide" class on all hidden articles
		 */
		sidebar.on('click', '.elay-show-all-articles', function () {

			$( this ).toggleClass( 'active' );
			var parent = $( this ).parent( 'ul' );
			var article = parent.find( 'li');

			//If this has class "active" then change the text to Hide extra articles
			if ( $(this).hasClass( 'active')) {

				//If Active
				$(this).find('.elay-show-text').addClass('elay-hide-elem');
				$(this).find('.elay-hide-text').removeClass('elay-hide-elem');

			} else {
				//If not Active
				$(this).find('.elay-show-text').removeClass('elay-hide-elem');
				$(this).find('.elay-hide-text').addClass('elay-hide-elem');
			}

			$( article ).each(function() {

				//If has class "hide" remove it and replace it with class "Visible"
				if ( $(this).hasClass( 'elay-hide-elem')) {
					$(this).removeClass('elay-hide-elem');
					$(this).addClass('visible');
				}else if ( $(this).hasClass( 'visible')) {
					$(this).removeClass('visible');
					$(this).addClass('elay-hide-elem');
				}
			});
		});
	}


	/********************************************************************
	 *
	 *                      HISTORY
	 *
	 ********************************************************************/

	// restore browsing history
	window.onpopstate = function(e) {

		if (e.state && e.state.html.indexOf('eckb-article-content') !== -1) {
			document.getElementById("eckb-article-page-container").innerHTML = e.state.html;
			document.title = e.state.pageTitle;
			// TODO remove $('.kb-article-id')
			var kb_article_id = ( typeof $('#eckb-article-content').data('article-id') !== 'undefined' ) ? $('#eckb-article-content').data('article-id') : $('.kb-article-id').attr('id');

			//Remove all Active stats first
			$( '.elay-sidebar').find( '.elay-sidebar-article').removeClass( 'active');
			//Add Class
			$('.elay-sidebar-article[data-kb-article-id="' + kb_article_id + '"]').addClass( 'active' );

			//Highlight the Article link that is now active
			elay_open_and_highlight_selected_article();
		}
	};

	(function() {

	//	var article_url = response.url.replace(/^http:/i, location.protocol);
	//	window.history.pushState({"article_id":article_id}, "", article_url);

/*
		var active_article_link = $('.elay-sidebar').find('[id^=sidebar_link][class=active]');
		if ( typeof active_article_link === 'undefined' ) {
			return;
		}
		var active_article_id =  active_article_link.find(">:first-child").data('kb-article-id');
		// TODO remove .kb-article-id
		var id =  ( typeof $('#eckb-article-content').data('article-id') !== 'undefined' ) ? $('#eckb-article-content').data('article-id') : $('.kb-article-id').attr('id');
		
		if ( active_article_id != id ) {
			active_article_link.trigger('click');
		} */
	})();

	// for now reload the whole page when changing article when clicking on sidebar
   /* $('[id^=sidebar_link]').off('click').on( 'click', function( e ) {
        e.stopPropagation();
        location.reload();
    });*/

	// handle AJAX switch article within SIDEBAR box (future - need to make shortcodes working)
	/* $('[id^=sidebar_link] .active').on( 'click', function( e ) {

		e.preventDefault();  // do not submit the form

		var article_id = $(this).find(">:first-child").data('kb-article-id');

		if ( typeof article_id === 'undefined' ) {
			return;
		}

		//noinspection JSUnresolvedVariable
		var postData = {
			action: 'elay_get_article',
			article_id: article_id
		};

		$.ajax({
			type: 'POST',
			dataType: 'json',
			data: postData,
			url: elay_vars.ajaxurl,
			beforeSend: function (xhr)
			{
				$('#eckb-article-page-container').html('Retrieving article...');
				$( '.loading-spinner').show();
			}

		}).done(function (response)
		{
			response = ( response ? response : '' );
			if ( ! response.error && typeof response.html !== 'undefined' && typeof response.url != 'undefined' && response.success )
			{
				$('#eckb-article-page-container').html(response.html);
				//FUTURE TODO: use article_id when loaded multiple articles at once to pass in which article was selected
				var article_url = response.url.replace(/^http:/i, location.protocol);
				window.history.pushState({"html":response.html, "pageTitle":document.title, "article_id":article_id}, "", article_url);

			} else {
				$('#eckb-article-page-container').html('Article is coming soon..');
				$("html, body").animate({scrollTop: 0}, "slow");
			}

			// highlight selected article
			elay_open_and_highlight_selected_article();

			$('.loading-spinner').hide();

		}).fail(function (response, textStatus, error)
		{
			$('#eckb-article-page-container').html('Could not find the article.');
			$( '.loading-spinner').hide();

		}).always(function ()
		{
			$("html, body").animate({scrollTop: 0}, "slow");
		});
	}); */


	/********************************************************************
	 *
	 *                      SEARCH
	 *
	 ********************************************************************/

	{

		//Sidebar Alpha Search Toggle
		$( '#elay-sidebar-layout-page-container' ).on( 'click', '.elay-search-toggle', function (){
			$( '.elay-doc-search-container').slideToggle();
			$('#elay_search_results').css( 'display','none' );

			//Chrome 77 fix rendering text issue Sidebar Layout
			let sidebar_search_text = $( '#sidebar-elay-search-kb' ).text();
			$( '#sidebar-elay-search-kb' ).text( sidebar_search_text );
		});

		// handle KB search form
		$( 'body' ).on( 'submit', '#elay_search_form', function( e ) {
			e.preventDefault();  // do not submit the form

			if ( $('#elay_search_terms').val() == '' ) {
				return;
			}

			var postData = {
				action: 'elay-search-kb',
				is_sidebar_layout: $('#sidebar-elay-search-kb').length > 0,
				elay_kb_id: $('#elay_kb_id').val(),
				search_words: $('#elay_search_terms').val()
			};

			var msg = '';

			$.ajax({
				type: 'GET',
				dataType: 'json',
				data: postData,
				url: elay_vars.ajaxurl,
				beforeSend: function (xhr)
				{
					//Loading Spinner
					$( '.loading-spinner').css( 'display','block');
					$('#elay-ajax-in-progress').show();
				}

			}).done(function (response)
			{
				response = ( response ? response : '' );

				//Hide Spinner
				$( '.loading-spinner').css( 'display','none');

				if ( response.error || response.status != 'success') {
					//noinspection JSUnresolvedVariable
					msg = elay_vars.msg_try_again;
				} else {
					msg = response.search_result;
				}

			}).fail(function (response, textStatus, error)
			{
				//noinspection JSUnresolvedVariable
				msg = elay_vars.msg_try_again + '. [' + ( error ? error : elay_vars.unknown_error ) + ']';

			}).always(function ()
			{
				// TODO NEXT RELEASE $spinner.css('display', 'none');
				$('#elay-ajax-in-progress').hide();

				if ( msg ) {
					$( '#elay_search_results' ).css( 'display','block' );
					$( '#elay_search_results' ).html( msg );
				}
			});
		});

		// cleanup search if search keywords deleted
		$("#elay_search_terms").on( 'keyup', function() {
			if ( ! this.value ) {
				$('#elay_search_results').css( 'display','none' );
			}
		});
	}

	
	/********************************************************************
	 *
	 *                      OTHER
	 *
	 ********************************************************************/

	//Set Scroll bar position to the active article if scrollbar is detected.
	if ( $( '.slim_scrollbar' ).length > 0 || $( '.default_scrollbar' ).length > 0 ) {

		//Detect if not on main page and article is active
        if ( $( '.elay-articles .active' ).length > 0 ) {
            var active_article_position = $( '.elay-articles .active' ).position();

            $( '.slim_scrollbar' ).scrollTop( active_article_position.top - 200 );
            $( '.default_scrollbar' ).scrollTop( active_article_position.top - 200 );
        }

	}

	//Mobile JS
	( function() {

		/**
		 * Since there is a delay in the JS loading on websites. We will hide all the KB html with CSS and show it with JS so that the JS loads and shows the KB
		 * and hides the weird jumping motion from the JS Mobile code.
		 */
		function show_hidden_sidebar_on_mobile(){
			if( $( '#elay-sidebar-layout-page-container' ).length > 0 ){
				$( '#elay-sidebar-layout-page-container' ).show();
			}
		}
		show_hidden_sidebar_on_mobile();


		// Grid Layout
		var width = $( '#elay-grid-layout-page-container' ).outerWidth();
		if ( width < 600 ) {
			$( '#elay-grid-layout-page-container' ).addClass( 'mobile-sidebar' )
		} else {
			$( '#elay-grid-layout-page-container' ).removeClass( 'mobile-sidebar' )
		}

		window.onresize = function() {
			var width = $( '#elay-grid-layout-page-container' ).outerWidth();
			if( width < 600 ){
				$( '#elay-grid-layout-page-container' ).addClass( 'mobile-sidebar' )
			}else {
				$( '#elay-grid-layout-page-container' ).removeClass( 'mobile-sidebar' )
			}

		};

		// Sidebar Layout
		width = $( '#elay-sidebar-layout-page-container' ).outerWidth();

		if ( width < 600 ) {
			$( '#elay-sidebar-layout-page-container' ).addClass( 'mobile-sidebar' )
		} else {
			$( '#elay-sidebar-layout-page-container' ).removeClass( 'mobile-sidebar' )
		}

		window.onresize = function() {
			var width = $( '#elay-sidebar-layout-page-container' ).outerWidth();
			if( width < 600 ){
				$( '#elay-sidebar-layout-page-container' ).addClass( 'mobile-sidebar' )
			}else {
				$( '#elay-sidebar-layout-page-container' ).removeClass( 'mobile-sidebar' )
			}
			show_hidden_sidebar_on_mobile();
		};
	})();


	//Chrome 77 fix rendering text issue Grid Layout
	let grid_search_text = $( '#grid-elay-search-kb' ).text();
	$( '#grid-elay-search-kb' ).text( grid_search_text );

 
	// Sidebar V2 ------------------------------------------------------------------------------------------------------/
	if( $( '#elay-sidebar-container-v2' ).length > 0 ){


		function elay_open_and_highlight_selected_article_v2() {
			// active article id
			// TODO remove .kb-article-id
			var id =  ( typeof $('#eckb-article-content').data('article-id') !== 'undefined' ) ? $('#eckb-article-content').data('article-id') : $('.kb-article-id').attr('id');
			
			// TODO remove .kb-article-id
			// true if we have article with multiple categories (locations) in the SBL; ignore old links
			var $el = typeof $('#eckb-article-content').data('kb_article_seq_no') !== 'undefined' ? $('#eckb-article-content') : $('.kb-article-id');
			
			if ( typeof $el.data('kb_article_seq_no') !== 'undefined' && $el.data('kb_article_seq_no') > 0 ) {
				
				var new_id = id + '_' + $el.data('kb_article_seq_no');
				
				id = $('#sidebar_link_' + new_id).length > 0 ? new_id : id;
			}
			
			// after refresh highlight the Article link that is now active
			$('.elay-sidebar__cat__top-cat li').removeClass( 'active' );
			$('.elay-category-level-1').removeClass( 'active' );
			$('.elay-category-level-2-3').removeClass( 'active' );
			$('.elay-sidebar__cat__top-cat__heading-container').removeClass( 'active' );
			$('#sidebar_link_' + id).addClass('active');
			
			// open all subcategories 
			$('#sidebar_link_' + id).parents('.elay-sub-sub-category, .elay-articles').each(function(){
				
				let $button = $(this).parent().children('.elay-category-level-2-3');
				if ( $button.length == 0 ) {
					return true;
				}
				
				if ( ! $button.hasClass('elay-category-level-2-3') ) {
					return true;
				}

				$button.next().show();
				$button.next().next().show();
				
				let icon = $button.find('.elay_sidebar_expand_category_icon');
				if ( icon.length > 0 ) {
					elay_toggle_category_icons(icon, icon.attr('class').match(/\ep_font_icon_\S+/g)[0]);
				}
			});
			
			// open main accordeon 
			$('#sidebar_link_' + id).closest('.elay-sidebar__cat__top-cat').parent().toggleClass( 'elay-active-top-category' );
			$('#sidebar_link_' + id).closest('.elay-sidebar__cat__top-cat').find( $( '.elay-sidebar__cat__top-cat__body-container') ).show();
			
			let icon = $('#sidebar_link_' + id).closest('.elay-sidebar__cat__top-cat').find('.elay-sidebar__cat__top-cat__heading-container .elay-sidebar__heading__inner span');
			if ( icon.length > 0 ) {
				elay_toggle_category_icons(icon, icon.attr('class').match(/\ep_font_icon_\S+/g)[0]);
			}
		}

		var sidebarV2 = $('#elay-sidebar-container-v2');

		// TOP-CATEGORIES -----------------------------------/
		// Show or hide article in sliding motion
		sidebarV2.on('click', '.elay-top-class-collapse-on', function (e) {
			
			// prevent open categories when click on editor tabs 
			if ( typeof e.originalEvent !== 'undefined' && ( $(e.originalEvent.target).hasClass('epkb-editor-zone__tab--active') || $(e.originalEvent.target).hasClass('epkb-editor-zone__tab--parent') ) ) {
				return;
			}
			
			$( this ).parent().toggleClass( 'elay-active-top-category' );
			$( this).parent().find( $( '.elay-sidebar__cat__top-cat__body-container') ).slideToggle();
		});
		
		// Icon toggle - toggle between open icon and close icon
		sidebarV2.on('click', '.elay-sidebar__cat__top-cat__heading-container', function (e) {
			
			// prevent open categories when click on editor tabs 
			if ( typeof e.originalEvent !== 'undefined' && ( $(e.originalEvent.target).hasClass('epkb-editor-zone__tab--active') || $(e.originalEvent.target).hasClass('epkb-editor-zone__tab--parent') ) ) {
				return;
			}
			
			var icon = $(this).find('.elay-sidebar__heading__inner span');
			if ( icon.length > 0 ) {
				elay_toggle_category_icons(icon, icon.attr('class').match(/\ep_font_icon_\S+/g)[0]);
			}
		});

		// SUB-CATEGORIES -----------------------------------/
		// Show or hide article in sliding motion
		sidebarV2.on('click', '.elay-category-level-2-3', function () {

			// show lower level of categories and show articles in this category
			$( this ).next().slideToggle();
			$( this ).next().next().slideToggle();

		});
		// Icon toggle - toggle between open icon and close icon
		sidebarV2.on('click', '.elay-category-level-2-3', function () {
			var icon = $(this).find('span');
			if ( icon.length > 0 ) {
				elay_toggle_category_icons(icon, icon.attr('class').match(/\ep_font_icon_\S+/g)[0]);
			}
		});

		// SHOW ALL articles functionality
		sidebarV2.on('click', '.elay-show-all-articles', function () {

			$( this ).toggleClass( 'active' );
			var parent = $( this ).parent( 'ul' );
			var article = parent.find( 'li');

			//If this has class "active" then change the text to Hide extra articles
			if ( $(this).hasClass( 'active') ) {

				//If Active
				$(this).find('.elay-show-text').addClass('elay-hide-elem');
				$(this).find('.elay-hide-text').removeClass('elay-hide-elem');

			} else {
				//If not Active
				$(this).find('.elay-show-text').removeClass('elay-hide-elem');
				$(this).find('.elay-hide-text').addClass('elay-hide-elem');
			}

			$( article ).each(function() {
				//If has class "hide" remove it and replace it with class "Visible"
				if ( $(this).hasClass( 'elay-hide-elem') ) {
					$(this).removeClass('elay-hide-elem');
					$(this).addClass('visible');
				} else if ( $(this).hasClass( 'visible')) {
					$(this).removeClass('visible');
					$(this).addClass('elay-hide-elem');
				}
			});
		});

		// restore browsing history
		window.onpopstate = function(e) {

			if (e.state && e.state.html.indexOf('eckb-article-content') !== -1) {
				document.getElementById("eckb-article-content-body").innerHTML = e.state.html;
				document.title = e.state.pageTitle;
				// TODO remove $('.kb-article-id')
				var kb_article_id = ( typeof $('#eckb-article-content').data('article-id') !== 'undefined' ) ? $('#eckb-article-content').data('article-id') : $('.kb-article-id').attr('id');
				
				//Remove all Active stats first
				$( '#elay-sidebar-container-v2').find( '.elay-sidebar-article').removeClass( 'active');
				//Add Class
				$('.elay-sidebar-article[data-kb-article-id="' + kb_article_id + '"]').addClass( 'active' );

				//Highlight the Article link that is now active
				elay_open_and_highlight_selected_article_v2();
			}
		};

		//Sidebar Search Toggle
		$('.elay-search-toggle').on('click', function (){
			$( '.elay-doc-search-container').slideToggle();
			$('#elay_search_results').css( 'display','none' );
		});

		elay_open_and_highlight_selected_article_v2();
	}
	
});

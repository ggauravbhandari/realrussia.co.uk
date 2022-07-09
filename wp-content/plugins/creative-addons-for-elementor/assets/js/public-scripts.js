jQuery(document).ready(function($) {

	/***********************************************************
	 *
	 *                       Search Widget
	 *
	 ***********************************************************/
	$( 'body' ).on( 'submit', '.crel-search-box__search-form', function( e ) {
		
		// Disable in admin 
		if ( $('.elementor-editor-active, .elementor-editor-preview').length ) {
			return false;
		}
		
		e.preventDefault();  // do not submit the form

		//Place Loading Spinner at the end of the Input box.
		let InputLength = $(this).find( '.crel-search-box__search-form__input' ).innerWidth();

		if ( $('[dir=rtl]').length ) {
			$( '.crel-loading-spinner' ).css('right', InputLength - 35 );	
		} else {
			$( '.crel-loading-spinner' ).css('left', InputLength - 35 );
		}


		let form = $(this).closest('.crel-search-box-container');
		
		if ( form.find('.crel-search-box__search-form__input').val() === '' ) {
			return;
		}
 
		let postData = {
			action: 'crel-search-kb',
			crel_kb_id: form.find('input[name=crel_kb_id]').val(),
			search_words: form.find('.crel-search-box__search-form__input').val(),
			crel_list_size: form.find('input[name=crel_list_size]').val()
		};

		let msg = '';

		$.ajax({
			type: 'GET',
			dataType: 'json',
			data: postData,
			url: form.find('input[name=crel_ajaxurl]').val(),
			beforeSend: function (xhr)
			{
				//Loading Spinner
				form.find( '.crel-loading-spinner').show();
			}

		}).done(function (response)
		{
			response = ( response ? response : '' );

			//Hide Spinner
			form.find( '.crel-loading-spinner').hide();
			msg = response.search_result;
			
			if ( response.error || response.status !== 'success') {
				
				form.find('.crel-sbsr__all-results, .crel-sbsr__help-text').hide();
				
			} else {
				form.find('.crel-sbsr__all-results, .crel-sbsr__help-text').show();
			}
			
			if ( response.error || ! response.show_more ) {
				form.find('.crel-sbsr__all-results').hide();
			} else {
				form.find('.crel-sbsr__all-results').show();
			}

		}).fail(function (response, textStatus, error)
		{
			//noinspection JSUnresolvedVariable
			msg = crel_vars.msg_try_again + '. [' + ( error ? error : crel_vars.unknown_error ) + ']';

		}).always(function ()
		{

			if ( msg ) {
				form.find( '.crel-search-box__search-results-container' ).show();
				form.find( '.crel-search-box__search-results__list-container' ).html( msg );
			}
		});
	});
	
	// Show More button
	$('body').on('click', '.crel-sbsr__all-results', function(){
		let form = $(this).closest('.crel-search-box-container');
		form.find('[name=crel_list_size]').val('-1');
		form.find('button').trigger( 'click' );
		
		return false;
	});

	$(document).on( 'click', function(e) {
		if ( $('.crel-search-box__search-results-container').css('display') !== 'none' ) {
			$('.crel-search-box__search-results-container').hide();
		}
	});
	
	
	/***********************************************************
	 *
	 *                       Image Guide Widget
	 *
	 ***********************************************************/
	
	// hightlight 
	$(document).on('click', '.crel-image-guide__container', function(){
		$(this).find('[data-index]').removeClass('crel-image-guide__spot--active');
	});
	
	$(document).on('click', '.crel-image-guide__container [data-index]', function(e){
		e.stopPropagation();
		
		let wrap = $(this).closest('.crel-image-guide__container');
		let i = $(this).data('index');
		
		wrap.find('[data-index]').removeClass('crel-image-guide__spot--active');
		wrap.find('[data-index=' + i + ']').addClass('crel-image-guide__spot--active');
	});
	
	$(document).on({
		mouseenter: function () {
			let wrap = $(this).closest('.crel-image-guide__container');
			let i = $(this).data('index');
			
			wrap.find('[data-index]').removeClass('crel-image-guide__spot--active');
			wrap.find('[data-index=' + i + ']').addClass('crel-image-guide__spot--active');
			$(this).removeClass('crel-image-guide__spot--active');
		},
		mouseleave: function () {
			if ( $(this).hasClass('crel-image-guide__spot--active') ) {
				return true; // user clicked on element, so keep hightlight 
			}
			
			$(document).find('.crel-image-guide__container [data-index]').removeClass('crel-image-guide__spot--active');
		}
	}, '.crel-image-guide__container [data-index]' ); 
	
	
});
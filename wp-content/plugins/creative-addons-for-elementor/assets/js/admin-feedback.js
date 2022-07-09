/* global jQuery */
(function ($) {
	'use strict';

	var CRELAdminDialogApp = {
		cacheElements: function cacheElements() {
			this.cache = {
				$deactivateLink: $('#the-list').find('[data-slug="creative-addons-for-elementor"] span.deactivate a'),
				$dialogHeader: $('#crel-deactivate-feedback-dialog-header'),
				$dialogForm: $('#crel-deactivate-feedback-dialog-form')
			};
		},
		bindEvents: function bindEvents() {
			var self = this;
			self.cache.$deactivateLink.on('click', function (event) {
				event.preventDefault();
				self.getModal().show();
			});
		},
		deactivate: function deactivate() {
			location.href = this.cache.$deactivateLink.attr('href');
		},
		initModal: function initModal() {
			var self = this,
				modal;

			self.getModal = function () {
				if (!modal) {
					var dialogsManager = new CRELDialogsManager.Instance();
					modal = dialogsManager.createWidget('lightbox', {
						id: 'crel-deactivate-feedback-modal',
						headerMessage: self.cache.$dialogHeader,
						classes: {
							globalPrefix: 'crel-dialog',
						},
						message: self.cache.$dialogForm,
						hide: {
							onButtonClick: false
						},
						position: {
							my: 'center',
							at: 'center'
						},
						onReady: function onReady() {

							CRELDialogsManager.getWidgetType('lightbox').prototype.onReady.apply(this, arguments);


							this.addButton({
								name: 'submit',
								text: 'Submit & Deactivate',
								callback: function callback() {

									if ( $('.crel-deactivate-feedback-dialog-input-wrapper input[name="reason_key"]:checked').length ) {
										jQuery('#crel-deactivate-feedback-dialog-form-error').hide();
										self.sendFeedback();
									}
									else {
										jQuery('#crel-deactivate-feedback-dialog-form-error').show();
									}
								}
							});

							this.addButton({
								name: 'skip',
								text: 'Skip & Deactivate',
								callback: function callback() {
									self.deactivate();
								}
							});

						},
						onShow: function onShow() {
							var $dialogModal = $('#crel-deactivate-feedback-modal'),
								radioSelector = '.crel-deactivate-feedback-dialog-input';
							$dialogModal.find(radioSelector).on('change', function () {
								$dialogModal.attr('data-feedback-selected', $(this).val());
							});
							$dialogModal.find(radioSelector + ':checked').trigger('change');
						}
					});
				}

				return modal;
			};
		},
		sendFeedback: function sendFeedback() {
			var self = this,
				formData = self.cache.$dialogForm.serialize();
			self.getModal().getElements('submit').text('').addClass('crel-loading');
			$.post(ajaxurl, formData, this.deactivate.bind(this));
		},
		init: function init() {
			this.initModal();
			this.cacheElements();
			this.bindEvents();
		}
	};
	$(function () {
		CRELAdminDialogApp.init();
	});
})(jQuery);
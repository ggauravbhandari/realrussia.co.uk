( function() {
	/* globals wp, frmAdminBuild, frmApiEmbedJs */

	const __ = wp.i18n.__;

	document.addEventListener( 'DOMContentLoaded', onContentLoaded );

	function onContentLoaded() {
		if ( 'undefined' === typeof frmAdminBuild || 'undefined' === typeof frmAdminBuild.hooks || 'function' !== typeof frmAdminBuild.hooks.addFilter ) {
			return;
		}

		if ( 'undefined' === typeof frmApiEmbedJs || 'string' !== typeof frmApiEmbedJs.protocol ) {
			return;
		}

		frmAdminBuild.hooks.addFilter( 'frmEmbedFormExamples', addApiEmbedExamples );
	};

	function addApiEmbedExamples( examples, args ) {
		const baseUrl = frmGlobal.url.split( '/wp-content/' )[0];
		const formId = args.formId;
		const formKey = args.formKey;
		examples.push(
			{
				label: __( 'API Form script', 'formidable' ),
				example: '<script src="' + baseUrl + frmApiEmbedJs.protocol + formKey + '"></script>'
			},
			{
				label: __( 'API Form shortcode', 'formidable' ),
				example: '[frm-api type="form" id=' + formId + ' url="' + baseUrl + '"]'
			}
		);
		return examples;
	}
}() );

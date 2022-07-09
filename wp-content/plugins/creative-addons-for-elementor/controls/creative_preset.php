<?php
namespace Creative_Addons\Controls;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Init class for widgets including all checks
 */
class Creative_Preset extends \Elementor\Control_Select {
	
	const TYPE = 'creative_preset';
	
	public function get_type() {
		return 'creative_preset';
	}
	
	/**
	 * Render select control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {

		$control_uid = $this->get_control_uid();		?>
 
		<div class="elementor-control-field {{{ data.reset ? 'crel-with-reset' : '' }}} {{{ ( data.select_class ) ? data.select_class : '' }}}">
			<# if ( data.label ) {#>
				<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<# if ( data.reset ) {#>
					<i title="<?php _e( 'Reset Style', 'creative-addons-for-elementor' ); ?>" class="eicon-redo crel-reset-design" aria-hidden="true"></i>
				<# } #>
				<select id="<?php echo $control_uid; ?>" data-setting="{{ data.name }}">
				<#
					var printOptions = function( options ) {
						_.each( options, function( option_data, option_value ) {	
							
							let colors = '';
							if ( typeof option_data.colors !== 'undefined' ) {
								colors = JSON.stringify( option_data.colors );
							}
						#>
								<option value="{{ option_value }}" data-value='{{{ option_data.options }}}' data-colors='{{{colors}}}'>{{{ option_data.title }}}</option>
						<# } );
					};

					if ( data.groups ) {
						for ( var groupIndex in data.groups ) {
							var groupArgs = data.groups[ groupIndex ];
								if ( groupArgs.options ) { #>
									<optgroup label="{{ groupArgs.label }}">
										<# printOptions( groupArgs.options ) #>
									</optgroup>
								<# } else if ( _.isString( groupArgs ) ) { #>
									<option value="{{ groupIndex }}">{{{ groupArgs }}}</option>
								<# }
						}
					} else {
						printOptions( data.options );
					}
				#>
				</select>
			</div>
		</div>

		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>		<?php
	}
	
	/**
	 * Register scripts for this select type 
	 */
	public function enqueue() {
		
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_style( 'creative_preset', CREATIVE_ADDONS_ASSETS_URL . 'css/admin/admin' . $suffix . '.css' );
		wp_enqueue_script( 'creative_preset', CREATIVE_ADDONS_ASSETS_URL . 'js/creative_preset' . $suffix . '.js', array( 'jquery' ), '', true );
		
		wp_localize_script( 'creative_preset', 'creative_preset_vars', array(
								'reset_style'         => esc_html__( 'Reset Style', 'creative-addons-for-elementor' )
		));
		
	}
}

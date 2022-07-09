<?php
namespace Creative_Addons\Includes;


defined( 'ABSPATH' ) || exit();

/**
 * Elements of form UI and others
 *
 * @copyright   Copyright (C) 2019, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class HTML_Elements {

	// Form Elements------------------------------------------------------------------------------------------/
	private function add_defaults( array $input_array, array $custom_defaults=array() ) {

		$defaults = array(
			'id'                => '',
			'name'              => 'text',
			'value'             => '',
			'label'             => '',
			'title'             => '',
			'class'             => '',
			'main_label_class'  => '',
			'label_class'       => '',
			'input_class'       => '',
			'input_group_class' => '',
			'action_class'      => '',
			'desc'              => '',
			'info'              => '',
			'placeholder'       => '',
			'readonly'          => false,  // will not be submitted
			'required'          => '',
			'autocomplete'      => false,
			'data'              => false,
			'disabled'          => false,
			'size'              => 3,
			'max'               => 50,
			'current'           => null,
			'options'           => array(),
			'label_wrapper'     => '',
			'input_wrapper'     => '',
			'return_html'       => false,
			'unique'            => true,
			'radio_class'       => ''
		);
		$defaults = array_merge( $defaults, $custom_defaults );
		return array_merge( $defaults, $input_array );
	}
	/**
	 * HTML Notification box with Title and Body text.
	 * Copied HTML / CSS from CREL Plugin
	 * @param array $args
	 * $values:
	 * string $value['id']            ( Optional ) Container ID, used for targeting with other JS
	 * string $value['type']          ( Required ) ( error, success, warning, info )
	 * string $value['title']         ( Required ) The big Bold Main text
	 * HTML   $value['desc']          ( Required ) Any HTML P, List etc...
	 */
	public function notification_box_basic( $args = array() ) {

		$icon = '';
		switch ( $args['type']) {
			case 'error':   $icon = 'crelfa-exclamation-triangle';
				break;
			case 'success': $icon = 'crelfa-check-circle';
				break;
			case 'warning': $icon = 'crelfa-exclamation-circle';
				break;
			case 'info':    $icon = 'crelfa-info-circle';
				break;

		}		?>

		<div <?php echo isset($args['id']) ? 'id="'.$args['id'].'"' : ''; ?>class="crel-notification-box-basic <?php echo 'crel-notification-box-basic--'.$args['type']; ?>">

			<div class="crel-notification-box-basic__icon">
				<div class="crel-notification-box-basic__icon__inner crelfa <?php echo $icon; ?>"></div>
			</div>

			<div class="crel-notification-box-basic__body">
				<h4 class="crel-notification-box-basic__body__title"><?php echo $args['title']; ?></h4>
				<div class="crel-notification-box-basic__body__desc"><?php echo $args['desc']; ?></div>
			</div>

		</div>    <?php
	}

	/*
		HTML Advertisement Box
		This box will have a title, image, either a description or list a button and more info link.
		$values:
	    @param: string $args['id']              ( Optional ) Container ID, used for targeting with other JS
	    @param: string $args['class']           ( Optional ) Container CSS, used for targeting with CSS
	    @param: string $args['icon']            ( Optional ) Icon to display ( from this list: https://fontawesome.com/v4.7.0/icons/ )
	    @param: string $args['title']           ( Required ) The text title
	    @param: string $args['img_url']         ( Required ) URL of image.
	    @param: string $args['desc']            ( Optional ) Paragraph Text
	    @param: array  $args['list']            ( Optional ) array() of list items.

	    @param: string $args['btn_text']        ( Optional ) Button Text
	    @param: string $args['btn_url']         ( Optional ) Button URL
	    @param: string $args['btn_color']       ( Required ) blue,yellow,orange,red,green

		@param: string $args['more_info_text']  ( Optional ) More Info Text
	    @param: string $args['more_info_url']   ( Optional ) More Info URL
	    @param: string $args['more_info_color'] ( Required ) blue,yellow,orange,red,green
	 */
	public function advertisement_ad_box( $args ) {

		$args = $this->add_defaults( $args );		?>

		<div id="<?php echo $args['id']; ?>" class="crel-admin-ad-container <?php echo $args['class']; ?>">

			<!----- Box Type ----->
			<span class="crel-admin-ad-container__widget"> <i class="crelfa crelfa-puzzle-piece " aria-hidden="true"></i><?php echo __( 'Plugin', 'creative-addons-for-elementor'); ?></span>

			<!----- Header ----->
			<div class="crel-aa__header-container">
				<div class="crel-header__icon crelfa <?php echo $args['icon']; ?>"></div>
				<div class="crel-header__title"><?php echo $args['title']; ?></div>
			</div>

			<!----- Body ---=--->
			<div class="crel-aa__body-container">
				<div class="featured_img">
					<img class="crel-body__img" src="<?php echo $args['img_url']; ?>" alt="<?php echo $args['title']; ?>">
				</div>
				<p class="crel-body__desc"><?php echo $args['desc']; ?></p>

				<ul class="crel-body__check-mark-list-container">					<?php
					if ( $args['list'] ) {
						foreach ($args['list'] as $item) {
							echo '<li class="crel-check-mark-list__item">';
							echo '<span class="crel-check-mark-list__item__icon crelfa crelfa-check"></span>';
							echo '<span class="crel-check-mark-list__item__text">' . $item . '</span>';
							echo '</li>';
						}
					}					?>
				</ul>

				<?php if ( $args['btn_text'] ) { ?>
					<a href="<?php echo $args['btn_url']; ?>" target="_blank" class="crel-body__btn crel-body__btn--<?php echo $args['btn_color']; ?>"><?php echo $args['btn_text']; ?></a>
				<?php } ?>

				<?php if ( !empty( $args['more_info_text'] ) ) { ?>
					<a href="<?php echo $args['more_info_url']; ?>" target="_blank" class="crel-body__link crel-body__link--<?php echo $args['more_info_color']; ?>">
						<span class="crel-body__link__icon crelfa crelfa-info-circle"></span>
						<span class="crel-body__link__text"><?php echo $args['more_info_text']; ?></span>
						<span class="crel-body__link__icon-after crelfa crelfa-angle-double-right"></span>

					</a>
				<?php } ?>

			</div>

		</div>	<?php
	}
}

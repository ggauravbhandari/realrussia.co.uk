<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Frontend Editor configuration data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ELAY_KB_Editor_Sidebar_Config {

	// Frontend Editor Tabs
	const EDITOR_TAB_CONTENT = 'content';
	const EDITOR_TAB_STYLE = 'style';
	const EDITOR_TAB_FEATURES = 'features';
	const EDITOR_TAB_ADVANCED = 'advanced';

	const EDITOR_GROUP_DIMENSIONS = 'dimensions';

	/**
	 * Sidebar Content zone
	 *
	 * @return array
	 */
	private static function elay_sidebar_content_zone() {

		$settings = [];

		$settings += [
			'intro_header'           => [
					'editor_tab' => self::EDITOR_TAB_FEATURES,
					'type' => 'header',
					'content' => __( 'Intro Text', 'echo-knowledge-base' ),
			],
			'intro_link'           => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'type' => 'raw_html',
				'content' => '<a href="' . admin_url('edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration#settings__various') . '" target="_blank">' . __( 'Edit Intro Text', 'echo-knowledge-base' ) . '</a>'
			],
		];

		return [
			'sidebar_content_zone' => [
				'title'     =>  __( 'Introduction', 'echo-knowledge-base' ),
				'classes'   => '#eckb-article-content',
				'settings'  => $settings
			]];
	}

	/**
	 * Sidebar Content zone
	 *
	 * @param $kb_config
	 * @return array
	 */
	private static function elay_sidebar_navigation_zone( $kb_config ) {

		$options = array(
			'0' => __( 'Not displayed', 'echo-knowledge-base' ),
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5'
		);
		$options2 = array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5'
		);

		$settings = [

			// Content Tab
			'sidebar_category_empty_msg'            => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.elay-articles-coming-soon',
				'text' => '1'
			],

			// Style Tab
			'sidebar_section_category_heading'  => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Category Name', 'echo-knowledge-base' ),
			],
			'sidebar_section_category_typography'           => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay_section_heading,
							#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container .elay-sidebar__heading__inner__cat-name',
			],

			'sidebar_section_head_font_color'               => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => 'elay-sidebar-template .elay-category-level-1, 
							.elay-sidebar-template .elay-category-level-1 a, 
							#elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name, 
							#elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name>a',
				'style_name' => 'color'
			],
			'sidebar_section_head_background_color'         => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay_section_heading,
							#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
				'style_name' => 'background-color'
			],
			'sidebar_section_category_description_heading'  => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'type' => 'header',
				'content' => __( 'Category Description', 'echo-knowledge-base' ),
			],
			'sidebar_section_category_typography_desc'           => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay_section_heading,
							#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container .elay-sidebar__heading__inner__desc p',
			],
			'sidebar_section_subcategory_typography'        => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay-category-level-2-3__cat-name,
							#elay-sidebar-container-v2 .elay-category-level-2-3__cat-name h3',
			],
			'sidebar_section_head_description_font_color'   => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay_section_heading p, #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__desc p',
				'style_name' => 'color',
			],
			'sidebar_background_color'          => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay-sidebar, #elay-sidebar-container-v2',
				'style_name' => 'background-color',
				'separator_above' => 'yes'
			],
			'sidebar_section_border_color'      => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay-sidebar,#elay-sidebar-container-v2',
				'style_name' => 'border-color'
			],
			'sidebar_section_category_icon_color'           => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 i, #elay-sidebar-container-v2 .elay_sidebar_expand_category_icon',
				'style_name' => 'color',
				'separator_above' => 'yes'
			],
			'sidebar_section_category_font_color'           => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '.elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 a, #elay-sidebar-container-v2 .elay-category-level-2-3 a',
				'style_name' => 'color'
			],

			// Features Tab
			'elay_sidebar_heading'  => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'type' => 'header',
				'content' => __( 'Navigation', 'echo-knowledge-base' ),
			],
			'elay_sidebar_left' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'label'      => __( 'Navigation Location', 'echo-knowledge-base' ),
				'type'        => ELAY_Input_Filter::SELECTION,
				'style'       => 'small',
				'options'    => ( $kb_config['kb_main_page_layout'] == 'Sidebar' ? $options2 : $options ),
				'default'     => '1',
				'reload' => '1'
			],

			'sidebar_section_box_shadow' 		=> [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'sidebar_side_bar_height'           => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'sidebar_side_bar_height_mode'      => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1
			],
			'sidebar_scroll_bar'                => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'elay_sidebar_category_heading'  => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'type' => 'header',
				'content' => __( 'Categories', 'echo-knowledge-base' ),
			],
			'sidebar_section_head_alignment'                => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'style'       => 'small',
				'reload' => 1
			],
			'sidebar_section_desc_text_on'          => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'sidebar_top_categories_collapsed'      => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1
			],
			'sidebar_expand_articles_icon'                  => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1
			],
			'sidebar_section_divider_heading'  => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'type' => 'header',
				'content' => __( 'Article List Divider', 'echo-knowledge-base' ),
			],
			'sidebar_section_divider'                       => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
			],
			'sidebar_section_divider_color'                 => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'target_selector' => '.elay-sidebar-template .elay_section_heading, #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
				'style_name' => 'border-bottom-color',
				'toggler' => 'sidebar_section_divider',
			],
			'sidebar_section_divider_thickness'             => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'target_selector' => '#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
				'style_name' => 'border-bottom-width',
				'postfix' => 'px',
				'toggler' => 'sidebar_section_divider',

			],

			// Advanced Tab
			'sidebar_section_padding_group' => [
				'editor_tab' => self::EDITOR_TAB_ADVANCED,
				'group_type' => self::EDITOR_GROUP_DIMENSIONS,
				'label' => __( 'Padding', 'echo-knowledge-base' ),
				'units' => 'px',
				'subfields' => [
					'sidebar_section_head_padding_left' => [
						'style_name' => 'padding-left',
						'postfix' => 'px',
						'target_selector' => '#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
					],
					'sidebar_section_head_padding_top' => [
						'style_name' => 'padding-top',
						'postfix' => 'px',
						'target_selector' => '#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
					],
					'sidebar_section_head_padding_right' => [
						'style_name' => 'padding-right',
						'postfix' => 'px',
						'target_selector' => '#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
					],
					'sidebar_section_head_padding_bottom' => [
						'style_name' => 'padding-bottom',
						'postfix' => 'px',
						'target_selector' => '#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
					],
				]
			],
		];

		return [
			'elay_sidebar_navigation_zone' => [
				'title'     =>  __( 'Navigation', 'echo-knowledge-base' ),
				'classes'   => '#elay-sidebar-container-v2',
				'parent_zone_tab_title' => __( 'Navigation', 'echo-knowledge-base' ),
				'disabled_settings' => [
					'elay_sidebar_left' => '0'
				],
				'settings'  => $settings
			]];
	}

	/**
	 * Articles zone
	 * @return array
	 */
	private static function elay_sidebar_articles_zone() {

		$settings = [

			// Content Tab
			'sidebar_collapse_articles_msg'             => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.elay-show-all-articles .elay-hide-text',
				'text' => '1'
			],
			'sidebar_show_all_articles_msg'             => [
				'editor_tab' => self::EDITOR_TAB_CONTENT,
				'target_selector' => '.elay-show-all-articles .elay-show-text span',
				'text' => '1'
			],

			// Style Tab
			'sidebar_section_body_typography'           => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '#elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__body-container',
			],
			'sidebar_article_icon_color'                => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '#elay-sidebar-container-v2 .elay-article-title .ep_font_icon_document',
				'style_name' => 'color'
			],
			'sidebar_article_font_color'                => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '#elay-sidebar-container-v2 .elay-article-title',
				'style_name' => 'color'
			],
			'sidebar_article_active_font_color'         => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '#elay-sidebar-container-v2 .active .elay-article-title',
				'style_name' => 'color',
			],
			'sidebar_article_active_background_color'   => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'target_selector' => '#elay-sidebar-container-v2 .active',
				'style_name' => 'background-color',
			],

			// Features Tab
			'sidebar_nof_articles_displayed'    => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1
			],

			'sidebar_article_list_margin'    => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'reload' => 1,
				'style'       => 'small',
			],

			// Advanced Tab

		];

		return [
			'sidebar_articles_zone' => [
				'title'     =>  __( 'Articles', 'echo-knowledge-base' ),
				'classes'   => '.elay-articles',
				'settings'  => $settings
			]];
	}

	/**
	 * Retrieve Editor configuration
	 * @param $page_type
	 * @return array
	 */
	public static function get_config( $page_type, $kb_config ) {

		$editor_config = [];

		if ( $page_type == 'main-page' ) {
			$editor_config += self::elay_sidebar_content_zone();
		}

		$editor_config += self::elay_sidebar_navigation_zone($kb_config);
		$editor_config += self::elay_sidebar_articles_zone();

		return $editor_config;
	}
}
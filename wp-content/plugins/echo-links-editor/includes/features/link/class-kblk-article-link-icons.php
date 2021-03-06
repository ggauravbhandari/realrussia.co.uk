<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store common and other icons
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class KBLK_Article_Link_Icons {

	public static function get_common_icons() {
		$common_kb_icons = array(
			'file-pdf-o'            => 'file-pdf-o',
			'file-text-o'           => 'file-text-o',
			'file-word-o'           => 'file-word-o',
			'file-excel-o'          => 'file-excel-o',

			'file-image-o'          => 'file-image-o',
			'file-zip-o'            => 'file-zip-o',
			'file-audio-o'          => 'file-audio-o',
			'file-video-o'          => 'file-video-o',

			'link'                  => 'link',
			'youtube-play'          => 'youtube-play',
			'download'              => 'download',
			'external-link'         => 'external-link',

			'file-code-o'           => 'file-code-o',
			'file-o'                => 'file-o',
			'Files O'               => 'files-o',
			'folder-open'           => 'folder-open',

		);

		return $common_kb_icons;
	}

	public static function get_other_icons() {

		$other_icons = array(
			'code'                  => 'code',
			'Clipboard'             => 'clipboard',
			'book'                  => 'book',
			'info-circle'           => 'info-circle',
			'question-circle'       => 'question-circle',
			'exclamation-circle'    => 'exclamation-circle',
			'database'              => 'database',
			'file-powerpoint-o'     => 'file-powerpoint-o',
			'image'                 => 'image',
			'lock'                  => 'lock',
			'print'                 => 'print',
			'user'                  => 'user',
			'glass'                 => 'glass',
			'music'                 => 'music',
			'search'                => 'search',
			'envelope-o'            => 'envelope-o',
			'heart'                 => 'heart',
			'star'                  => 'star',
			'star-o'                => 'star-o',
			'film'                  => 'film',
			'th-large'              => 'th-large',
			'th'                    => 'th',
			'th-list'               => 'th-list',
			'check'                 => 'check',
			'close'                 => 'close',
			'search-plus'           => 'search-plus',
			'search-minus'          => 'search-minus',
			'power-off'             => 'power-off',
			'signal'                => 'signal',
			'gear'                  => 'gear',
			'trash-o'               => 'trash-o',
			'home'                  => 'home',
			'clock-o'               => 'clock-o',
			'road'                  => 'road',
			'arrow-circle-o-down'   => 'arrow-circle-o-down',
			'arrow-circle-o-up'     => 'arrow-circle-o-up',
			'inbox'                 => 'inbox',
			'play-circle-o'         => 'play-circle-o',
			'rotate-right'          => 'rotate-right',
			'repeat'                => 'repeat',
			'refresh'               => 'refresh',
			'list-alt'              => 'list-alt',
			'flag'                  => 'flag',
			'headphones'            => 'headphones',
			'volume-off'            => 'volume-off',
			'volume-down'           => 'volume-down',
			'volume-up'             => 'volume-up',
			'qrcode'                => 'qrcode',
			'barcode'               => 'barcode',
			'tag'                   => 'tag',
			'tags'                  => 'tags',
			'bookmark'              => 'bookmark',
			'camera'                => 'camera',
			'font'                  => 'font',
			'bold'                  => 'bold',
			'italic'                => 'italic',
			'text-height'           => 'text-height',
			'text-width'            => 'text-width',
			'align-left'            => 'align-left',
			'align-center'          => 'align-center',
			'align-right'           => 'align-right',
			'align-justify'         => 'align-justify',
			'list'                  => 'list',
			'dedent'                => 'dedent',
			'outdent'               => 'outdent',
			'indent'                => 'indent',
			'video-camera'          => 'video-camera',
			'photo'                 => 'photo',
			'pencil'                => 'pencil',
			'map-marker'            => 'map-marker',
			'adjust'                => 'adjust',
			'tint'                  => 'tint',
			'edit'                  => 'edit',
			'pencil-square-o'       => 'pencil-square-o',
			'share-square-o'        => 'share-square-o',
			'check-square-o'        => 'check-square-o',
			'arrows'                => 'arrows',
			'step-backward'         => 'step-backward',
			'fast-backward'         => 'fast-backward',
			'backward'              => 'backward',
			'play'                  => 'play',
			'pause'                 => 'pause',
			'stop'                  => 'stop',
			'forward'               => 'forward',
			'fast-forward'          => 'fast-forward',
			'Step Forward'          => 'step-forward',
			'Eject'                 => 'eject',
			'Chevron Left'          => 'chevron-left',
			'Chevron Right'         => 'chevron-right',
			'Plus Circle'           => 'plus-circle',
			'Minus Circle'          => 'minus-circle',
			'Times Circle'          => 'times-circle',
			'Check Circle'          => 'check-circle',
			'Crosshairs'            => 'crosshairs',
			'Times Circle O'        => 'times-circle-o',
			'Check Circle O'        => 'check-circle-o',
			'Ban'                   => 'ban',
			'Arrow Left'            => 'arrow-left',
			'Arrow Right'           => 'arrow-right',
			'Arrow Up'              => 'arrow-up',
			'Arrow Down'            => 'arrow-down',
			'Share'                 => 'share',
			'Expand'                => 'expand',
			'Compress'              => 'compress',
			'Plus'                  => 'plus',
			'Minus'                 => 'minus',
			'Asterisk'              => 'asterisk',
			'Gift'                  => 'gift',
			'Leaf'                  => 'leaf',
			'Fire'                  => 'fire',
			'Eye'                   => 'eye',
			'Eye Slash'             => 'eye-slash',
			'Warning'               => 'warning',
			'Plane'                 => 'plane',
			'Calendar'              => 'calendar',
			'Random'                => 'random',
			'Comment'               => 'comment',
			'Magnet'                => 'magnet',
			'Chevron Up'            => 'chevron-up',
			'Chevron Down'          => 'chevron-down',
			'Retweet'               => 'retweet',
			'Shopping Cart'         => 'shopping-cart',
			'Folder'                => 'folder',
			'Arrow V'               => 'arrows-v',
			'Arrow H'               => 'arrows-h',
			'Bar Chart'             => 'bar-chart',
			'Twitter Square'        => 'twitter-square',
			'Facebook Square'       => 'facebook-square',
			'Camera Retro'          => 'camera-retro',
			'Key'                   => 'key',
			'Gears'                 => 'gears',
			'Comments'              => 'comments',
			'Thumbs O Up'           => 'thumbs-o-up',
			'Thumbs O Down'         => 'thumbs-o-down',
			'Star Half'             => 'star-half',
			'Heart O'               => 'heart-o',
			'Sign Out'              => 'sign-out',
			'Linkedin Square'       => 'linkedin-square',
			'Thumb Tack'            => 'thumb-tack',
			'Sign In'               => 'sign-in',
			'Trophy'                => 'trophy',
			'Github Square'         => 'github-square',
			'Upload'                => 'upload',
			'Lemon O'               => 'lemon-o',
			'Phone'                 => 'phone',
			'Square O'              => 'square-o',
			'Bookmark O'            => 'bookmark-o',
			'Phone Square'          => 'phone-square',
			'Twitter'               => 'twitter',
			'Facebook'              => 'facebook',
			'Github'                => 'github',
			'Unlock'                => 'unlock',
			'Credit Card'           => 'credit-card',
			'RSS'                   => 'rss',
			'HDD O'                 => 'hdd-o',
			'Bullhorn'              => 'bullhorn',
			'bell'                  => 'bell',
			'Certificate'           => 'certificate',
			'Hand O Right'          => 'hand-o-right',
			'Hand O Left'           => 'hand-o-left',
			'Hand O Up'             => 'hand-o-up',
			'Hand O Down'           => 'hand-o-down',
			'Arrow Circle Left'     => 'arrow-circle-left',
			'Arrow Circle Right'    => 'arrow-circle-right',
			'Arrow Circle Up'       => 'arrow-circle-up',
			'Arrow Circle Down'     => 'arrow-circle-down',
			'Globe'                 => 'globe',
			'Wrench'                => 'wrench',
			'Tasks'                 => 'tasks',
			'Filter'                => 'filter',
			'Briefcase'             => 'briefcase',
			'Arrows Alt'            => 'arrows-alt',
			'Group'                 => 'group',
			'Cload'                 => 'cloud',
			'Flask'                 => 'flask',
			'Scissors'              => 'scissors',
			'Paperclip'             => 'paperclip',
			'Save'                  => 'save',
			'Floppy O'              => 'floppy-o',
			'Square'                => 'square',
			'Navicon'               => 'navicon',
			'Bars'                  => 'bars',
			'List UL'               => 'list-ul',
			'List OL'               => 'list-ol',
			'Strikethrough'         => 'strikethrough',
			'Underline'             => 'underline',
			'Table'                 => 'table',
			'Magic'                 => 'magic',
			'Truck'                 => 'truck',
			'Pinterest'             => 'pinterest',
			'Pinterest Square'      => 'pinterest-square',
			'Google Plus Square'    => 'google-plus-square',
			'Google Plus'           => 'google-plus',
			'Money'                 => 'money',
			'Caret Left'            => 'caret-left',
			'Caret right'           => 'caret-right',
			'Columns'               => 'columns',
			'Unsorted'              => 'unsorted',
			'Sort'                  => 'sort',
			'Sort Desc'             => 'sort-desc',
			'Sort Asc'              => 'sort-asc',
			'Envelope'              => 'envelope',
			'LinkedIn'              => 'linkedin',
			'Rotate Left'           => 'rotate-left',
			'Legal'                 => 'legal',
			'Tachometer'            => 'tachometer',
			'Comment O'             => 'comment-o',
			'Comments O'            => 'comments-o',
			'Bolt'                  => 'bolt',
			'Sitemap'               => 'sitemap',
			'Umbrella'              => 'umbrella',
			'Lightbulb O'           => 'lightbulb-o',
			'Exchange'              => 'exchange',
			'Cloud Download'        => 'cloud-download',
			'Cloud Upload'          => 'cloud-upload',
			'User MD'               => 'user-md',
			'Stethoscope'           => 'stethoscope',
			'Suitcase'              => 'suitcase',
			'Bell O'                => 'bell-o',
			'Coffee'                => 'coffee',
			'Cutlery'               => 'cutlery',
			'Building O'            => 'building-o',
			'Hospital O'            => 'hospital-o',
			'Ambulance'             => 'ambulance',
			'Medkit'                => 'medkit',
			'Fighter Jet'           => 'fighter-jet',
			'Beer'                  => 'beer',
			'H Square'              => 'h-square',
			'Plus Square'           => 'plus-square',
			'Angle Double Left'     => 'angle-double-left',
			'Angle Double Right'    => 'angle-double-right',
			'Angle Double UP'       => 'angle-double-up',
			'Angle Double Down'     => 'angle-double-down',
			'Angle Left'            => 'angle-left',
			'Angle Right'           => 'angle-right',
			'Angle Up'              => 'angle-up',
			'Angle Down'            => 'angle-down',
			'Desktop'               => 'desktop',
			'Laptop'                => 'laptop',
			'Tablet'                => 'tablet',
			'Mobile'                => 'mobile',
			'Circle O'              => 'circle-o',
			'Quote Left'            => 'quote-left',
			'quote-right'           => 'quote-right',
			'spinner'               => 'spinner',
			'circle'                => 'circle',
			'reply'                 => 'reply',
			'github-alt'            => 'github-alt',
			'folder-o'              => 'folder-o',
			'folder-open-o'         => 'folder-open-o',
			'smile-o'               => 'smile-o',
			'frown-o'               => 'frown-o',
			'meh-o'                 => 'meh-o',
			'gamepad'               => 'gamepad',
			'keyboard-o'            => 'keyboard-o',
			'flag-o'                => 'flag-o',
			'flag-checkered'        => 'flag-checkered',
			'terminal'              => 'terminal',
			'mail-reply-all'        => 'mail-reply-all',
			'reply-all'             => 'reply-all',
			'star-half-empty'       => 'star-half-empty',
			'location-arrow'        => 'location-arrow',
			'crop'                  => 'crop',
			'code-fork'             => 'code-fork',
			'unlink'                => 'unlink',
			'question'              => 'question',
			'info'                  => 'info',
			'exclamation'           => 'exclamation',
			'superscript'           => 'superscript',
			'subscript'             => 'subscript',
			'eraser'                => 'eraser',
			'puzzle-piece'          => 'puzzle-piece',
			'microphone'            => 'microphone',
			'microphone-slash'      => 'microphone-slash',
			'shield'                => 'shield',
			'calendar-o'            => 'calendar-o',
			'fire-extinguisher'     => 'fire-extinguisher',
			'rocket'                => 'rocket',
			'maxcdn'                => 'maxcdn',
			'chevron-circle-left'   => 'chevron-circle-left',
			'chevron-circle-right'  => 'chevron-circle-right',
			'chevron-circle-up'     => 'chevron-circle-up',
			'chevron-circle-down'   => 'chevron-circle-down',
			'html5'                 => 'html5',
			'css3'                  => 'css3',
			'anchor'                => 'anchor',
			'unlock-alt'            => 'unlock-alt',
			'bullseye'              => 'bullseye',
			'ellipsis-h'            => 'ellipsis-h',
			'ellipsis-v'            => 'ellipsis-v',
			'rss-square'            => 'rss-square',
			'play-circle'           => 'play-circle',
			'ticket'                => 'ticket',
			'minus-square'          => 'minus-square',
			'minus-square-o'        => 'minus-square-o',
			'level-up'              => 'level-up',
			'level-down'            => 'level-down',
			'check-square'          => 'check-square',
			'pencil-square'         => 'pencil-square',
			'external-link-square'  => 'external-link-square',
			'share-square'          => 'share-square',
			'compass'               => 'compass',
			'toggle-down'           => 'toggle-down',
			'toggle-up'             => 'toggle-up',
			'toggle-right'          => 'toggle-right',
			'euro'                  => 'euro',
			'eur'                   => 'eur',
			'gbp'                   => 'gbp',
			'dollar'                => 'dollar',
			'rupee'                 => 'rupee',
			'inr'                   => 'inr',
			'cny'                   => 'cny',
			'rmb'                   => 'rmb',
			'yen'                   => 'yen',
			'jpy'                   => 'jpy',
			'ruble'                 => 'ruble',
			'rouble'                => 'rouble',
			'rub'                   => 'rub',
			'won'                   => 'won',
			'krw'                   => 'krw',
			'bitcoin'               => 'bitcoin',
			'btc'                   => 'btc',
			'file'                  => 'file',
			'file-text'             => 'file-text',
			'sort-alpha-asc'        => 'sort-alpha-asc',
			'sort-alpha-desc'       => 'sort-alpha-desc',
			'sort-amount-asc'       => 'sort-amount-asc',
			'sort-amount-desc'      => 'sort-amount-desc',
			'sort-numeric-asc'      => 'sort-numeric-asc',
			'sort-numeric-desc'     => 'sort-numeric-desc',
			'thumbs-up'             => 'thumbs-up',
			'thumbs-down'           => 'thumbs-down',
			'youtube-square'        => 'youtube-square',
			'youtube'               => 'youtube',
			'xing'                  => 'xing',
			'xing-square'           => 'xing-square',
			'dropbox'               => 'dropbox',
			'stack-overflow'        => 'stack-overflow',
			'instagram'             => 'instagram',
			'flickr'                => 'flickr',
			'adn'                   => 'adn',
			'bitbucket'             => 'bitbucket',
			'bitbucket-square'      => 'bitbucket-square',
			'tumblr'                => 'tumblr',
			'tumblr-square'         => 'tumblr-square',
			'long-arrow-down'       => 'long-arrow-down',
			'long-arrow-up'         => 'long-arrow-up',
			'long-arrow-left'       => 'long-arrow-left',
			'long-arrow-right'      => 'long-arrow-right',
			'apple'                 => 'apple',
			'windows'               => 'windows',
			'android'               => 'android',
			'linux'                 => 'linux',
			'dribbble'              => 'dribbble',
			'skype'                 => 'skype',
			'foursquare'            => 'foursquare',
			'trello'                => 'trello',
			'female'                => 'female',
			'male'                  => 'male',
			'gittip'                => 'gittip',
			'gratipay'              => 'gratipay',
			'sun-o'                 => 'sun-o',
			'moon-o'                => 'moon-o',
			'archive'               => 'archive',
			'bug'                   => 'bug',
			'vk'                    => 'vk',
			'weibo'                 => 'weibo',
			'renren'                => 'renren',
			'pagelines'             => 'pagelines',
			'stack-exchange'        => 'stack-exchange',
			'arrow-circle-o-right'  => 'arrow-circle-o-right',
			'arrow-circle-o-left'   => 'arrow-circle-o-left',
			'toggle-left'           => 'toggle-left',
			'dot-circle-o'          => 'dot-circle-o',
			'wheelchair'            => 'wheelchair',
			'vimeo-square'          => 'vimeo-square',
			'turkish-lira'          => 'turkish-lira',
			'try'                   => 'try',
			'plus-square-o'         => 'plus-square-o',
			'space-shuttle'         => 'space-shuttle',
			'slack'                 => 'slack',
			'envelope-square'       => 'envelope-square',
			'wordpress'             => 'wordpress',
			'openid'                => 'openid',
			'bank'                  => 'bank',
			'graduation-cap'        => 'graduation-cap',
			'yahoo'                 => 'yahoo',
			'google'                => 'google',
			'reddit'                => 'reddit',
			'reddit-square'         => 'reddit-square',
			'stumbleupon-circle'    => 'stumbleupon-circle',
			'stumbleupon'           => 'stumbleupon',
			'delicious'             => 'delicious',
			'digg'                  => 'digg',
			'pied-piper-pp'         => 'pied-piper-pp',
			'pied-piper-alt'        => 'pied-piper-alt',
			'drupal'                => 'drupal',
			'joomla'                => 'joomla',
			'language'              => 'language',
			'fax'                   => 'fax',
			'building'              => 'building',
			'child'                 => 'child',
			'paw'                   => 'paw',
			'spoon'                 => 'spoon',
			'cube'                  => 'cube',
			'cubes'                 => 'cubes',
			'behance'               => 'behance',
			'behance-square'        => 'behance-square',
			'steam'                 => 'steam',
			'steam-square'          => 'steam-square',
			'recycle'               => 'recycle',
			'car'                   => 'car',
			'cab'                   => 'cab',
			'taxi'                  => 'taxi',
			'tree'                  => 'tree',
			'spotify'               => 'spotify',
			'deviantart'            => 'deviantart',
			'soundcloud'            => 'soundcloud',
			'vine'                  => 'vine',
			'codepen'               => 'codepen',
			'jsfiddle'              => 'jsfiddle',
			'life-saver'            => 'life-saver',
			'circle-o-notch'        => 'circle-o-notch',
			'rebel'                 => 'rebel',
			'ge'                    => 'ge',
			'empire'                => 'empire',
			'git-square'            => 'git-square',
			'git'                   => 'git',
			'yc-square'             => 'yc-square',
			'hacker-news'           => 'hacker-news',
			'tencent-weibo'         => 'tencent-weibo',
			'qq'                    => 'qq',
			'wechat'                => 'wechat',
			'paper-plane'           => 'paper-plane',
			'paper-plane-o'         => 'paper-plane-o',
			'history'               => 'history',
			'circle-thin'           => 'circle-thin',
			'header'                => 'header',
			'paragraph'             => 'paragraph',
			'sliders'               => 'sliders',
			'share-alt'             => 'share-alt',
			'share-alt-square'      => 'share-alt-square',
			'bomb'                  => 'bomb',
			'soccer-ball-o'         => 'soccer-ball-o',
			'futbol-o'              => 'futbol-o',
			'tty'                   => 'tty',
			'binoculars'            => 'binoculars',
			'plug'                  => 'plug',
			'slideshare'            => 'slideshare',
			'twitch'                => 'twitch',
			'yelp'                  => 'yelp',
			'newspaper-o'           => 'newspaper-o',
			'wifi'                  => 'wifi',
			'calculator'            => 'calculator',
			'paypal'                => 'paypal',
			'google-wallet'         => 'google-wallet',
			'cc-visa'               => 'cc-visa',
			'cc-mastercard'         => 'cc-mastercard',
			'cc-discover'           => 'cc-discover',
			'cc-amex'               => 'cc-amex',
			'cc-paypal'             => 'cc-paypal',
			'cc-stripe'             => 'cc-stripe',
			'bell-slash'            => 'bell-slash',
			'bell-slash-o'          => 'bell-slash-o',
			'trash'                 => 'trash',
			'copyright'             => 'copyright',
			'at'                    => 'at',
			'eyedropper'            => 'eyedropper',
			'paint-brush'           => 'paint-brush',
			'birthday-cake'         => 'birthday-cake',
			'area-chart'            => 'area-chart',
			'pie-chart'             => 'pie-chart',
			'line-chart'            => 'line-chart',
			'lastfm'                => 'lastfm',
			'lastfm-square'         => 'lastfm-square',
			'toggle-off'            => 'toggle-off',
			'toggle-on'             => 'toggle-on',
			'bicycle'               => 'bicycle',
			'bus'                   => 'bus',
			'ioxhost'               => 'ioxhost',
			'angellist'             => 'angellist',
			'cc'                    => 'cc',
			'shekel'                => 'shekel',
			'sheqel'                => 'sheqel',
			'ils'                   => 'ils',
			'meanpath'              => 'meanpath',
			'buysellads'            => 'buysellads',
			'connectdevelop'        => 'connectdevelop',
			'dashcube'              => 'dashcube',
			'forumbee'              => 'forumbee',
			'leanpub'               => 'leanpub',
			'sellsy'                => 'sellsy',
			'shirtsinbulk'          => 'shirtsinbulk',
			'simplybuilt'           => 'simplybuilt',
			'skyatlas'              => 'skyatlas',
			'cart-plus'             => 'cart-plus',
			'cart-arrow-down'       => 'cart-arrow-down',
			'diamond'               => 'diamond',
			'ship'                  => 'ship',
			'user-secret'           => 'user-secret',
			'motorcycle'            => 'motorcycle',
			'street-view'           => 'street-view',
			'heartbeat'             => 'heartbeat',
			'venus'                 => 'venus',
			'mars'                  => 'mars',
			'mercury'               => 'mercury',
			'intersex'              => 'intersex',
			'transgender-alt'       => 'transgender-alt',
			'venus-double'          => 'venus-double',
			'mars-double'           => 'mars-double',
			'venus-mars'            => 'venus-mars',
			'mars-stroke'           => 'mars-stroke',
			'mars-stroke-v'         => 'mars-stroke-v',
			'mars-stroke-h'         => 'mars-stroke-h',
			'neuter'                => 'neuter',
			'genderless'            => 'genderless',
			'facebook-official'     => 'facebook-official',
			'pinterest-p'           => 'pinterest-p',
			'whatsapp'              => 'whatsapp',
			'server'                => 'server',
			'user-plus'             => 'user-plus',
			'user-times'            => 'user-times',
			'hotel'                 => 'hotel',
			'bed'                   => 'bed',
			'viacoin'               => 'viacoin',
			'train'                 => 'train',
			'subway'                => 'subway',
			'medium'                => 'medium',
			'yc'                    => 'yc',
			'optin-monster'         => 'optin-monster',
			'opencart'              => 'opencart',
			'expeditedssl'          => 'expeditedssl',
			'battery-full'          => 'battery-full',
			'battery-three-quarters' => 'battery-three-quarters',
			'battery-half'          => 'battery-half',
			'battery-quarter'       => 'battery-quarter',
			'battery-empty'         => 'battery-empty',
			'mouse-pointer'         => 'mouse-pointer',
			'i-cursor'              => 'i-cursor',
			'object-group'          => 'object-group',
			'object-ungroup'        => 'object-ungroup',
			'sticky-note'           => 'sticky-note',
			'sticky-note-o'         => 'sticky-note-o',
			'cc-jcb'                => 'cc-jcb',
			'cc-diners-club'        => 'cc-diners-club',
			'clone'                 => 'clone',
			'balance-scale'         => 'balance-scale',
			'hourglass-o'           => 'hourglass-o',
			'hourglass-start'       => 'hourglass-start',
			'hourglass-half'        => 'hourglass-half',
			'hourglass-end'         => 'hourglass-end',
			'hourglass'             => 'hourglass',
			'hand-rock-o'           => 'hand-rock-o',
			'hand-paper-o'          => 'hand-paper-o',
			'hand-scissors-o'       => 'hand-scissors-o',
			'hand-lizard-o'         => 'hand-lizard-o',
			'hand-spock-o'          => 'hand-spock-o',
			'hand-pointer-o'        => 'hand-pointer-o',
			'hand-peace-o'          => 'hand-peace-o',
			'trademark'             => 'trademark',
			'registered'            => 'registered',
			'creative-commons'      => 'creative-commons',
			'gg'                    => 'gg',
			'gg-circle'             => 'gg-circle',
			'tripadvisor'           => 'tripadvisor',
			'odnoklassniki'         => 'odnoklassniki',
			'odnoklassniki-square'  => 'odnoklassniki-square',
			'get-pocket'            => 'get-pocket',
			'wikipedia-w'           => 'wikipedia-w',
			'safari'                => 'safari',
			'chrome'                => 'chrome',
			'firefox'               => 'firefox',
			'opera'                 => 'opera',
			'internet-explorer'     => 'internet-explorer',
			'tv'                    => 'tv',
			'contao'                => 'contao',
			'500px'                 => '500px',
			'amazon'                => 'amazon',
			'calendar-plus-o'       => 'calendar-plus-o',
			'calendar-minus-o'      => 'calendar-minus-o',
			'calendar-times-o'      => 'calendar-times-o',
			'calendar-check-o'      => 'calendar-check-o',
			'industry'              => 'industry',
			'map-pin'               => 'map-pin',
			'map-signs'             => 'map-signs',
			'map-o'                 => 'map-o',
			'map'                   => 'map',
			'commenting'            => 'commenting',
			'commenting-o'          => 'commenting-o',
			'houzz'                 => 'houzz',
			'vimeo'                 => 'vimeo',
			'black-tie'             => 'black-tie',
			'fonticons'             => 'fonticons',
			'reddit-alien'          => 'reddit-alien',
			'edge'                  => 'edge',
			'credit-card-alt'       => 'credit-card-alt',
			'codiepie'              => 'codiepie',
			'modx'                  => 'modx',
			'fort-awesome'          => 'fort-awesome',
			'usb'                   => 'usb',
			'product-hunt'          => 'product-hunt',
			'mixcloud'              => 'mixcloud',
			'scribd'                => 'scribd',
			'pause-circle'          => 'pause-circle',
			'pause-circle-o'        => 'pause-circle-o',
			'stop-circle'           => 'stop-circle',
			'stop-circle-o'         => 'stop-circle-o',
			'shopping-bag'          => 'shopping-bag',
			'shopping-basket'       => 'shopping-basket',
			'hashtag'               => 'hashtag',
			'bluetooth'             => 'bluetooth',
			'bluetooth-b'           => 'bluetooth-b',
			'percent'               => 'percent',
			'gitlab'                => 'gitlab',
			'wpbeginner'            => 'wpbeginner',
			'wpforms'               => 'wpforms',
			'envira'                => 'envira',
			'universal-access'      => 'universal-access',
			'wheelchair-alt'        => 'wheelchair-alt',
			'question-circle-o'     => 'question-circle-o',
			'blind'                 => 'blind',
			'audio-description'     => 'audio-description',
			'volume-control-phone'  => 'volume-control-phone',
			'braille'               => 'braille',
			'assistive-listening-systems' => 'assistive-listening-systems',
			'american-sign-language-interpreting' => 'american-sign-language-interpreting',
			'hard-of-hearing'       => 'hard-of-hearing',
			'glide'                 => 'glide',
			'glide-g'               => 'glide-g',
			'sign-language'         => 'sign-language',
			'low-vision'            => 'low-vision',
			'viadeo'                => 'viadeo',
			'viadeo-square'         => 'viadeo-square',
			'snapchat'              => 'snapchat',
			'snapchat-ghost'        => 'snapchat-ghost',
			'snapchat-square'       => 'snapchat-square',
			'pied-piper'            => 'pied-piper',
			'first-order'           => 'first-order',
			'yoast'                 => 'yoast',
			'themeisle'             => 'themeisle',
			'google-plus-circle'    => 'google-plus-circle',
			'google-plus-official'  => 'google-plus-official',
			'font-awesome'          => 'font-awesome',
			'handshake-o'           => 'handshake-o',
			'envelope-open'         => 'envelope-open',
			'envelope-open-o'       => 'envelope-open-o',
			'linode'                => 'linode',
			'address-book'          => 'address-book',
			'address-book-o'        => 'address-book-o',
			'address-card'          => 'address-card',
			'address-card-o'        => 'address-card-o',
			'user-circle'           => 'user-circle',
			'user-circle-o'         => 'user-circle-o',
			'user-o'                => 'user-o',
			'id-badge'              => 'id-badge',
			'id-card'               => 'id-card',
			'id-card-o'             => 'id-card-o',
			'quora'                 => 'quora',
			'free-code-camp'        => 'free-code-camp',
			'telegram'              => 'telegram',
			'thermometer-full'      => 'thermometer-full',
			'thermometer-three-quarters' => 'thermometer-three-quarters',
			'thermometer-half'      => 'thermometer-half',
			'thermometer-quarter'   => 'thermometer-quarter',
			'thermometer-0'         => 'thermometer-0'       ,
			'thermometer-empty'     => 'thermometer-empty',
			'shower'                => 'shower',
			'bathtub'               => 'bathtub'       ,
			's15'                   => 's15'       ,
			'podcast'               => 'podcast',
			'window-maximize'       => 'window-maximize',
			'window-minimize'       => 'window-minimize',
			'window-restore'        => 'window-restore',
			'window-close'          => 'window-close',
			'window-close-o'        => 'window-close-o',
			'bandcamp'              => 'bandcamp',
			'grav'                  => 'grav',
			'etsy'                  => 'etsy',
			'imdb'                  => 'imdb',
			'ravelry'               => 'ravelry',
			'eercast'               => 'eercast',
			'microchip'             => 'microchip',
			'snowflake-o'           => 'snowflake-o',
			'superpowers'           => 'superpowers',
			'wpexplorer'            => 'wpexplorer',
			'meetup'                => 'meetup'
		);
		ksort($other_icons);

		return $other_icons;
	}
}

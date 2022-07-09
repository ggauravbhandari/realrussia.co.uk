<?php

/**
 * Utility functions just for this add-on
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class KBLK_Local_Utilities {

	public static function is_link_editor( $post ) {
		return ! empty($post->post_mime_type) && ( $post->post_mime_type == 'kb_link' or $post->post_mime_type == 'kblink' );
	}
}

<?php
/**
 * Plugin Name:     Unregister Broken Patterns
 * Plugin URI:      https://github.com/jeremyfelt/unregister-broken-patterns/
 * Description:     Unregister block patterns that contain unavailable blocks.
 * Author:          jeremyfelt
 * Author URI:      https://jeremyfelt.com
 * Version:         1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'block_editor_settings','ubp_remove_patterns_with_unavailable_blocks', 99 );

/**
 * Remove registered block patterns that contain block types that have been removed
 * from the editor, likely via the `allowed_block_types` filter.
 *
 * @param array $editor_settings A list of settings for the editor. See wp-admin/edit-form-blocks.php
 * @return array $editor_settings A modified list of settings for the editor.
 */
function ubp_remove_patterns_with_unavailable_blocks( $editor_settings ) {
	$allowed_block_types = $editor_settings['allowedBlockTypes'];
	$block_patterns      = $editor_settings['__experimentalBlockPatterns'];
	$filtered_patterns   = array();

	// The `block_editor_settings` filter allows true to enable all and false to disable all.
	// If it is set as boolean, I'm not going to touch the patterns.
	if ( is_bool( $allowed_block_types ) ) {
		return $editor_settings;
	}

	foreach ( $block_patterns as $block_pattern ) {
		$blocks = parse_blocks( $block_pattern['content'] );

		// Assume this pattern is okay for use.
		$okay = true;

		foreach ( $blocks as $block ) {
			if ( ! in_array( $block['blockName'], $allowed_block_types, true ) ) {
				// We found an unsupported block, bail.
				$okay = false;
				continue;
			}
		}

		// If still okay for use, store the pattern.
		if ( $okay ) {
			$filtered_patterns[] = $block_pattern;
		}
	}

	$editor_settings['__experimentalBlockPatterns'] = $filtered_patterns;

	return $editor_settings;
}

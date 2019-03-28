<?php

/**
 * Date: 2019-03-26
 * Licensed under MIT
 *
 * @author Lumen Learning
 * @package CandelaOutcomes
 * @copyright (c) Lumen Learning
 */

namespace Candela;

class Outcomes {
	/**
	 * Register hooks and set constants.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', [ __CLASS__, 'add_meta_boxes' ] );
		add_action( 'save_post', [ __CLASS__, 'save' ] );
		add_filter( 'pb_import_metakeys', [ __CLASS__, 'get_import_metakeys' ] );
	}

	/**
	 * Attach custom meta fields.
	 *
	 * @see http://codex.wordpress.org/Function_Reference/add_meta_box
	 */
	public static function add_meta_boxes() {
		$types = self::post_types();

		foreach ( $types as $type ) {
			add_meta_box(
				'outcomes',
				'Course Outcomes',
				[ __CLASS__, 'render_outcomes' ],
				$type,
				'normal',
				'low'
			);
		}
	}

	/**
	 * Return an array of post types to add outcomes to.
	 *
	 * @return array
	 */
	public static function post_types() {
		return [ 'back-matter', 'chapter', 'part', 'front-matter' ];
	}

	/**
	 * Render outcome guid fields.
	 *
	 * @param $post
	 */
	public static function render_outcomes( $post ) {
		$meta = self::get_outcome_guids( $post->ID );
		?>
		<div class="inside">
			<label for="outcomes_input">
				List GUID(s) associated with this content. Separate multiple GUIDs with commas.
			</label>
			<input id="outcomes_input" class="widefat" type="text" name="outcome_guids" placeholder="ie. 26e0522b-abe5-4659-b393-c139f8acf97d" pattern="[a-zA-Z0-9, :-]*" value="<?php echo ( isset( $meta ) ) ? esc_attr( $meta ) : ''; ?>" />
			<?php wp_nonce_field( 'edit', 'outcome_guids_nonce' ); ?>
		</div>
		<?php
	}

	/**
	 * Get the outcomes guid meta data.
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	public static function get_outcome_guids( $post_id ) {
		return get_post_meta( $post_id, 'CANDELA_OUTCOMES_GUID', true );
	}

	/**
	 * Save guid post meta submitted via form.
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public static function save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		if ( isset( $_POST['outcome_guids'], $_POST['outcome_guids_nonce'] ) && wp_verify_nonce( $_POST['outcome_guids_nonce'], 'edit' ) ) {
			$guid_data = strtolower( $_POST['outcome_guids'] );
			$guid_data = preg_replace( '/([^a-z0-9, :-])/', '', $guid_data );

			update_post_meta( $post_id, 'CANDELA_OUTCOMES_GUID', $guid_data );
		}
	}

	/**
	 * Add Candela Outcomes to import meta.
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	public static function get_import_metakeys( $fields ) {
		$fields[] = 'CANDELA_OUTCOMES_GUID';

		return $fields;
	}
}

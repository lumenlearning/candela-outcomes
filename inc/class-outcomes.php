<?php

namespace Candela;

class Outcomes {
  /**
   * Takes care of registering our hooks and setting constants.
   */
  public static function init() {
    add_action( 'rest_api_init', array( __CLASS__, 'add_api_endpoint' ) );
    add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
    add_action( 'save_post', array( __CLASS__, 'save' ) );
    add_action( 'display_outcome_html', array( __CLASS__, 'display_outcome_html' ) ); // Does this do anything?
    add_filter( 'pb_import_metakeys', array( __CLASS__, 'get_import_metakeys' ) );
  }

  /**
   * Add the Candela Outcome Guid API endpoint
   */
  public static function add_api_endpoint() {
    register_meta( 'post', CANDELA_OUTCOMES_GUID, [
      'show_in_rest' => true,
      'single' => true,
      'type' => 'string'
    ] );
  }

  /**
   * Add the metaboxes
   */
  public static function add_meta_boxes() {
    $types = self::postTypes();

    foreach ( $types as $type ) {
      add_meta_box(
        'outcomes',
        'Course Outcomes',
        array( __CLASS__, 'add_outcomes_meta' ),
        $type,
        'normal',
        'low'
      );
    }
  }

  /**
   * Returns array of custom post types (defined by Pressbooks)
   */
  public static function postTypes() {
    return array(
      'back-matter',
      'chapter',
      'part',
      'front-matter'
    );
  }

  /**
   * Render Outcomes metaboxes
   */
  public static function add_outcomes_meta( $post ) {
    $outcomes = self::get_outcomes( $post->ID );

    ?>
      <div class="inside">
          <label for="outcomes_input">
            <?php _e( "List GUID(s) associated with this content. Separate multiple GUIDs with commas.", 'textdomain' ); ?>
          </label>
          <input id="outcomes_input" class="widefat" type="text" name="candela_outcomes_guid_data" placeholder="ie. 26e0522b-abe5-4659-b393-c139f8acf97d" pattern="[a-zA-Z0-9, :-]*" value="<?php echo ( isset( $outcomes ) ) ? esc_attr( $outcomes ) : ''; ?>" />
      </div>
    <?php
  }

  /**
   * Get the Outcomes metadata
   */
  public static function get_outcomes( $post_id ) {
    return get_post_meta( $post_id, CANDELA_OUTCOMES_GUID, true );
  }

  /**
   * Save a post submitted via form.
   *
   * @param $post_id
   *
   * @return mixed
   */
  public static function save( $post_id ) {
    if ( ! isset( $post_id ) ) {
      $post_id = (int) $_REQUEST['post_ID'];
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return $post_id;
    }

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return $post_id;
    }

    $types = self::postTypes();

    if ( isset( $_POST['candela_outcomes_guid_data'] ) ) {
      $outcomes = strtolower( $_POST['candela_outcomes_guid_data'] );
      $outcomes = preg_replace( '/([^a-z0-9, :-])/', '', $outcomes );
      update_post_meta( $post_id, CANDELA_OUTCOMES_GUID, $outcomes );
    } else {
      delete_post_meta( $post_id, CANDELA_OUTCOMES_GUID );
    }
  }

  /**
   * Display Outcome HTML
   *
   * TODO: This looks like it doesn't actually do anything. Delete?
   */
  public static function display_outcome_html( $post_id ) {
    $outcomes = get_post_meta( $post_id, CANDELA_OUTCOMES_GUID );

    if ( ! empty( $outcomes ) ) {
    ?>
      <div id='outcome_description' style='display:none' data-outcome-guids='<?php echo esc_attr( $outcomes[0] ); ?>'></div>
    <?php
    }
  }

  /**
   * Get Metakeys
   */
  public static function get_import_metakeys( $fields ) {
    $fields[] = CANDELA_OUTCOMES_GUID;
    return $fields;
  }
}

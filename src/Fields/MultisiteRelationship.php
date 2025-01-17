<?php
/*
*  ACF - Multisite Relationship field
*
*/

namespace Geniem\ACF\Fields;

add_action( 'acf/init', function() {
    /**
     * ACF Multisite Relationship class
     */
    class ACF_Field_Multisite_Relationship extends \acf_field_relationship {

        /**
         * Initialize the field
         *
         * @return void
         */
        public function initialize() {

            // vars
            $this->name     = 'multisite_relationship';
            $this->label    = __( 'Multisite Relationship', 'acf' );
            $this->category = 'relational';
            $this->defaults = array(
                'post_type'     => array(),
                'taxonomy'      => array(),
                'min'           => 0,
                'max'           => 0,
                'filters'       => array( 'search', 'post_type', 'taxonomy' ),
                'elements'      => array(),
                'return_format' => 'object',
                'blog_id'       => \get_current_blog_id(),
            );

            // extra
            \add_action( 'wp_ajax_acf/fields/multisite_relationship/query', array( $this, 'ajax_query' ) );
            \add_action( 'wp_ajax_nopriv_acf/fields/multisite_relationship/query', array( $this, 'ajax_query' ) );
        }

        /**
         * Enqueue admin scripts
         *
         * @return void
         */
        public function input_admin_enqueue_scripts() {
            parent::input_admin_enqueue_scripts();

            $src = \plugin_dir_url( realpath( __DIR__ . '/..' ) . '/plugin.php' );

            // Strip the src
            $src = \str_replace( '/src/', '/', $src );

            \wp_enqueue_script( 'acf_multisite_relationship', $src . 'assets/scripts/multisite-relationship.js', [ 'acf-input' ] );
        }

        /**
         * Get ajax query
         *
         * @param array $options The options array.
         * @return mixed
         */
        public function get_ajax_query( $options = array() ) {
            $field = acf_get_field( $options['field_key'] );

            $blog_id = $field['blog_id'];

            \switch_to_blog( $blog_id );

            $response = parent::get_ajax_query( $options );

            \restore_current_blog();

            return $response;
        }

        /**
         * Get post title
         *
         * @param mixed   $post The post.
         * @param mixed   $field Field.
         * @param integer $post_id Post ID.
         * @param integer $is_search Is search.
         * @return string
         */
        public function get_post_title( $post, $field, $post_id = 0, $is_search = 0 ) {
            \switch_to_blog( $field['blog_id'] );

            $title = parent::get_post_title( $post, $field, $post_id, $is_search );

            \restore_current_blog();

            // return
            return $title;
        }

        /**
         * Render field.
         *
         * @param array $field Render field.
         * @return void
         */
        public function render_field( $field ) {
            \switch_to_blog( $field['blog_id'] );

            parent::render_field( $field );

            \restore_current_blog();
        }

        /**
         * Format value
         *
         * @param mixed $value Value.
         * @param mixed $post_id Post ID.
         * @param mixed $field Field.
         * @return mixed
         */
        public function format_value( $value, $post_id, $field ) {
            \switch_to_blog( $field['blog_id'] );

            $value = parent::format_value( $value, $post_id, $field );

            \restore_current_blog();

            return $value;
        }
    }

    // initialize
    new ACF_Field_Multisite_Relationship();
});

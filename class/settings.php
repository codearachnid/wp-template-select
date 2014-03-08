<?php

if( ! class_exists( 'WTS_Settings' ) ){
	class WTS_Settings {

		public static $column_key = 'wp-template-select';

		function __construct(){

			add_action( 'admin_menu', array( $this, 'add_settings_submenu' ) );
			add_action( 'admin_init', array( $this, 'register_settings' ) );

		}

		/**
		 * add the menue options into admin settings
		 * @return void
		 */
		function add_settings_submenu(){
			add_options_page( 
				'Template Select', 
				'Template Select', 
				'manage_options', 
				self::$column_key, 
				array( $this, 'wts_option_page' )
				);
		}

		function register_settings(){

			register_setting( 
				self::$column_key, 
				self::$column_key, 
				array( $this, 'wts_validate_options' )
				);

			add_settings_section( 
				'wts_main', 
				__('Configure:', 'wp-template-select' ), 
				null, 
				self::$column_key
				);
			add_settings_field( 
				__( 'Enable on Post Types', 'wp-template-select' ), 
				__( 'Enable on Post Types', 'wp-template-select' ), 
				array( $this, 'field_post_types' ), 
				self::$column_key, 
				'wts_main' 
				);

		}

		/**
		 * settings field for listing post types
		 * @return void
		 */
		function field_post_types(){
			$options = get_option(self::$column_key);
			$post_types = !empty( $options['post_types'] ) ? (array) $options['post_types'] : array();
			$post_type_args = apply_filters( 'wts-settings/post-type-args', array(
				'public'=> true 
				) );
			echo '<ul>';
			foreach( get_post_types( $post_type_args ) as $post_type ) {
				
				?><li>
						<label>
						<input id='<?php echo self::$column_key; ?>-post-types' name='<?php echo self::$column_key; ?>[post_types][<?php echo $post_type; ?>]' type='checkbox' value='<?php echo $post_type; ?>' <?php checked( in_array( $post_type, $post_types ) ); ?> />
						<?php echo ucwords( strtolower( str_replace( '-', ' ', str_replace( '_', ' ', $post_type ) ) ) ); ?></label>
				</li><?php
			}
			echo '</ul>';
		}

		/**
		 * parse validation options for the submitted fields, reconfigure how checkbox
		 * values are passed and saved to database
		 * @param  array $input
		 * @return array
		 */
		function wts_validate_options( $input ) {
			$input['post_types'] = !empty( $input['post_types'] ) ? array_keys( $input['post_types'] ) : array();
			return $input;
		}

		/**
		 * settings page structure
		 * @return void
		 */
		function wts_option_page(){
			?><div class="wrap">
				<h2><?php _e( 'Customize Template Select Options', 'wp-template-select' ); ?></h2>
				<h4><?php _e( 'Because sometimes you just want to revert your slugs to what WordPress thinks is best.', 'wp-template-select' ); ?></h4>
				<form action="options.php" method="post">
					<input type="hidden" name="sanitize_slugs" value="1" />
					<?php 

					settings_fields( self::$column_key ); 
					do_settings_sections( self::$column_key );
					submit_button();

					?>
				</form>
			</div><?php
		}

	}
	return new WTS_Settings();
}
<?php

if( ! class_exists( 'WTS_Settings' ) ){
	class WTS_Settings {

		function __construct(){

			add_action('admin_menu', array( $this, 'add_settings_submenu' ) );
			add_action( 'admin_init', array( $this, 'register_settings' ) );

		}

		/**
		 * add the menue options into admin settings
		 * @return void
		 */
		function add_settings_submenu(){
			add_options_page( 
				'Theme Select', 
				'Theme Select', 
				'manage_options', 
				'wts_options', 
				array( $this, 'wts_option_page' )
				);
		}

		function register_settings(){
			register_setting( 
				'wts_options', 
				'wts_options', 
				array( $this, 'wts_validate_options' )
				);

			add_settings_section( 
				'wts_main', 
				__('Configure:', 'wts' ), 
				null, 
				'wts_options' 
				);
			add_settings_field( 
				__( 'Enable on Post Types', 'wts' ), 
				__( 'Enable on Post Types', 'wts' ), 
				array( $this, 'wts_field_post_types' ), 
				'wts_options', 
				'wts_main' 
				);

		}

		/**
		 * settings field for listing post types
		 * @return void
		 */
		function wts_field_post_types(){
			$options = get_option('wprs_options');
			$post_types = !empty( $options['post_types'] ) ? (array) $options['post_types'] : array();
			echo '<ul>';
			foreach( get_post_types() as $post_type ) {
				
				?><li>
						<label>
						<input id='wprs_reset_post_types' name='wprs_options[post_types][<?php echo $post_type; ?>]' type='checkbox' value='<?php echo $post_type; ?>' <?php checked( in_array( $post_type, $post_types ) ); ?> />
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
				<h2><?php _e( 'Customize Theme Select Options', 'wts' ); ?></h2>
				<h4><?php _e( 'Because sometimes you just want to revert your slugs to what WordPress thinks is best.', 'wts' ); ?></h4>
				<form action="options.php" method="post">
					<input type="hidden" name="sanitize_slugs" value="1" />
					<?php 

					settings_fields( 'wts_options' ); 
					do_settings_sections( 'wts_options' );
					submit_button();

					?>
				</form>
			</div><?php
		}

	}
	return new WTS_Settings();
}
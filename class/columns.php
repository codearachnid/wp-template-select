<?php

if( ! class_exists( 'WTS_Columns' ) ){
	class WTS_Columns {

		private $settings;		

		function __construct(){
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		function admin_init(){
			$this->settings = get_option( WTS_Settings::$column_key );
			
			if( !empty( $this->settings['post_types'] ) ) {
				foreach( $this->settings['post_types'] as $post_type ){
					add_filter( "manage_{$post_type}_posts_columns" , array( $this, 'custom_column_row' ) );
				}
				add_action( 'manage_posts_custom_column' , array( $this, 'custom_column_header' ), 10, 2 );
				add_action( 'manage_pages_custom_column' , array( $this, 'custom_column_header' ), 10, 2 );
			}
			
		}

		function custom_column_header( $column, $post_id ) {
		    switch ( $column ) {
			case WTS_Settings::$column_key :
				?>
				<span class="icon-<?php echo WTS_Settings::$column_key; ?> action-<?php echo WTS_Settings::$column_key; ?>"><br /></span>
				<?php
				break;
		    }
		}

		function custom_column_row( $columns ){
			$columns[ WTS_Settings::$column_key ] = sprintf( '<a href="%s"><span><span class="vers"><div title="%s" class="%s"></div></span></span><span class="sorting-indicator"></span></a>',
				'http://local.wordpress.dev/wp-admin/edit.php?orderby=comment_count&amp;order=asc',
				__( 'Select Template', 'wp-template-select' ),
				'icon-' . WTS_Settings::$column_key . ' header-' . WTS_Settings::$column_key );
			return $columns;
		}
	
	}

	return new WTS_Columns();
}
<?php

if( ! class_exists( 'WTS_Columns' ) ){
	class WTS_Columns {

		private $column_key = 'wts-show-template';

		function __construct(){
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		function admin_init(){
			add_filter( 'manage_post_posts_columns' , array( $this, 'manage_cpt_posts_columns' ) );
			add_action( 'manage_posts_custom_column' , array( $this, 'manage_posts_custom_column' ), 10, 2 );
		}

		function manage_posts_custom_column( $column, $post_id ) {
		    switch ( $column ) {
			case $this->column_key :
				?>
				<span class="icon-<?php echo $this->column_key; ?> action-<?php echo $this->column_key; ?>"><br /></span>
				<?php
			    // _e('show template');
				break;
		    }
		}

		function manage_cpt_posts_columns( $columns ){
			$columns[ $this->column_key ] = sprintf( '<a href="%s"><span><span class="vers"><div title="%s" class="%s"></div></span></span><span class="sorting-indicator"></span></a>',
				'http://local.wordpress.dev/wp-admin/edit.php?orderby=comment_count&amp;order=asc',
				__('Template'),
				'icon-' . $this->column_key . ' header-' . $this->column_key );
			return $columns;
		}
	
	}

	return new WTS_Columns();
}
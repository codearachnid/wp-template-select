jQuery(document).ready ->
	# remove page template on heirarchical pages
	jQuery( "select[name='page_template']" ).parent().remove();

	jQuery( ".action-wp-template-select" ).hover(
		->
			console.log('hover');
			console.log('test');
		-> console.log('hover out');
		)

	#'click', (event) ->
	#	jQuery( @ ).text('clicked');
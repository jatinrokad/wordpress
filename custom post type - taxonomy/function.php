/************************  Create custome Post and taxonomy ***************************************/

add_action( 'init', 'post_entertainment' );
/**
 * Register a Entertainments post type.
 */
function post_entertainment() {
	$labels = array(
		'name'               => _x( 'Entertainments', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Entertainment', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Entertainments', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Entertainment', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'entertainment', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Entertainment', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Entertainment', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Entertainment', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Entertainment', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Entertainments', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Entertainments', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Entertainments:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Entertainments found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Entertainments found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'entertainment' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'entertainment', $args );
}

/**********   Register Taxonomy   *****************/

// hook into the init action and call create_entertainment_taxonomies when it fires
add_action( 'init', 'create_entertainment_taxonomies', 0 );

// create taxonomies bollywood for the post type "entertainment"
function create_entertainment_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Bollywoods', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Bollywood', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Bollywoods', 'textdomain' ),
		'all_items'         => __( 'All Bollywood', 'textdomain' ),
		'parent_item'       => __( 'Parent Bollywood', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Bollywood:', 'textdomain' ),
		'edit_item'         => __( 'Edit Bollywood', 'textdomain' ),
		'update_item'       => __( 'Update Bollywood', 'textdomain' ),
		'add_new_item'      => __( 'Add New Bollywood', 'textdomain' ),
		'new_item_name'     => __( 'New Bollywood Name', 'textdomain' ),
		'menu_name'         => __( 'Bollywood', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'bollywood' ),
	);

	register_taxonomy( 'bollywood', array( 'entertainment' ), $args );

}
/************************  end of custome Post and taxonomy ***************************************/

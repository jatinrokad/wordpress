/**************    Create Slider Shortcode ************/

function slider_func() {
	$var = '';
	$args = array(
	'posts_per_page'   => -1,
	'post_type'        => 'slider',
	'post_status'      => 'publish',
);
$slider = get_posts( $args );

	$var .= '<div id="primary" class="content-area">';
		$var .= '<div class="home-owl-slider owl-carousel owl-theme">';
		foreach ($slider as $slide) {
			$var .= '<div class="item">';
				$var .= '<div class="image">';	
				$var .= '<a href="'. get_permalink() .'">' . get_the_post_thumbnail($slide->ID, 'full') . '';
				$var .= '</a>';
				$var .= '</div>';
				$var .= '<div class="content container">';
					$var .= '<h1>' . $slide->post_title . '</h1>';
					$var .= '<p>' . $slide->post_content . '</p>';
				$var .= '</div></div>';
		}
	$var .= '</div></div>';
	return $var;
}
add_shortcode( 'slider', 'slider_func' );
<?php

add_action( 'wp_ajax_submit_front_post_image', 'submit_front_post_image1' );
add_action("wp_ajax_nopriv_submit_front_post_image","submit_front_post_image1");

function submit_front_post_image1() {
    
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_POST['image'];

        $data = array(
            'post_type'     => 'service',
            'post_title'    => $title,
            'post_content'  => $description,
            'post_status'   => 'publish',
        );
        $query = wp_insert_post( $data );

        update_post_meta($query, '_thumbnail_id', $image);
        die();

}
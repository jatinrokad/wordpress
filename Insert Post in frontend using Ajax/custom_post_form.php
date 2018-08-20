<?php

/**
 *
Template Name:  Add Custom Post
 *
 */

get_header(); ?>

<div id="postbox">

	<form enctype="multipart/form-data">
		<p><label for="title">Title</label>
      <input type="text" id="title" value="" tabindex="1" size="20" name="title" />
    </p>
      <p><label>Description</label>
	       <textarea name="description" id="description"></textarea>
     </p>
     <?php
     $image_id = get_option( 'myprefix_image_id' );
    if( intval( $image_id ) > 0 ) {
        // Change with the image size you want to use
        $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
    } else {
        // Some default image
        $image = '<img id="myprefix-preview-image" src="" />';
    }
    echo $image; ?>
     <input type="hidden" name="myprefix_image_id" id="myprefix_image_id" value="<?php echo esc_attr( $image_id ); ?>" class="regular-text" />
  	 Image <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select a image', 'mytextdomain' ); ?>" id="myprefix_media_manager"/>
     <br><br>
      <input type="submit" value="Publish" tabindex="6" id="submit" name="submit" class="submit_front_post"/>

	 </form>

	 <div class="success-div"></div>
</div>

<script type="text/javascript">
	    jQuery(document).ready( function($) {

      jQuery('input#myprefix_media_manager').click(function(e) {

             e.preventDefault();
             var image_frame;
             if(image_frame){
                 image_frame.open();
             }
             // Define image_frame as wp.media object
             image_frame = wp.media({
                           title: 'Select Media',
                           multiple : false,
                           library : {
                                type : 'image',
                            }
                       });

                       image_frame.on('close',function() {
                          // On close, get selections and save to the hidden input
                          // plus other AJAX stuff to refresh the image preview
                          var selection =  image_frame.state().get('selection');
                          var gallery_ids = new Array();
                          var my_index = 0;
                          selection.each(function(attachment) {
                             gallery_ids[my_index] = attachment['id'];
                             my_index++;
                          });
                          var ids = gallery_ids.join(",");
                          jQuery('input#myprefix_image_id').val(ids);
                          Refresh_Image(ids);
                       });

                      image_frame.on('open',function() {
                        // On open, get the id from the hidden input
                        // and select the appropiate images in the media manager
                        var selection =  image_frame.state().get('selection');
                        ids = jQuery('input#myprefix_image_id').val().split(',');
                        ids.forEach(function(id) {
                          attachment = wp.media.attachment(id);
                          attachment.fetch();
                          selection.add( attachment ? [ attachment ] : [] );
                        });

                      });

                    image_frame.open();
     });


// Ajax request to refresh the image preview
function Refresh_Image(the_id){

        var data = {
            action: 'myprefix_get_image',
            id: the_id
        };

        jQuery.get(ajaxurl, data, function(response) {

            if(response.success === true) {
                jQuery('#myprefix-preview-image').replaceWith( response.data.image );
            }
        });
}

    jQuery(".submit_front_post").click(function(e){
      e.preventDefault();
        var title = jQuery("#title").val();
        var description= jQuery("#description").val();
        var image = jQuery("#myprefix_image_id").val();
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        
        jQuery.ajax({
          url: ajaxurl,
          type: 'POST',
          data: { 
            action: 'submit_front_post_image', title:title, description:description, image:image},
          success: function (response) {
                jQuery('.success-div').html("Form Submit Successfully");
          }
        });
    });

});
</script>
<?php  wp_enqueue_media(); ?>

<?php get_footer(); ?>
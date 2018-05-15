<?php 

/**
 * Template Name: Students Records
 *
 */

get_header();

get_template_part('partials/title_box'); 

?>
<div class="container">
	<div class="col-sm-3">
		<div class="wpb_widgetised_column wpb_content_element">
		<?php dynamic_sidebar( 'default' ); ?>
		</div>	
	</div>
	<div class="col-sm-9">

	<?php
	if ( have_posts() ) :
	        while ( have_posts() ) : the_post();
				the_content();
	        endwhile;
	    endif; 
?>
	<div class="row student">	
		<form>
			<label>Enter Student ID</label>
			<input type="text" name="student_id" id="student_id1" class="form-control student_id" onkeypress="return searchKeyPress(event);"><br>
			<input type="button" class="btn btn-default" name="submit" id="submit" value="Search">
		</form>
	</div>
	
	
<div class="student_table">

</div>
	</div>
</div>

 <script type="text/javascript">
	
	jQuery( document ).ready(function() {
    
		jQuery("#submit").click(function(e){
			e.preventDefault(); 
			var student_id = jQuery(".student_id").val();
			var ajax_url = "<?php echo admin_url( 'admin-ajax.php');?>";
			jQuery.ajax({
			 type : "post",
			 url : ajax_url,
			 data : {action: "search_user", student_id : student_id},
			 success: function(response) {
				jQuery(".student_table").html(response);
			 }
		 });
		});
});
	 function searchKeyPress(e)
{
    // look for window.event in case event isn't passed in
    e = e || window.event;
    if (e.keyCode == 13)
    {
        document.getElementById('submit').click();
        return false;
    }
    return true;
}
</script>

<?php get_footer();?>
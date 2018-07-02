<?php
/**
 * Template Name: Students Records
 *
 */
get_header();
?>

<div class="container">
	<div class="row">	
		<form>
			<label>Insert Student ID</label>
			<input type="text" name="student_id" id="student_id" class="form-control student_id"><br>
			<input type="button" name="submit" id="submit" value="Search">
		</form>
	</div>
</div>

<div class="student_table">

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

      jQuery('#student_id').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            jQuery('#submit').click();//Trigger search button click event
        }
    });

});
});
</script>

<?php get_footer(); ?>
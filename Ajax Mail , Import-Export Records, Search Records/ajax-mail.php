<form class="form-inline mapmail" id="sub" method="post">
                <div class="input-group">
                  <input type="email" name="email" class="form-control sendmail_email" placeholder="Enter Your Email-ID" id="email">
                </div>
                <input type="hidden" name="add" id="add" value="<?php echo $mapAddress ;?>">
                <input type="submit" class="btn btn-primary mapemail" name="mapemail" data-address="<?php echo $mapAddress ;?>" id="<?php echo $mapID ;?>" value="Send Mail">
</form>

<script>
 
 jQuery('.mapemail').click(function(e){
	
	  e.preventDefault();
	 //var address =  jQuery('#add').val();
	 var address = jQuery(this).attr("data-address");
	 var email =  jQuery('#email').val();
          jQuery.ajax({
           url: '<?php echo admin_url('admin-ajax.php'); ?>',
           type: "POST",
           cache: false,
           data:{ 
              action: 'send_email', 
              address: address,
              email: email,
                },
           success:function(res){
			   alert("Please check, Location Address Sent your Email-ID.");
			   }
                      }); 
});
</script>
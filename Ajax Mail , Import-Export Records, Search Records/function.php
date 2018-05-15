<?php

/*******  Register Custom Page ************/

function wpdocs_register_my_custom_menu_page1(){
    add_menu_page( 
        __( 'Custom Menu Title', 'textdomain' ),
        'Import Records',
        'manage_options',
        'custompage',
        'my_custom_menu_page1',
         'dashicons-welcome-widgets-menus',
        40
    ); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page1' );

function my_custom_menu_page1(){
    /*esc_html_e( 'Order ID = ', 'textdomain' );  
 	$order_id = $_GET['order_id'];
		print_r($order_id);
*/
	echo '<table width="600" border="1"><br>';
	echo '<h2>Student Records</h2><br>';
	echo '<form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">';
	echo '<tr>';
	echo '<td width="20%">Select file</td>';
	echo '<td width="80%"><input type="file" name="file" id="file" /></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>Submit</td>';
	echo '<td><input type="submit" name="btn_submit" /></td>';
	echo '</tr>';
	echo '</form>';
	echo '</table>';


$fh = fopen($_FILES['file']['tmp_name'], 'r+');
if ($fh) 
{
$lines = array();

while( ($row = fgetcsv($fh, 8192)) !== FALSE ) {
	unset($lines[0]);
	$lines[] = $row;
}
}
else {
    die("Please Insert File");
}
//var_dump($lines);

echo "Record Inserted Successfully";

foreach ($lines as $line) {
	// Create post object
$my_post = array(
  'post_title'    => $line[1],
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_type'	=> 'service'
);
 
// Insert the post into the database
$insert = wp_insert_post( $my_post );

update_post_meta( $insert, 'student_id', $line[0] );
update_post_meta( $insert, 'student_name', $line[1] );
update_post_meta( $insert, 'course_name', $line[2] );
update_post_meta( $insert, 'duration', $line[3] );
update_post_meta( $insert, 'date', $line[4] );
update_post_meta( $insert, 'branch', $line[5] );

}

}

//function for ajax call
add_action( 'wp_ajax_search_user', 'search_user_fun' );
add_action( 'wp_ajax_nopriv_search_user', 'search_user_fun' );

function search_user_fun(){
	$student_id = $_POST['student_id'];
	global $wpdb;
	$args = array(
	'meta_key'     => 'student_id',
	'meta_value'   => $student_id,
	'post_status'      => 'publish',
	'post_type'        => 'service',
	'orderby'      => 'login',
	'order'        => 'ASC'
 ); 
$query = get_posts( $args ); ?>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;    
}
</style>
</head>
<body>


<?php if(!empty($query)){?>
<div class="container">
	<div class="row">	
<div class="table-responsive search-res">

<h3>Student Search Results</h3>
<table class="table">
  <tr>
    <th>Student Id</th>
    <th>Name</th>
    <th>Course name</th>
	 <th>Duration</th>
	<th>Date</th>
	<th>Branch</th>  
  </tr>
  <?php 
  
  foreach ($query as $record) {
  	$id = $record->ID;?>
  <tr>
    <td><?php echo get_post_meta($id,'student_id',true);?></td>
    <td><?php echo get_post_meta($id,'student_name',true);?></td>
    <td><?php echo get_post_meta($id,'course_name',true);?></td>
	<td><?php echo get_post_meta($id,'duration',true);?></td>
	<td><?php echo get_post_meta($id,'date',true);?></td>
	<td><?php echo get_post_meta($id,'branch',true);?></td>
  </tr>
  <?php } ?>
</table>
</div>
</div>
</div>
<?php }else{
  	echo "<h3>NO record found..</h3>";
  }

	die();
}

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_city_taxonomy', 0 );
 
function create_city_taxonomy(){
    $catargsFood = array(
        'labels' => array(
            'label' => __( 'City Name' ),
            'rewrite' => array( 'slug' => 'city' ),
            'hierarchical' => true,
            ),
        'label' => "City Name",
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );
  
    register_taxonomy( 'map_location_categories_food', array('maplist'), $catargsFood );
}
function mlp_display_parts_change($displayParts){
    return array('search','map','message','list','paging');
}

add_filter( 'mlp_display_parts', 'mlp_display_parts_change' );


// Send Email


add_action( 'wp_ajax_send_email', 'send_email' );
add_action( 'wp_ajax_nopriv_send_email', 'send_email' );

function send_email(){

	  $address = $_POST['address'];
	  $email = $_POST['email'];
      	  $subject = "Bright Computer Education Address Location";
	  $email_body = "<h3>Thanks for Visit our website</h3>.<br>".
		"<h2>Address</h2>.<br>".
		 "$address. <br>";
          $to = $_POST['email'];
          $headers  = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $headers .= "From: $email \r\n";
          $headers .= "Reply-To: $email \r\n";
	  	  $mail = wp_mail($to,$subject,$email_body,$headers);
			if($mail){
			      echo "Email Sent Successfully";
		        }
}

/*
* Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page_export(){
    add_menu_page( 
        __( 'Custom Menu Title', 'textdomain' ),
        'Export Student Record',
        'manage_options',
        'custompage123',
        'my_custom_menu_page_export',
        plugins_url( 'myplugin/images/icon.png' ),
        73
    ); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page_export' );
 
/**
 * Display a custom menu page
 */
function my_custom_menu_page_export(){
 ?>
 <h1>Student Profiles</h1>
<form method="POST" action="#" style="display: inline; float: left;">
        <input type="submit" name="export" class="button-primary" value="Download Student Profile" />
    </form>
	<input type="button" class="button-primary" style="float: left; margin-left: 30px;" onclick="printDiv('printableArea')" value="Print Records" />

<?php 
$count_args  = array(
    'role'      => 'student_view',
    'fields'    => 'all_with_meta',
    'number'    => 999999      
);
$user_count_query = new WP_User_Query($count_args);
$user_count = $user_count_query->get_results();

// count the number of users found in the query
$total_users = $user_count ? count($user_count) : 1;

// grab the current page number and set to 1 if no page number is set
$page = isset($_GET['p']) ? $_GET['p'] : 1;

// how many users to show per page
$users_per_page = 20;

// calculate the total number of pages.
$total_pages = 1;
$offset = $users_per_page * ($page - 1);
$total_pages = ceil($total_users / $users_per_page);


// main user query
$args  = array(
    // search only for Authors role
    'role'      => 'student_view',
    // order results by display_name
    'orderby'   => 'display_name',
    // return all fields
    'fields'    => 'all_with_meta',
    'number'    => $users_per_page,
    'offset'    => $offset // skip the number of users that we have per page  
);

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($args);

// Get the results
$authors = $wp_user_query->get_results();
?>
<div id="printableArea">
<?php
// check to see if we have users
if (!empty($authors))
{
    echo '<div class="container student_profile">';
    // loop trough each author
    
    echo '<table border="1" style="font-size: 12px;">';
	    echo '<thead>';
	    echo '<tr>';
	 echo '<th>Profile Image</th>' ;
		    echo '<th>Student Name</th>' ;
		    echo '<th>Father Name</th>';
		    echo '<th>Email</th>';
		    echo '<th>Fees Date</th>';
		    echo '<th>Receipt Number</th>';
		    echo '<th>Fees Amount</th>';
		    echo '<th>Course Name</th>';
			echo '<th>Course Duration</th>';
		    echo '<th>Student Addres</th>';
		    echo '<th>City</th>';
		    echo '<th>Fees Received By</th>';
		    echo '<th>Total Attendance</th>';
			echo '<th>Admission Date</th>';
			echo '<th>Closing Date</th>';
			echo '<th>Report Cards</th>';
		echo '</tr>';
		echo '</thead>';
    foreach ($authors as $author)
    {
        $author_info = get_userdata($author->ID); 

        $author_id = $author_info->ID;

        ?>
         <tbody>

	        <tr>
				 <td>
<img class="profile-user-img img-responsive img-circle wpuser_profile_img" src="<?php the_field('profile_picture', 'user_'.$author_id) ;?>" width="50" height="60" alt="">
	        		</td> 
		        <td><?php the_field('student_name', 'user_'.$author_id);?></td>
		        <td><?php the_field('father_name', 'user_'.$author_id); ?></td>
		        <td><a href="mailto:<?php echo $author_info->user_email; ?>"><?php echo $author_info->user_email; ?></a></td>
		        <td><?php the_field('fees_date', 'user_'.$author_id); ?></td>
		        <td><?php the_field('receipt_number', 'user_'.$author_id); ?></td>
		        <td><?php the_field('fees_amount', 'user_'.$author_id); ?></td>
		        <td><?php the_field('course_name', 'user_'.$author_id); ?></td>
				<td><?php the_field('course_duration', 'user_'.$author_id); ?></td>
		        <td><?php the_field('student_address', 'user_'.$author_id); ?></td>
		        <td><?php the_field('student_city', 'user_'.$author_id); ?></td>
		        <td><?php the_field('fees_received_by', 'user_'.$author_id); ?></td>
		        <td>
					<?php 

	        		$arr = get_user_meta($author_id);

	        		$total = 0;
					$repeater = get_user_meta($author_id, 'student_attendance_box', true);

					if ($repeater) {
					  	for ($i=0; $i<$repeater; $i++) 
						  {			  	
					  		$meta_key = 'student_attendance_box_'.$i.'_attendance_status';
						    $sub_field_value = get_user_meta($author_id, $meta_key, true);

					    if ($sub_field_value == 'Present') {
					      $total++;
					    }
					  }
					}
					echo $total. " of ". $repeater ;

                      ?>
                          
		       	</td>
		<td><?php the_field('admission_date', 'user_'.$author_id); ?></td>
		<td><?php the_field('closing_date', 'user_'.$author_id); ?></td>
		<td><?php the_field('report_details', 'user_'.$author_id); ?></td>
		    </tr>
		</tbody>
    <?php 
    }
    echo '</table>';
    echo '</div>';
	?>
	<script type="text/javascript">
	function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
	}
</script>

	<?php
} else {
    echo 'No authors found';
} ?>
</div>
<?php
// grab the current query parameters
$query_string = $_SERVER['QUERY_STRING'];

// The $base variable stores the complete URL to our page, including the current page arg

// if in the admin, your base should be the admin URL + your page
$base = admin_url('admin.php') . '?' . remove_query_arg('p', $query_string) . '%_%';

// if on the front end, your base is the current page
//$base = get_permalink( get_the_ID() ) . '?' . remove_query_arg('p', $query_string) . '%_%';

echo paginate_links( array(
    'base' => $base, // the base URL, including query arg
    'format' => '&p=%#%', // this defines the query parameter that will be used, in this case "p"
    'prev_text' => __('&laquo; Previous'), // text for previous page
    'next_text' => __('Next &raquo;'), // text for next page
    'total' => $total_pages, // the total number of pages we have
    'current' => $page, // the current page
    'end_size' => 1,
    'mid_size' => 5,
));
	
}
// csv export of Student Profile
if(isset($_POST["export"]) ){
      download_csv();
}
  
function download_csv(){
    
      require_once 'parsecsv.lib.php';
        
      $write_csv = new parseCSV();
      $array=array();
                     
       global $wpdb;
		$args = array(
			'role' => 'student_view',
		 ); 
		$results = get_users( $args ); 

         if ( !empty($results)) {
    
            // Parse results to csv format
            foreach($results as $result){
            $id = $result->ID;
            //$name =$result->user_login;
            $student_name = get_user_meta($id,'student_name', true);
            $fathername = get_user_meta( $id, 'father_name', true);
            $useremail = $result->user_email;
            $fees_date = get_user_meta( $id, 'fees_date', true);
            $receipt_number = get_user_meta( $id, 'receipt_number', true);
            $fees_amount = get_user_meta( $id, 'fees_amount', true);
            $course_name = implode(get_user_meta( $id, 'course_name', true), ',');
	    	$student_address = get_user_meta( $id, 'student_address', true);
            $student_city = get_user_meta( $id, 'student_city', true);
            $fees_received_by = get_user_meta( $id, 'fees_received_by', true);
       		
				$arr = get_user_meta($id);

	        		$total = 0;
					$repeater = get_user_meta($id, 'student_attendance_box', true);

					if ($repeater) {
					  	for ($i=0; $i<$repeater; $i++) 
						  {			  	
					  		$meta_key = 'student_attendance_box_'.$i.'_attendance_status';
						    $sub_field_value = get_user_meta($id, $meta_key, true);

					    if ($sub_field_value == 'Present') {
					      $total++;
					    }
					  }
					}
					$res = $total. " of ". $repeater ;
				 
            $admission_date= get_user_meta( $id, 'admission_date', true);
            $closing_date= get_user_meta( $id, 'closing_date', true);
			//$report_details= the_field( $id, 'report_details', true);
				
                  array_push(
                        $array,
                        [ $student_name, $fathername, $useremail, $fees_date, $receipt_number, $fees_amount, $course_name, $student_address, $student_city, $fees_received_by, $res, $admission_date, $closing_date]
                    );
            }

             $write_csv->output('student_profile.csv', $array, array(
                  'Student Name',
                  'Fathername',
                  'Email',
                  'Fees Date',
                  'Receipt Number',
                  'Fees Amount',
                  'Course Name',
                  'Address',
                  'City',
                  'Fees Received By',
                  'Total Attendance',
				  'Admission Date',
				  'Closing Date'
              ), ','); die; 

        } 
}

/******      Hide User Fields *********/

function wpse_user_admin_script() {
    wp_register_style( 'wpse_admin_user_css', get_stylesheet_directory_uri() . '/assets/css/wpse_admin_user.css' );
    wp_enqueue_style( 'wpse_admin_user_css' );  
}
add_action( 'admin_enqueue_scripts', 'wpse_user_admin_script' );

?>
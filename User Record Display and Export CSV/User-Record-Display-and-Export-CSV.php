<?php

/**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page(){
    add_menu_page( 
        __( 'Custom Menu Title', 'textdomain' ),
        'Student Record Export',
        'manage_options',
        'custompage',
        'my_custom_menu_page',
        plugins_url( 'myplugin/images/icon.png' ),
        6
    ); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );
 
/******************     Display a custom menu page ******************************/

function my_custom_menu_page(){
 ?>
 
    <h1>Student Profiles</h1>
    <form method="POST" action="#">
        <input type="submit" name="export" class="button-primary" value="Download Student Profile" />
    </form>
<?php

/********************* Display User Records with pagination **************************/

$count_args  = array(
    'role'      => 'student_profile',
    'fields'    => 'all_with_meta',
    'number'    => 999999      
);
$user_count_query = new WP_User_Query($count_args);
$user_count = $user_count_query->get_results();

print_r($results);

// count the number of users found in the query
$total_users = $user_count ? count($user_count) : 1;

// grab the current page number and set to 1 if no page number is set
$page = isset($_GET['p']) ? $_GET['p'] : 1;

// how many users to show per page
$users_per_page = 5;

// calculate the total number of pages.
$total_pages = 1;
$offset = $users_per_page * ($page - 1);
$total_pages = ceil($total_users / $users_per_page);


// main user query
$args  = array(
    // search only for Authors role
    'role'      => 'student_profile',
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


// check to see if we have users
if (!empty($authors))
{
    echo '<div class="container student_profile1">';
    // loop trough each author
    
    echo '<table border="1">';
	    echo '<thead>';
	    echo '<tr>';
		    echo '<th>Student Name</th>' ;
		    echo '<th>Student Addres</th>';
		    echo '<th>Date</th>';
		    echo '<th>Total Attendance</th>';
		echo '</tr>';
		echo '</thead>';
    foreach ($authors as $author)
    {
        $author_info = get_userdata($author->ID); 

        $author_id = $author_info->ID;

        ?>
         <tbody>

	        <tr>
		        <td><?php the_field('student_name', 'user_'.$author_id);?></td>
		        <td><?php the_field('address', 'user_'.$author_id); ?></td>
		        <td><?php the_field('date', 'user_'.$author_id); ?></td>
		        <td>
		        	<?php 

              /*************   Count total Sub field Value of ACF Repeater   ************************/

	        		$arr = get_user_meta($author_id);

	        		$total = 0;
					    $repeater = get_user_meta($author_id, 'student_attendance', true);

    					if ($repeater) {
    					  	for ($i=0; $i<$repeater; $i++) 
    						  {			  	
    					  		$meta_key = 'student_attendance_'.$i.'_attendance_status';
    						    $sub_field_value = get_user_meta($author_id, $meta_key, true);

    					    if ($sub_field_value == 'yes') {
    					      $total++;
    					    }
    					  }
    					}
    					echo $total. " of ". $repeater ;
              ?>            		        	
		       	</td>
		    </tr>
		</tbody>
    <?php 
    }
    echo '</table>';
    echo '</div>';
} else {
    echo 'No authors found';
}

// grab the current query parameters
$query_string = $_SERVER['QUERY_STRING'];

// The $base variable stores the complete URL to our page, including the current page arg

// if in the admin, your base should be the admin URL + your page
$base = admin_url('your-page-path') . '?' . remove_query_arg('p', $query_string) . '%_%';

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

/*****************   CSV Export of Student Profile   *****************************/

if(isset($_POST["export"]) ){
      download_csv();
}
  
function download_csv(){
    
      require_once 'parsecsv.lib.php';
        
      $write_csv = new parseCSV();
      $array=array();
                     
      global $wpdb;
  		$args = array(
  			'role' => 'student_profile',
  		 ); 
		  $results = get_users( $args ); 

         if ( !empty($results)) {
    
            // Parse results to csv format
            foreach($results as $result){
            $id = $result->ID;
            $name =$result->user_login;
            $useremail = $result->user_email;
            $student_name = get_user_meta($id,'student_name', true);
            $student_address = get_user_meta( $id, 'address', true);

            /**************  Set Date Formate in CSV Export *************/

            $date  = get_user_meta( $id, 'date', true);
            $date = new DateTime($date);
      			$finalVal =  $date->format('j F, Y'); 
      			$output .= $finalVal;

            //$arr = get_user_meta($id);

	        	/**********   Count Total Sub fields of ACF Repeater *****************/

            $total = 0;
					  $repeater = get_user_meta($id, 'student_attendance', true);

  					if ($repeater) {
  					  	for ($i=0; $i<$repeater; $i++) 
  						  {			  	
  					  		$meta_key = 'student_attendance_'.$i.'_attendance_status';
  						    $sub_field_value = get_user_meta($id, $meta_key, true);

  					    if ($sub_field_value == 'yes') {
  					      $total++;
  					    }
  					  }
  					}
  					$res =  $total. " of " .$repeater;

                  array_push(
                        $array,
                        [ $name, $useremail, $student_name, $student_address, $res, $output]
                    );
            }

             $write_csv->output('csvname.csv', $array, array(
                  'Username',
                  'Email',
                  'Student Name',
                  'Address',
                  'Total Attendance',
                  'Date'
              ), ','); die; 
        } 
}
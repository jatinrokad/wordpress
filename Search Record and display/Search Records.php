<?php

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

<h2>Records</h2>

<?php if(!empty($query)){?>
<table style="width:100%">
  <tr>
    <th>Student Id</th>
    <th>Name</th>
    <th>Course name</th>
    <th>City</th>
    <th>Date</th>
  </tr>
  <?php 
  
  foreach ($query as $record) {
  	$id = $record->ID;?>
  <tr>
    <td><?php echo get_post_meta($id,'student_id',true);?></td>
    <td><?php echo get_post_meta($id,'student_name',true);?></td>
    <td><?php echo get_post_meta($id,'course_name',true);?></td>
    <td><?php echo get_post_meta($id,'city',true);?></td>
    <td><?php echo get_post_meta($id,'date',true);?></td>
  </tr>
  <?php } ?>
</table>
<?php }else{
  	echo "<h3>NO record found..</h3>";
  }

	die();
}
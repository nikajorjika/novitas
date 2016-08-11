<?php

/**
* Validate AJAX Call
*/
function validate_ajax_call() {
	$ajax_referer = false;
	$verify_nonce = false;

	if ( ! empty( $_POST['security'] ) ) {
		$hashed_security_key = $_POST['security'];
		$security_key = '895rt4jsscscr1523$#^@64';

		// Check referer
		if ( check_ajax_referer( $security_key, 'security' ) ) {
			$ajax_referer = true;
		}

		// Process call if page token time expires
		if ( wp_verify_nonce( $hashed_security_key, $security_key ) ) {
			$verify_nonce = true;
		}
	}
	// If both of them is valid return `true` or `false` otherwise
	return $ajax_referer && $verify_nonce ? true : false;
}

/**
* Contact form
*
* Both logged in and not logged in users can send this AJAX request
*/
add_action( 'wp_ajax_nopriv_contact_form', 'contact_form' );
add_action( 'wp_ajax_contact_form', 'contact_form' );

function contact_form() {
	if (validate_ajax_call()) {
		$email = $_POST['data']['email'];
		$subject = $_POST['data']['subject'];
		$message = $_POST['data']['msg'];

		$messageToSend = 'E-mail: ' . $email . "\r\n" . 'Message: ' . $message;

		$headers = 'From: example.com <contact@example.com>';

		wp_mail ( 'contact@example.com', $subject, $messageToSend, $headers );
		die();
	}
}

/**
* Contact form
*
* Both logged in and not logged in users can send this AJAX request
*/
add_action( 'wp_ajax_nopriv_get_by_term', 'get_by_term' );
add_action( 'wp_ajax_get_by_term', 'get_by_term' );

function get_by_term() {
    $data = $_POST['data'];
    if(!isset($data['term']) || $data['term'] == ''){
        $args = array(
            'post_type'      => 'medicament',
            'posts_per_page' => '10',
        );
    }else{
        $args = array(
            'post_type'      => 'medicament',
            'posts_per_page' => '10',
            'tax_query' => array(
                array(
                    'taxonomy' => 'med-type',
                    'field' => 'id',
                    'terms' => array($data['term'])
                )
            )
        );
    }
    $meds_arr = new WP_Query($args);
    $meds_arr = $meds_arr -> posts;
    $response_array = array();
    foreach($meds_arr as $med){
        //create new instance of an object
        $med_obj = new stdClass();
        $not_available = new stdClass();
        $not_available->name = __('არ არის ხელმისაწვდომი', 'hbtech');
        $not_available->slug = '#';

        $producer = !empty(wp_get_post_terms( $med->ID, 'producer')) ? wp_get_post_terms( $med->ID, 'producer')[0]: $not_available;
        $country  = !empty(wp_get_post_terms( $med->ID, 'country')) ? wp_get_post_terms( $med->ID, 'country')[0]: $not_available;
        $group    = !empty(wp_get_post_terms( $med->ID, 'group')) ? wp_get_post_terms( $med->ID, 'group')[0]: $not_available;
        $generic  = !empty(wp_get_post_terms( $med->ID, 'generic')) ? wp_get_post_terms( $med->ID, 'generic')[0]: $not_available;

        $blog_url = get_home_url() . '/medicaments';
        $content =
            '<span>'. __('მწარმოებელი:', 'hbtech').'</span>
            <a href="'.  $blog_url.'?producer='.$producer->slug .'"><span>'.  $producer->name .'</span></a>
            <br>
            <span>'.__('მწარმოებელი ქვეყანა:', 'hbtech'). '</span>
            <a href="'. $blog_url.'?country='.$country->slug .'"><span>'. $country->name .'</span></a>
            <br>
            <span>'.__('ფარმაცეფტული ჯგუფი:', 'hbtech') .'</span>
            <a href="'. $blog_url.'?group='.$group->slug .'"><span>'. $group ->name .'</span></a>
            <br>
            <span>'. __('ჯენერიკული დასახელება:', 'hbtech') .'</span>
            <a href="'. $blog_url.'?generic='.$generic->slug .'"><span>'. $generic->name .'</span></a>';
        //start building object as we desire to send from here to front end
        $med_obj->id  = $med->ID;
        $med_obj->title = $med->post_title;
//        $med_obj->content = get_field('content', $med, true);
        $med_obj->content = $content;
        $med_obj->image = get_field('image', $med)['sizes']['large'];
        $med_obj->url = get_permalink($med);
        //push new Object to array
        $response_array[] = $med_obj;
    }

    wp_send_json($response_array);
}
/**
 * search form
 *
 * Both logged in and not logged in users can send this AJAX request
 */
add_action( 'wp_ajax_nopriv_get_search_items', 'get_search_items' );
add_action( 'wp_ajax_get_search_items', 'get_search_items' );

function get_search_items() {
    $query = sanitize_text_field($_POST['data']['q']);
        $args = array(
            'post_type'      => 'medicament',
            'posts_per_page' => '10',
            's' => $query
        );
    $meds_arr = new WP_Query($args);
    $meds_arr = $meds_arr -> posts;
    $response_array = array();

    foreach($meds_arr as $med){
        $response_array[] = array(
            'title' =>$med->post_title,
            'url' => get_permalink($med)
        );
    }
    wp_send_json($response_array);
}

/**
* Facebook login form
*
* Both logged in and not logged in users can send this AJAX request
*/
add_action( 'wp_ajax_nopriv_ka_fb_connector', 'ka_fb_connector' );
add_action( 'wp_ajax_ka_fb_connector', 'ka_fb_connector' );

function ka_fb_connector() {
	require_once locate_template('inc/facebook-connector.class.php');

  if ( class_exists( 'Kavela\FacebookConnector\FacebookConnector' ) ) {
    $security_key = 'nsvuiozyu48';
    $logged_in = false;
    $reg_results = array();
    $link = get_site_url() . '/#share';
    $access_token = isset( $_POST['data']['fb_access_token'] ) ? $_POST['data']['fb_access_token'] : '';
	$fb_connector = new Kavela\FacebookConnector\FacebookConnector('269900126733148', 'e58e93fe1e425905a5d784e7a487c644', $access_token);

    // Check AJAX referer and verify nonce
    if ( $fb_connector->validateAjaxCall( $security_key ) ) {
      // Check if user already logged in
      if ( ! is_user_logged_in() ) {
      	// If user through Facebook send us access token
        if ( ! empty( $access_token ) ) {
          $logged_in = $fb_connector->login();
          // If user is not regitered yet, go to registration
          if ( ! $logged_in ) {
            // Exclude default fields which is not neccessary in registration process
            $exclude_fields = array( 'login', 'pass', 'confirm_pass' );
            // Check if email field is not empty. If empty exclude it
            if ( empty( $_POST['data']['fb_email'] ) ) {
              $exclude_fields[] = 'email';
            }
            // Get registration results
            $reg_results = $fb_connector->registration( $exclude_fields );
            // If new user account created successfully
            if ( isset( $reg_results['reg_status'] ) && true === $reg_results['reg_status'] ) {
				// Update user meta data. You can check update result
				$user_meta_fb_id = $fb_connector->updateUserMeta( 'fb_id' );
				$user_meta_fb_link = $fb_connector->updateUserMeta( 'fb_link' );
				$logged_in = $fb_connector->login();
            }
          }
          else { // If logged in
            $logged_in = true;
          }
        }
      }
      else { // User is logged in
      	$logged_in = true;
      }
    }
  }
  wp_send_json( array( 'login' => $logged_in, 'reg' => $reg_results, 'link' => $link ) );
  exit();
}
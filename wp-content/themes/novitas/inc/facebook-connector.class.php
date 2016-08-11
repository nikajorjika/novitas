<?php
namespace Kavela\FacebookConnector;

/**
* Facebook login and registration handler
* @version 1.0.1 - 14.01.16
*/

class FacebookConnector {
  private $post_data; // Global $_POST array
  private $reg_results; // Contains validation statuses and messages about registration fields
  private $user_id; // Newly-created user ID
  private $app_id;
  private $app_secret;
  private $access_token;

  public function __construct($app_id, $app_secret, $access_token) {
    $this->post_data = $_POST;
	$this->app_id = $app_id;
	$this->app_secret = $app_secret;
	$this->access_token = $access_token;
  }

  /**
  * @param string $key - special string to validate referer and verify nonce
  * @return true|false - if referer is valid and nonce is verified or false otherwise
  */
  public function validateAjaxCall($key) {
    $valid_referer = $this->checkReferer($key);
    $valid_nonce = $this->verifyNonce($key);

    if ($valid_referer && $valid_nonce) {
      return true;
    }
    return false;
  }

  /**
  * @return true|false - true on success or false on failure
  */
  private function checkReferer($key) {
    // Second argument is global $_REQUEST array key which returns referer's security key to compare
    return check_ajax_referer($key, 'security');
  }

  /**
  * @return true|false - true on success or false on failure
  */
  private function verifyNonce($key) {
    return wp_verify_nonce($this->post_data['security'], $key);
  }

  /**
  * @return true|false - true if user logged in or false otherwise
  */
  public function login() {
    // Facebook PHP SDK gets the user data
    $user_data = $this->getUserDataByAccessToken($this->app_id, $this->app_secret, $this->access_token);

    if (! empty($user_data)) {
      $this->post_data['data']['email'] = $user_data['email'];
      $this->post_data['data']['firstname'] = $user_data['first_name'];
      $this->post_data['data']['lastname'] = $user_data['last_name'];
      $this->post_data['data']['fb_id'] = $user_data['id'];

      $email = $this->post_data['data']['email'];

      if (! empty($email)) {
        return $this->tryToLoginByEmail($email);
      }
      else {
        return $this->tryToLoginByFacebookId($this->post_data['data']['fb_id']);
      }
    }
  }

  /**
  * @param string $email - user email retured from Facebook
  * @return true|false - true on success or false on failure
  */
  private function tryToLoginByEmail($email) {
    if (is_email($email)) {
      $user = get_user_by('email', $email);
      // If user exists
      if ($user->data) {
		wp_set_current_user($user->data->ID, $user->data->user_login);
        wp_set_auth_cookie($user->data->ID);
        return true;
      }
    }
    return false;
  }

  /**
  * @param numeric $fb_id - user ID retured from Facebook
  * @return true|false - true on success or false on failure
  */
  private function tryToLoginByFacebookId($fb_id) {
    if (! empty($fb_id)) {
      // If Facebook did not return user email address, query for the user with fb_id meta key
      $user_query = new \WP_User_Query(
        array(
          'meta_key' => 'fb_id',
          'meta_value' => $fb_id,
          'fields' => 'all_with_meta'
          )
        );
      // If query returns any results
      if (! empty($user_query->results)) {
        // Here $user_query->results gives associative array of matched Wordpress user objects
        // Keys are user IDs. We don't yet know ID, so we just do array_shift to take the first element of the array
        $user = array_shift($user_query->results);

        if ($user->data) {
          wp_set_current_user($user->data->ID, $user->data->user_login);
          wp_set_auth_cookie($user->data->ID);
          return true;
        }
      }
    }
    return false;
  }

  /**
  * @param array $exclude_fields - exclude default fields which is not neccessary in registration process
  * @param boolean $login - login after registration if gets true. By default is false
  * @return true|false - true on success or false otherwise
  */
  public function registration($exclude_fields = array()) {
    // Check registration fields
    $this->checkRegFields($exclude_fields);

    // If registration fields is valid we can register new user
    if ($this->regFieldsIsValid()) {
      $this->reg_results = $this->registerNewUser($exclude_fields);
    }
    return $this->reg_results;
  }

  /**
  * @param array $exclude_fields - exclude default fields which is not neccessary in registration process
  * @return null
  */
  private function checkRegFields($exclude_fields) {
    // Email
    $email = trim($this->post_data['data']['email']);

    // Check if excluded
    if (! in_array('email', $exclude_fields)) {
      if ($this->validateEmail($email)) {
        // Check if that email address is already used
        if (false == email_exists($email)) {
          $this->regResults(true, array('email' => $email));
        }
        else {
          $msg = 'Sorry, that email address is already used';
          $this->regResults(false, array('email' => $email), $msg);
        }
      }
      else {
        $msg = 'Please, enter valid email address';
        $this->regResults(false, array('email' => $email), $msg);
      }
    }

    // Firstname
    $firstname = trim($this->post_data['data']['firstname']);

    if ($this->validateFirstname($firstname)) {
      $this->regResults(true, array('firstname' => $firstname));
    }
    else {
      $msg = 'Please, enter valid firstname';
      $this->regResults(false, array('firstname' => $firstname), $msg);
    }

    // Lastname
    $lastname = trim($this->post_data['data']['lastname']);

    if ($this->validateLastname($lastname)) {
      $this->regResults(true, array('lastname' => $lastname));
    }
    else {
      $msg = 'Please, enter valid lastname';
      $this->regResults(false, array('lastname' => $lastname), $msg);
    }

    // Check if excluded
    if (! in_array('pass', $exclude_fields)) {
      // Password
      $pass = trim($this->post_data['data']['pass']);

      if ($this->validatePassword($pass)) {
        // Check if excluded
        if (! in_array('confirm_pass', $exclude_fields)) {
          $confirm_pass = trim($this->post_data['data']['confirm_pass']);
          // Confirm password
          if ($this->confirmPassword($confirm_pass, $pass)) {
            $this->regResults(true, array('pass' => $pass));
          }
          else {
            $msg = 'Password mismatch. Please, repeat correct password';
            $this->regResults(false, array('pass' => $pass), $msg);
          }
        }
        else {
          $this->regResults(true, array('pass' => $pass));
        }
      }
      else {
        $msg = 'Please, enter valid password. Password must contain at least 6 character';
        $this->regResults(false, array('pass' => $pass), $msg);
      }
    }

    // Check if excluded
    if (! in_array('login', $exclude_fields)) {
      // Username
      $login = trim($this->post_data['data']['login']);

      if ($this->validateLogin($login)) {
        // Check if login name already exists
        if (username_exists($login) == false) {
          // 'user_login' should be only latin letters and some punctuation symbols
          // 'sanitize_user' replaces 'UTF-8' symbols which could be return 'null' value
          if (sanitize_user($login, true) != null) {
            $this->regResults(true, array('login' => $login));
          }
          else {
            $msg = 'Login name must contain alphanumeric symbols and _, space, ., -, *, @';
            $this->regResults(false, array('login' => $login), $msg);
          }
        }
        else {
          $msg = 'Sorry, username is already taken by another user';
          $this->regResults(false, array('login' => $login), $msg);
        }
      }
    }
  }

  /**
  * @param string $email - user email address
  * @return true|false - true if valid or false otherwise
  */
  private function validateEmail($email) {
    if (is_email($email)) {
      return true;
    }
    return false;
  }

  /**
  * @param string $firstname - user firstname
  * @return true|false - true if valid or false otherwise
  */
  private function validateFirstname($firstname) {
    if (mb_strlen(trim($firstname)) > 0) {
      return true;
    }
    return false;
  }

  /**
  * @param string $lastname - user lastname
  * @return true|false - true if valid or false otherwise
  */
  private function validateLastname($lastname) {
    if (mb_strlen(trim($lastname)) > 0) {
      return true;
    }
    return false;
  }

  /**
  * @param string $pass - user password
  * @return true|false - true if valid or false otherwise
  */
  private function validatePassword($pass) {
    // Password should contain 6 character
    if (mb_strlen(trim($pass)) >= 6) {
      return true;
    }
    return false;
  }

  /**
  * @param string $confirm_pass - user password
  * @param string $pass - user password
  * @return true|false - true if match or false otherwise
  */
  private function confirmPassword($confirm_pass, $pass) {
    if ($confirm_pass == $pass) {
      return true;
    }
    return false;
  }

  /**
  * @param string $login - username
  * @return true|false - true on success or false otherwise
  */
  private function validateLogin($login) {
    // Username must be less then or equal to 60 symbols
    if (mb_strlen(trim($login)) <= 60) {
      return true;
    }
    return false;
  }

  /**
  * @param boolean $valid - defines if field is valid
  * @param array $field - array($field_key => $field_val)
  * @param string $msg - status message
  * @return array - registration results
  */
  private function regResults($valid, $field, $msg = '') {
    $this->reg_results[] = array(
        'valid' => $valid,
        'field' => $field,
        'msg' => __($msg, 'novitas')
        );
    return $this->reg_results;
  }

  /**
  * @return true|false - true if all fields is valid or false otherwise
  */
  private function regFieldsIsValid() {
    $valid = true;
    $pass_key = null;

    if (is_array($this->reg_results)) {
      foreach ($this->reg_results as $key => $field_data) {
        if ('pass' == key($field_data['field'])) {
          $pass_key = $key;
        }
        if ($field_data['valid'] == false) {
          $valid = false;
        }
      }
    }
    else {
      $valid = false;
    }

    if (isset($pass_key) && false == $valid) {
      // We do not want to return any password
      unset($this->reg_results[$pass_key]['field']['pass']);
    }
    return $valid;
  }

  /**
  * @param array $exclude_fields - exclude default fields which is not neccessary in registration process
  * @return array - registration status and message
  */
  private function registerNewUser($exclude_fields) {
    if (is_array($this->reg_results)) {
      foreach ($this->reg_results as $field_data) {
        if ('firstname' == key($field_data['field'])) {
          $user_data['first_name'] = esc_attr(trim($field_data['field']['firstname']));
          $user_data['display_name'] = esc_attr(trim($field_data['field']['firstname']));
          $user_data['user_nicename'] = esc_attr(trim($field_data['field']['firstname']));
          $user_data['nickname'] = esc_attr(trim($field_data['field']['firstname']));
        }
        if ('lastname' == key($field_data['field'])) {
          $user_data['last_name'] = esc_attr(trim($field_data['field']['lastname']));
        }
        if ('pass' == key($field_data['field'])) {
          // Check if excluded
          if (! in_array('pass', $exclude_fields)) {
            $user_data['user_pass'] = trim($field_data['field']['pass']);
          }
        }
        if ('login' == key($field_data['field'])) {
          // Check if excluded
          if (! in_array('login', $exclude_fields)) {
            $user_data['user_login'] = trim($field_data['field']['login']);
          }
        }
        // Email can be empty in registration process but after registration user can not update profile if email field is empty
        if ('email' == key($field_data['field'])) {
          // Check if excluded
          if (! in_array('email', $exclude_fields)) {
            $user_data['user_email'] = trim($field_data['field']['email']);
          }
        }
      }
      // Username is required. Set if is not defined
      $user_data['user_login'] = isset($user_data['user_login']) ? $user_data['user_login'] : uniqid('user_');
      // Create new user account. Return newly-created user ID
      $insert_user_result = wp_insert_user($user_data);
      // If user account created
      if(is_wp_error($insert_user_result)) {
        // echo $insert_user_result->get_error_message();
        return array(
          'reg_status' => false,
          'msg' => __('There are some validation problems. Please, try again', 'novitas')
          );
      }
      elseif ($insert_user_result > 0) {
        // User ID
        $this->user_id = $insert_user_result;
        return array(
          'reg_status' => true,
          'msg' => __('Your new account created successfully', 'novitas')
          );
      }
    }
    return array(
      'reg_status' => false,
      'msg' => __('For registration we need correct data. Please, try again', 'novitas')
      );
  }

  /**
  * @param string $meta_key - user meta field key
  * @param string $meta_value - user meta field value
  * @return int|true|false - Meta ID if the key didn't exist; true on successful update;
  *         false on failure or if $meta_value is the same as the existing meta value in the database
  */
  public function updateUserMeta($meta_key) {
    switch ($meta_key) {
      case 'email':
        $meta_value = $this->post_data['data']['email'];
        break;
      case 'firstname':
        $meta_value = $this->post_data['data']['firstname'];
        break;
      case 'lastname':
        $meta_value = $this->post_data['data']['lastname'];
        break;
      case 'fb_id':
        $meta_value = $this->post_data['data']['fb_id'];
        break;
      default:
        $meta_value = $this->post_data['data'][$meta_key];
    }
    $result = update_user_meta($this->user_id, $meta_key, $meta_value);
    return $result;
  }

  /**
  * Facebook PHP SDK - Retrieve user profile via the Graph API
  * @link: https://developers.facebook.com/docs/php/howto/example_retrieve_user_profile
  * @return false|object - false if exceptions or returns requested user data
  */
  private function getUserDataByAccessToken($app_id, $app_secret, $access_token) {
    $path = join(DIRECTORY_SEPARATOR, array('facebook-php-sdk-v4', 'src', 'Facebook', 'autoload.php'));
    $full_path = '..' . DIRECTORY_SEPARATOR . $path;
    
    require_once $full_path;

    $fb = new \Facebook\Facebook([
      'app_id' => $app_id,
      'app_secret' => $app_secret,
      'default_graph_version' => 'v2.2',
      ]);

    try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,first_name,last_name,name,email,picture', $access_token);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // echo 'Graph returned an error: ' . $e->getMessage();
      // exit;
      return false;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // echo 'Facebook SDK returned an error: ' . $e->getMessage();
      // exit;
      return false;
    }

    $user = $response->getGraphUser();

    return $user;
    exit;
  }
}

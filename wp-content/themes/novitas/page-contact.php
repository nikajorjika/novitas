<?php
/* Template Name: Contact */

if(isset($_POST['submitted'])) {
    if(trim($_POST['contactName']) === '') {
        $nameError = 'Please enter your name.';
        $hasError = true;
    } else {
        $name = trim($_POST['contactName']);
    }

    if(trim($_POST['email']) === '')  {
        $emailError = 'Please enter your email address.';
        $hasError = true;
    } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
        $emailError = 'You entered an invalid email address.';
        $hasError = true;
    } else {
        $email = trim($_POST['email']);
    }

    if(trim($_POST['description']) === '') {
        $descriptionError = 'Please enter a message.';
        $hasError = true;
    } else {
        if(function_exists('stripslashes')) {
            $description = stripslashes(trim($_POST['description']));
        } else {
            $description = trim($_POST['description']);
        }
    }

    if(!isset($hasError)) {
        $emailTo = get_option('tz_email');
        if (!isset($emailTo) || ($emailTo == '') ){
            $emailTo = get_option('admin_email');
        }
        if (!isset($emailTo) || ($emailTo == '') ){
            $emailTo = sanitize_email($_POST['to']);
        }
        $subject = '[PHP Snippets] From '.$name;
        $body = "Name: $name \n\nEmail: $email \n\ndescription: $description";
        $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

        print_r(wp_mail($emailTo, $subject, $body, $headers));
        $emailSent = true;
        die;
    }

}
?>
<?php	get_header(); ?>

<div class="contact-page-before">
    <div class="contact-container">
        <div class="header-static">
            <div class="static-header-container">
                <h1>კონტაქტი</h1>
            </div>
        </div>

        <div class="contact-info-div">
            <ul class="contact-info-ul">
                <li>
                    <div class="contact-info-icon">
                        <i class="fa fa-location-arrow" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info-text">
                        <?php echo get_field('address'); ?>
                    </div>
                </li>

                <li>
                    <div class="contact-info-icon">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info-text">
                        <?php echo get_field('phone'); ?>
                    </div>
                </li>

                <li>
                    <div class="contact-info-icon">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </div>
                    <div class="contact-info-text">
                        <?php echo get_field('email'); ?>
                    </div>
                </li>
            </ul>
        </div>
  
        <div class="contact-map-form-container">
            <div id="map" data-lat="<?php echo get_field('map')['lat']?>" data-long="<?php echo get_field('map')['lng']?>">
            </div>
            <div class="contact-form-container">
                <form action="<?php the_permalink();?>" class="contact-form" method="post">
                    <input type="text" name="contactName" placeholder="<?php _e('სახელი','hbtech');?>" class="form-item">
                    <input type="text" name="email" placeholder="<?php _e('ელ-ფოსტა','hbtech');?>" class="form-item">
                    <textarea name="comment" placeholder="<?php _e('კომენტარი','hbtech');?>" class="form-item"></textarea>
                    <input type="submit" name="submit" value="<?php _e('გაგზავნა','hbtech');?>" class="form-item">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseFloat(jQuery('#map').attr('data-lat')), lng: parseFloat(jQuery('#map').attr('data-long'))},
            zoom: 16,
            scrollwheel: false,
            styles:[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]
        });

        var marker = new google.maps.Marker({
            position: {lat: parseFloat(jQuery('#map').attr('data-lat')), lng: parseFloat(jQuery('#map').attr('data-long'))},
            map: map,
            title: 'Novitas'
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_MSQT6AnnZaajkR_ZY2_Yw6eYjHXaGmw&&callback=initMap"
        async defer></script>
<style>
    body{
        background: white;
    }
</style>
<?php get_footer(); ?>


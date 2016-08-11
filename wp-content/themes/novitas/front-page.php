<?php
/* Template Name: front-page */
?>
<?php get_header(); ?>
<?php
$args = array(
    'post_type' => 'news',
    'posts_per_page' => '5'
);
$news_array = new WP_Query($args);
$news_array = $news_array->posts;

$args = array(
    'post_type' => 'farmacy',
    'posts_per_page' => -1
);
$farmacies_posts = new WP_Query($args);
$farmacies = $farmacies_posts->posts;

?>
<section class="medicament-search">
    <div class="medicament-search-box">
        <div class="med-search-form-container">
            <form action="<?php bloginfo('url'); ?>/medicaments/" id="med-search-form">
                <input type="text" name="q" value="<?php echo $search_keyword;?>" id="med-search-input" autocomplete="off" placeholder="<?php echo _e('მედიკამენტის ძებნა', 'hbtech'); ?>">
                <i class="fa fa-search"></i>

                <div class="suggestions-container">
                    <ul>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="slider-stores">
    <div class="stores mCustomScrollbar">
        <div class="header-stores-container">
            <h1 class="header-stores"><?php _e('აფთიაქების ქსელი','hbtech');?></h1>
        </div>
        <?php foreach($farmacies as $single):?>
        <div class="store-item" id="<?php echo $single->ID;?>">
            <img src="<?php echo get_field('logo', $single)['url']; ?>" alt="LOGO">
            <h3><?php echo $single->post_title;?></h3>
            <p class="dotdotdot"><?php echo get_field('description',$single);?></p>
            <button><i class="fa fa-map-marker"
                       data-lat="<?php echo get_field('location',$single)['lat']?>"
                       data-long="<?php echo get_field('location',$single)['lng']?>"
                ></i></button>
        </div>
        <?php endforeach;?>
    </div>
    <div class="map-dynamic-container" data-current="">
        <div class="map-dynamic" id="farmacies-map">

        </div>
        <span class="close-map">

        </span>
        <script>
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('farmacies-map'), {
                    center: {lat: 41.72289932945416, lng: 44.784650802612305},
                    zoom: 14,
                    scrollwheel: false,
                    styles:[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]
                });
                (function($){
                    var items = $('.store-item');

                    console.log(items);
                    items.each(function (index, value) {
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat($(value).find('button i').attr('data-lat')), lng: parseFloat($(value).find('button i').attr('data-long'))},
                            map: map,
                            title: $(value).find('h3').text()
                        });
                    });
                    $('.store-item').on('click', function () {
                        var lat = $(this).find('i').attr('data-lat');
                        var long = $(this).find('i').attr('data-long');
                        if($('.map-dynamic-container').hasClass('active')){
                            map.setCenter({
                                lat : parseFloat(lat),
                                lng : parseFloat(long)
                            });
                        }else{
                            $('.map-dynamic-container').addClass('active');
                            map.setCenter({
                                lat : parseFloat(lat),
                                lng : parseFloat(long)
                            });
                        }

                    });
                    $('.close-map').on('click', function () {
                        if($('.map-dynamic-container').hasClass('active')){
                            $('.map-dynamic-container').removeClass('active')
                        }
                    });
                })(jQuery)

            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_MSQT6AnnZaajkR_ZY2_Yw6eYjHXaGmw&&callback=initMap"
                async defer></script>
    </div>
    <div class="flexslider">
        <ul class="slides">
            <?php foreach(get_field('slider_images') as $image):?>
                <li>
                    <div class="slide-image" style="
                        background-image: url('<?php echo $image['url'];?>');
                        background-size: cover;
                        background-position: center center;
                    "></div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</section>
<section class="main-content">
    <div class="header-news-container">
        <h1 class="header-news"><?php _e('სიახლეები','hbtech');?></h1>
    </div>
    <div class="news-content front-page-news-content wrapper">
        <?php foreach($news_array as $news):?>
            <div class="item">
                <div class="item-image-container"
                style="
                    background-image: url(<?php echo get_field('image',$news)['url'];?>);
                    background-size:cover;
                    background-position: center center;
                ">
                </div>
                <div class="item-content-body">
                    <div class="item-content-container">
                        <?php echo str_replace('\n','',get_field('content', $news, true)); ?>
                    </div>
                    <div class="item-content-viewmore">
                        <a href="<?php echo get_permalink($news);?>">
                            <?php _e('ვრცლად','hbtech');?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="news-all">
        <a href="/novitas/recent-news">ყველას ნახვა</a>
    </div>
    <style>
        .news-content .item .item-image-container{
            background-image: url('http://placekitten.com/g/1903/698');
            background-size: cover;
            background-position: center center;
            background-repeat:no-repeat;
        }
    </style>
</section>

<?php get_footer(); ?>

<?php
/*
Template Name: News
*/
get_header();
?>
<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type'      => 'news',
    'posts_per_page' => '9',
    'paged'          => $paged
);
$wp_query = new WP_Query($args);
?>
<div class="news-main-container">
    <section class="main-content">
        <div class="header-static">
            <div class="static-header-container">
                <h1><?php echo $post->post_title; ?></h1>
            </div>
        </div>
        <div class="news-content wrapper">
            <?php foreach($wp_query->posts as $news): ?>
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

            <?php if (function_exists("pagination")) {
                pagination($wp_query->max_num_pages);
            } ?>
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
</div>

<?php get_footer(); ?>
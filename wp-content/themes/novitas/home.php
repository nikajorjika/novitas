<?php
/*
Template Name: News
*/
get_header();
?>
<?php
$paged = ( get_query_var( 'paginate' ) ) ? get_query_var( 'paginate' ) : 1;
$args = array(
    'post_type' => 'post_news',
    'posts_per_page' => '1',
    'paged' => $paged
);
$wp_query = new WP_Query($args);
?>
<div class="news-main-container">
    <section class="main-content">
        <div class="header-static wrapper">
            <div class="static-header-container">
                <h1><?php echo $post->post_title; ?></h1>
            </div>
        </div>
        <div class="news-container">
            <?php foreach($wp_query->posts as $news): ?>
                <div class="news">
                    <div class="news-image" style="
                        background-image: url(<?php echo get_field('image', $news)['url'];?>);
                        background-size: cover;
                        background-position: center center;
                        background-repeat:no-repeat;
                        "></div>
                    <div class="news-content-wrapper">
                        <div class="news-header">
                            <h1><?php echo $news->post_title;?></h1>
                        </div>
                        <div class="news-content">
                            <?php echo get_field('content', $news, true); ?>
                        </div>
                        <div class="news-more">
                            <a href="<?php echo get_permalink($news);?>">
                                <button><?php _e('ვრცლად','hbtech');?></button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <?php if (function_exists("pagination")) {
                pagination($wp_query->max_num_pages);
            } ?>

        </div>
    </section>
</div>

<?php get_footer(); ?>

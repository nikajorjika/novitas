<?php
/* Template Name: Search Page */
?>
<?php get_header();?>

<?php

    if(!isset($_GET['submitted'])){
        wp_redirect(get_home_url());
        die();
    }
    $q = sanitize_text_field (trim($_GET['q']));
?>
    <?php $query = new WP_Query( array( 's' => $q, 'posts_per_page' => 10  ));?>
    <?php $result = $query->posts; ?>
    <div class="search-results-page">
        <section class="wrapper search-results">
            <div class="search-result-text">
                <h1><?php _e('ძებნის შედეგები','hbtech');?> <span style="color: red;"><?php echo $q;?></span> <?php _e('-სთვის','hbtech');?></h1>
            </div>
            <?php foreach($result as $item):?>
                <div class="search-item">
                    <h1><a href="<?php echo get_permalink($item)?>"><?php echo $item->post_title;?></a></h1>
                    <p><?php echo substr(get_field('content',$item),0,500);?>...</p>
                </div>
            <?php  endforeach;?>
        </section>
    </div>
<?php get_footer(); ?>
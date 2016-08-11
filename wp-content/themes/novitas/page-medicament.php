<?php
/*
Template Name: Medicaments
*/
?>
<?php get_header(); ?>

<?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    if(isset($_GET['submitted'])){
        $search_keyword = $_GET['q'];
    }
    $args = array(
        'post_type'      => 'medicament',
        'posts_per_page' => '6',
        's' => $search_keyword,
        'paged' => $paged
    );
    if(isset($_GET['producer'])){
        $args = array(
            'post_type'      => 'medicament',
            'posts_per_page' => '10',
            'tax_query' => array(
                array(
                    'taxonomy' => 'producer',
                    'field' => 'slug',
                    'terms' => array(sanitize_text_field($_GET['producer'])
                    )
                )
            ),
            'paged' => $paged
        );
    }
    if(isset($_GET['country'])){
        $args = array(
            'post_type'      => 'medicament',
            'posts_per_page' => '10',
            'tax_query' => array(
                array(
                    'taxonomy' => 'country',
                    'field' => 'slug',
                    'terms' => array(sanitize_text_field($_GET['country'])
                    )
                )
            ),
            'paged' => $paged
        );
    }
    if(isset($_GET['group'])){
        $args = array(
            'post_type'      => 'medicament',
            'posts_per_page' => '10',
            'tax_query' => array(
                array(
                    'taxonomy' => 'group',
                    'field' => 'slug',
                    'terms' => array(sanitize_text_field($_GET['group'])
                    )
                )
            ),
            'paged' => $paged
        );
    }
    if(isset($_GET['generic'])){
        $args = array(
            'post_type'      => 'medicament',
            'posts_per_page' => '10',
            'tax_query' => array(
                array(
                    'taxonomy' => 'generic',
                    'field' => 'slug',
                    'terms' => array(sanitize_text_field($_GET['generic'])
                    )
                )
            ),
            'paged' => $paged
        );
    }
    $wp_query = new WP_Query($args);
    $med_types = get_terms( array(
        'taxonomy' => 'med-type',
    ) );
?>
<div class="medicaments-main-container">
    <section class="main-content">
        <aside class="med-categories">
            <div class="header-static">
                <div class="medicaments-search">
                    <form action="<?php echo bloginfo('url');?>/medicaments" id="med-search-form">
                    <label><?php echo _e('ჩაწერეთ მედიკამენტის დასახელება', 'hbtech'); ?></label>
                        <div class="medicaments-input-container">
                            <input type="text" name="q" value="<?php echo $search_keyword;?>" id="med-search-input" autocomplete="off">
                            <fieldset class="inline-block">
                                <label for="submit_meds" class="no-margin icon-label fa fa-search search-icon"></label>
                                <input type="submit" name="submitted" id="submit_meds" class="display-none">
                            </fieldset>

                            <div class="suggestions-container">
                                <ul>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <ul class="med-categories-ul">
                <li data-id="" class="selected"><?php echo _e('ყველა', 'hbtech'); ?></li>
                <?php foreach ($med_types as $med_type) : ?>
                    <li data-id="<?php echo $med_type -> term_id ?>">
                        <?php echo $med_type -> name; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <main class="meds-main-content">
            <div class="static-header-container">
                <h1><?php echo $post -> post_title; ?></h1>
            </div>
        
            <div class="medicaments-container">
                <?php foreach ($wp_query -> posts as $med) : ?>
                    <div class="medicaments">
                        <div class="medicaments-image"
                            style="
                                background-image: url(<?php echo get_field('image', $med)['url'];?>);
                                background-size: cover;
                                background-position: center center;
                                background-repeat: no-repeat;
                            ">
                        </div>

                        <div class="medicaments-content-wrapper">
                            <div class="medicaments-header">
                                <h1><?php echo $med -> post_title; ?></h1>
                            </div>

                            <div class="medicaments-content">
                                <?php
                                    $not_available = new stdClass();
                                    $not_available->name = __('არ არის ხელმისაწვდომი', 'hbtech');
                                    $not_available->slug = '#';

                                    $producer = !empty(wp_get_post_terms( $med->ID, 'producer')) ? wp_get_post_terms( $med->ID, 'producer')[0]: $not_available;
                                    $country  = !empty(wp_get_post_terms( $med->ID, 'country')) ? wp_get_post_terms( $med->ID, 'country')[0]: $not_available;
                                    $group    = !empty(wp_get_post_terms( $med->ID, 'group')) ? wp_get_post_terms( $med->ID, 'group')[0]: $not_available;
                                    $generic  = !empty(wp_get_post_terms( $med->ID, 'generic')) ? wp_get_post_terms( $med->ID, 'generic')[0]: $not_available;

                                    $blog_url = get_home_url() . '/medicaments';
                                ?>
                                <span><?php _e('მწარმოებელი:', 'hbtech');?></span>
                                <a href="<?php echo $blog_url.'?producer='.$producer->slug;?>"><span><?php echo  $producer->name?></span></a>
                                <br>
                                <span><?php _e('მწარმოებელი ქვეყანა:', 'hbtech');?></span>
                                <a href="<?php echo $blog_url.'?country='.$country->slug;?>"><span><?php echo  $country->name?></span></a>
                                <br>
                                <span><?php _e('ფარმაცეფტული ჯგუფი:', 'hbtech');?></span>
                                <a href="<?php echo $blog_url.'?group='.$group->slug;?>"><span><?php echo $group ->name?></span></a>
                                <br>
                                <span><?php _e('ჯენერიკული დასახელება:', 'hbtech');?></span>
                                <a href="<?php echo $blog_url.'?generic='.$generic->slug;?>"><span><?php echo  $generic->name?></span></a>
    <!--                            --><?php //echo get_field('content', $med, true); ?>
                            </div>

                            <div class="medicaments-more">
                                <a href="<?php echo get_permalink($med); ?>">
                                    <?php echo _e('ვრცლად', 'hbtech'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (function_exists("pagination")) {
                    pagination($wp_query->max_num_pages);
                } ?>
            </div>
        </main>
    </section>
</div>

<?php get_footer(); ?>

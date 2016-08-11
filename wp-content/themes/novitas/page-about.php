<?php
/* Template Name: About */
?>
<?php
/* Template Name: front-page */
?>
<?php	get_header(); ?>
<div class="about-page-image relative" style="
    background-image: url(<?php echo get_field('background_image')['sizes']['large']; ?>);
    ">
    <div class="about-header-container wrapper">
        <div class="static-header-container">
            <h1><?php echo $post->post_title;?></h1>
        </div>
    </div>
</div>
<div class="about-us-page">
    <div class="about-container wrapper">
        <div class="gallery-header">
            <div class="gallery-switcher-container about-switcher-container">
                <span class="gallery-switcher switcher active" data-target="about-us">ჩვენ შესახებ</span>
                <span class="gallery-switcher switcher" data-target="our-goals">ჩვენი მიზნები</span>
            </div>
        </div>
        <section class="image-gallery gallery-tab tab" data-id="about-us">
           <?php echo get_field('description');?>
        </section>
        <section class="video-gallery gallery-tab tab" data-id="our-goals">
            <?php echo get_field('our_goals');?>
        </section>
    </div>
</div>
<?php get_footer(); ?>


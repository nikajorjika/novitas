<?php get_header(); ?>

<div class="medicaments-main-container">
    <section class="main-content">
        <div class="header-static wrapper">
            <div class="static-header-container">
                <h1><?php echo $post -> post_title; ?></h1>
            </div>
        </div>
        <div class="single-medicaments-container">
            <div class="single-medicaments-col">
                <div class="single-medicaments-img" style="
                    background: url(<?php echo get_field('image')['url']; ?>) no-repeat;
                    -webkit-background-size: contain;
                    -moz-background-size: contain;
                    -o-background-size: contain;
                    background-size: contain;
                    background-position: center;
                    "></div>
            </div>

            <div class="single-medicaments-col">
                <?php echo get_field('content'); ?>
            </div>
        </div>

        <div class="single-medicaments-image image-gallery">
            <ul>
                <?php foreach(get_field('gallery') as $image):?>
                    <li>
                        <a class="fancybox medicaments-item" href="<?php echo $image['url']; ?>" rel="gallery">
                            <div class="gallery-item" style="
                                background: url(<?php echo $image['sizes']['medium_large']; ?>) no-repeat;
                                -webkit-background-size: cover;
                                -moz-background-size: cover;
                                -o-background-size: cover;
                                background-size: cover;
                                "></div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </section>
</div>

<script type="text/javascript">
    (function() {
        var meds_nav_item = document.getElementsByClassName("menu-item-35");
        for (var i = 0; i < meds_nav_item.length; i++) {
            meds_nav_item[i].className += " current-menu-item";
        }
    })();
</script>

<?php get_footer();?>

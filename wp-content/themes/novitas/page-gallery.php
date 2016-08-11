<?php
/* Template Name: Gallery */
?>

<?php	get_header(); ?>
<div class="gallery-page-before">
    <div class="gallery-container">
        <div class="gallery-header">
            <div class="static-header-container">
                <h1>გალერეა</h1>
            </div>
            <div class="gallery-switcher-container">
                <span class="gallery-switcher switcher active" data-target="image">
                    ფოტო <i class="fa fa-picture-o" aria-hidden="true"></i>
                </span>
                <span class="gallery-switcher switcher" data-target="video">
                    ვიდეო <i class="fa fa-video-camera" aria-hidden="true"></i>
                </span>
            </div>
        </div>
        <section class="image-gallery gallery-tab tab" data-id="image">
            <ul>
                <?php foreach(get_field('image_gallery') as $image):?>
                    <li>
                        <a class="fancybox images" href="<?php echo $image['url']; ?>" rel="gallery">
                            <div class="nj-content-image-item-container">
                                <div class="gallery-item" style="
                                    background: url(<?php echo $image['sizes']['medium_large']; ?>) no-repeat;
                                    -webkit-background-size: cover;
                                    -moz-background-size: cover;
                                    -o-background-size: cover;
                                    background-size: cover;
                                    "></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </section>
        <section class="video-gallery gallery-tab tab" data-id="video">
            <ul>

                <?php foreach(get_field('video_gallery') as $video):?>
                    <li>
                        <a class="fancybox videos" href="<?php echo $video['video_url']; ?>?autoplay=1" rel="gallery">
                            <div class="gallery-item" style="
                                    background: url(<?php echo $video['frame_image']['sizes']['medium_large']; ?>) no-repeat;
                                    -webkit-background-size: cover;
                                    -moz-background-size: cover;
                                    -o-background-size: cover;
                                    background-size: cover;
                                    ">
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </section>
    </div>
</div>
<?php get_footer(); ?>


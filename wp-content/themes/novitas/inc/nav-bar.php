<?php
$args = array('theme_location' => 'primary');
?>

<nav class="nav">
    <div class="nav-inner-wrapper">
        <div class="nav-logo-row">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="" class="logo">
                <!--            <div class="logo"></div>-->
            </a>
        </div>

        <div class="nav-inner">
            <div class="hamburger-menu">
                <div id="nav-icon1">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="main-menu-wrapper">
                <?php wp_nav_menu($args); ?>
            </div>
            <div class="langs">
                <?php language_selector_custom() ?>
            </div>
<!--            <div class="search">-->
<!--                <i class="fa fa-search search-toggle" aria-hidden="true"></i>-->
<!--                <div class="search-container">-->
<!--                    <form action="--><?php //bloginfo('url'); ?><!--/search/">-->
<!--                        <input type="text" name="q" id="search-query">-->
<!--                        <fieldset class="submit-set">-->
<!--                            <label for="submit" class="fa fa-search search-label"></label>-->
<!--                            <input type="submit" name="submitted" id="submit">-->
<!--                        </fieldset>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</nav>

<div class="menu-content">
    <?php wp_nav_menu($args); ?>
</div>
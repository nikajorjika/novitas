<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width">
  <title><?php bloginfo('name') ?></title>
  <link rel="icon" href="/novitas/inc/themes/novitas/images/icon.png">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="opacity-div"></div>
<?php $theme_directory = get_template_directory();?>
<?php $theme_uri = get_template_directory_uri();?>
<?php include($theme_directory."/inc/nav-bar.php");?>
<?php if(is_front_page()):?>
  <style>
    ul.menu li:first-child::before, ul.menu li:first-child::after {
      content: '';
      height: 4px;
      width: 0;
      position: absolute;
      background-color: #336699;
      -webkit-transition: all 0.2s;
      -moz-transition: all 0.2s;
      -ms-transition: all 0.2s;
      -o-transition: all 0.2s;
      transition: all 0.2s;
    }
    ul.menu li:first-child::before {
      top: 0;
      left: 0;
      width:100%;
    }
    ul.menu li:first-child::after {
      bottom: 0;
      right: 0;
      width:100%;
    }
  </style>
<?php endif;?>
<div  class="page-wrap">



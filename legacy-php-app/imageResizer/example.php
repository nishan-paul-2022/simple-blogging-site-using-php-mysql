<?php
    use \BenMajor\ImageResize\Image;
    require 'vendor/autoload.php';
    $image = new Image("images/image_bulbon.gif");
    $image->resize( 800, 534 );
    unlink("images/image_bulbon.gif");
    $image->output("images");
?>
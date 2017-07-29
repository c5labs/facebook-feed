<?php
defined('C5_EXECUTE') or die('Access Denied.');

/*
 * This file is part of Facebook Feed.
 *
 * (c) Oliver Green <oliver@c5labs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (isset($no_configuration)) { ?>

<div class="block-boilerplate">
    <span>Ooops! There are no Facebook accounts configured.</span>
</div>

<?php } elseif (isset($feed_errors)) { ?>

<div class="block-boilerplate">
    <span>Ooops! There was an error getting the Facebook posts, check the log for errors.</span>
</div>

<?php } else {

foreach ($posts as $post) { ?>

<div class="col-md-12">
    <div class="post <?php echo $post['type'] ?>">
        <?php if ('video' === $post['type']) { ?>
            <div class="video-wrapper">
                <div class="video container-player" data-src="<?php echo $post['video']['source'] ?>" data-cover="<?php echo $post['full_picture'] ?>"></div>
                <div class="volume-control-wrapper"><i class="fa fa-volume-off fa-2x volume-control"></i></div>
            </div>
        <?php } elseif (isset($post['full_picture'])) { ?>
            <img src="<?php echo $post['full_picture'] ?>" alt="<?php echo $post['message'] or '' ?>">
        <?php } ?>
        <?php if (isset($post['message'])) { ?>
            <p style="<?php echo empty($post['full_picture']) ? 'font-size: 1.5em; line-height: 1.5em;' : '' ?>"><?php echo $post['message'] ?></p>
        <?php } ?>
        <span class="post-meta">
        <!--<a href="http://facebook.com/richleemotorco" target="_blank" style="display: inline-block; float: right;"><i class="fa fa-facebook-square fa-2x"></i></a>!-->
        <?php echo $post['human_date'] ?></span>
    </div>    
</div>
<?php } } ?>
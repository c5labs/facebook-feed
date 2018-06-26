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

/*
 * No facebook account connected.
 */
if (isset($no_configuration)) { ?>

    <div class="block-boilerplate">
        <span>Ooops! There are no Facebook accounts configured.</span>
    </div>

<?php
/*
 * Errors were thrown while trying to get the feed.
 */
 } elseif (isset($feed_errors)) { ?>

    <div class="block-boilerplate">
        <span>Ooops! There was an error getting the Facebook posts, check the log for errors.</span>
    </div>

<?php 

/*
 * We have posts, lets show them...
 */
} else { ?>

<div id="facebookFeed<?php echo $bID; ?>" class="facebook-feed-container">

    <?php 
    /*
     * Loop through each post which can have various keys set that you can find here:
     */
    if (count($posts) > 0) {
    foreach ($posts as $post) { ?>

        <div class="facebook-feed-post <?php echo $post['type'] ?>">

            <!-- Event !-->
            <?php if ('event' === $post['type']) { ?>
                <?php if (isset($post['cover']) && isset($post['cover']['source'])) { ?>
                <img src="<?php echo $post['cover']['source'] ?>" alt="<?php echo $post['description'] or '' ?>">
                <?php } ?>
                <?php echo $post['description']; ?> 
                
            <!-- Video !-->
            <?php } elseif ('video' === $post['type']) { ?>
                <?php if (!empty($post['source'])) { ?>
                <div class="video-wrapper">
                    <div class="video container-player" data-src="<?php echo $post['source']; ?>" data-cover="<?php echo $post['full_picture']; ?>"></div>
                    <div class="volume-control-wrapper"><i class="fa fa-volume-off fa-2x volume-control"></i></div>
                </div>
                <?php } ?>

            <!-- Regular posts with many images !-->
            <?php } elseif (isset($post['parsed_images'])) { ?>
                <div class="owl-carousel owl-theme">
                    <?php foreach ($post['parsed_images'] as $image) { ?>
                    <div class="item">
                        <div style="background-image: url(<?php echo $image; ?>);"></div>
                        <img data-src="<?php echo $image; ?>" src="#">
                    </div>
                    <?php } ?>
                </div>

            <!-- Regular post with single image !-->
            <?php } else { ?>
                <?php if (isset($post['full_picture'])) { ?>
                    <img src="<?php echo $post['full_picture'] ?>" alt="<?php echo $post['message'] or '' ?>">
                <?php } ?>
            <?php } ?>

            <?php if (isset($post['message'])) { ?>
                <p style="<?php echo empty($post['full_picture']) ? 'font-size: 1.5em; line-height: 1.5em;' : '' ?>"><?php echo $post['message'] ?></p>
            <?php } ?>
            <span class="post-meta"><?php echo $post['human_date'] ?></span>
        </div>    

    <?php } ?>
    <?php } else { ?>
        <span>There are no posts to display.</span>
    <?php } ?>
</div>
<?php } ?>
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
    <div class="col-md-12">
        <div class="facebook-feed-post <?php echo $post['type'] ?>">
            <?php if (isset($post['full_picture'])) { ?>
                <img src="<?php echo $post['full_picture'] ?>" alt="<?php echo $post['message'] or '' ?>">
            <?php } ?>
            <?php if (isset($post['message'])) { ?>
                <p style="<?php echo empty($post['full_picture']) ? 'font-size: 1.5em; line-height: 1.5em;' : '' ?>"><?php echo $post['message'] ?></p>
            <?php } ?>
            <span class="facebook-feed-post-meta"><?php echo $post['human_date'] ?></span>
        </div>    
    </div>
    <?php } ?>
    <?php } else { ?>
        <span>There are no posts to display.</span>
    <?php } ?>
</div>
<?php } ?>
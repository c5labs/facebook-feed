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
?>
<style>
    .card { padding: 20px 0; }
    .card input { display: inline-block; }
    .card div { display: inline-block; }
    .card .img-div { margin: 0 10px; display: inline-block; vertical-align: middle; width: 50px; height: 50px; background-position: center; background-size: cover;  }
</style>
<div id="blockBoilerplateForm">
<?php if (isset($feed_errors)) { ?>

    <p>There were errors getting the list of available profiles from Facebook, check the log for more details.</p>

<?php } elseif (!isset($no_configuration)) { ?>

    <div class="row">
        <div class="col-xs-12">
            <p>Facebook wall allows you to show posts from a Facebook wall.</p>
        </div>
        <div class="col-xs-12">
            <hr style="margin: 30px 0; display: block;">
            Show posts from:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <input type="radio" name="object_id" id="me" value="me" <?php echo (isset($object_id) && 'me' === $object_id || empty($object_id)) ? 'checked="checked"' : '' ?>>
                <label for="me">
                    <div class="img-div" style="background-image: url(<?php echo $user->getPictureUrl(); ?>);" alt="<?php echo $user->getName(); ?>"></div>
                    <?php echo $user->getName(); ?>
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <hr style="margin: 30px 0; display: block;">
            Show posts from my <strong>Facebook Page</strong>:
        </div>
    </div>
    <div class="row">
    <?php if (count($pages) > 0) { ?>
    <?php foreach ($pages as $page) { ?>
        <div class="col-xs-12">
            <div class="card">
                <input type="radio" name="object_id" id="<?php echo $page['id']; ?>" value="<?php echo $page['id']; ?>" <?php echo (isset($object_id) && intval($page['id']) === intval($object_id)) ? 'checked="checked"' : '' ?>">
                <label for="<?php echo $page['id']; ?>">
                    <div class="img-div" style="background-image: url(<?php echo $page['picture']['data']['url']; ?>);" alt="<?php echo $page['name']; ?>"></div>
                    <?php echo $page['name']; ?>
                </label>
            </div>
        </div>
    <?php } ?>
    <?php } else { ?>
        <div class="col-xs-12">
            <p>You have no pages associated with your account.</p>
        </div>
    <?php } ?>
    </div>

<?php } else { ?>

    <p>You must connect a Facebook account before adding the block to a page.</p>
    <a style="margin-top: 30px;" href="<?php echo View::url('/dashboard/system/facebook_feed/facebook'); ?>" class="btn btn-primary">Connect</a>

<?php } ?>
</div>
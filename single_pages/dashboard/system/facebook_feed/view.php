<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<style>
    .provider h2 { margin: 5px 0 0; }
    .provider .provider-status { color: green; font-weight: bold; margin: 10px 0 20px; }
    .provider-inactive { color: #999; }
    .provider.provider-inactive .provider-status { color: #999; font-weight: normal; }
}
</style>
<div class="row">
    <div class="col-xs-12">
        <p>Facebook feed allows you to display posts from your wall or any page that you manage throught your site via the 'Facebook Feed' block.</p>
    </div>
    <div class="col-xs-12">
        <h3 style="margin-top: 30px;">Accounts</h3>
        <hr style="margin: 30px 0; display: block;">
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-center provider <?php if (!isset($facebook)) { ?>provider-inactive<?php } ?>">
        <i class="fa fa-facebook fa-5x"></i>
        <h2>Facebook</h2>
        <?php if (!isset($facebook)) { ?>
            <div class="provider-status">Not connected</div>
            <a href="<?php echo View::url('/dashboard/system/facebook_feed/facebook'); ?>" class="btn btn-primary">Connect</a>
        <?php } else { ?>
            <div class="provider-status">Connected as <?php echo $facebook['connected_as']; ?></div>
            <a href="<?php echo View::url('/dashboard/system/facebook_feed/facebook'); ?>" class="btn btn-primary">Re-connect</a>
            <a href="<?php echo View::url('/dashboard/system/facebook_feed/disconnect/?provider=facebook-feed&ccm_token='.$this->controller->token->generate('disconnect')); ?>" class="btn btn-default" onclick="return confirm('Are you sure you want to disconnect Facebook?');">Disconnect</a>
        <?php } ?>
    </div>
</div>
<div class="row" style="margin-top: 35px;">
    <div class="col-xs-12">
        <h3>Settings</h3>
        <hr style="margin: 30px 0; display: block;">
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <span>Feed Cache TTL:</span>
        <strong style="display: inline-block; margin-left: 10px;"><?php echo $cache_ttl; ?> seconds</strong> 
    </div>
    <div class="col-xs-12" style="margin-top: 30px;">
        <a href="<?php echo View::url('/dashboard/system/facebook_feed/settings'); ?>" class="btn btn-primary">Change Settings</a>
    </div>
</div>
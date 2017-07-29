<div class="row" style="margin-top: 20px;">
    <div class="col-sm-12">
    <?php if (!isset($no_configuration)) { ?>
        <form action="<?php  echo $this->action('save'); ?>" method="POST">
            <?php echo $this->controller->token->output('save'); ?>
            <div class="form-group" id="fileSets">
                <?php echo $form->label('cache_ttl', t('Feed Cache TTL (Seconds)')); ?>
                <?php echo $form->text('cache_ttl', $cache_ttl, ['style' => 'margin-left: 10px;']); ?>
            </div>
            <div class="ccm-dashboard-form-actions-wrapper">
                <div class="ccm-dashboard-form-actions">
                    <button class="pull-right btn btn-success" type="submit" ><?php  echo t('Save')?></button>
                </div>
            </div>
        </form>  
    <?php } else { ?>
        <p>You must connect a Facebook account before setting the configuration.</p>
        <a style="margin-top: 30px;" href="<?php echo View::url('/dashboard/system/facebook_feed/facebook'); ?>" class="btn btn-primary">Connect</a>
    <?php } ?>
    </div>
</div>
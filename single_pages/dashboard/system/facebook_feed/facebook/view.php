<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="row">
    <div class="col-sm-12">
        <p>To read from your Facebook account you will need an application id and secret, you can find a video of how to obtain these at the bottom of this page. Once you have these, please enter them below and click 'Connect Account'.</p>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-sm-12">
        <form action="<?php  echo $this->action('authorize'); ?>" method="POST">
            <?php echo $this->controller->token->output('authorize'); ?>
            <div class="form-group" id="fileSets">
                <?php echo $form->label('publicize_facebook[identifier]', t('Facebook Application ID')); ?>
                <?php echo $form->text('publicize_facebook[identifier]', $publicize_facebook['identifier']); ?>
            </div>
            <div class="form-group" id="fileSets">
                <?php echo $form->label('publicize_facebook[secret]', t('Facebook Application Secret')); ?>
                <?php echo $form->text('publicize_facebook[secret]', $publicize_facebook['secret']); ?>
            </div>
            <button type="submit" class="btn btn-primary">Connect Account</button>
        </form>  
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
    <hr style="margin: 40px 0;">
    <h3>How to setup a Facebook application</h3>
    <p>The video below walks through how to obtain an application ID &amp; secret from Facebook.</p>
    <iframe width="854" height="480" src="https://www.youtube.com/embed/txCfgVmsR7g" frameborder="0" allowfullscreen style="margin-top: 20px;"></iframe>
    </div>
</div>
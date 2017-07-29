<?php

namespace Concrete\Package\FacebookFeed\Controller\SinglePage\Dashboard\System;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Page\Type\Type as PageType;
use Core;
use View;

class FacebookFeed extends DashboardPageController
{
    protected $manager;

    public function __construct(\Concrete\Core\Page\Page $c)
    {
        parent::__construct($c);

        $this->manager = Core::make('authify.manager');
    }

    public function view() 
    {
        $this->set('form', Core::make('helper/form'));

        if ($this->manager->has('facebook-feed')) {
            $this->set('facebook', $this->manager->getCredentialsStore()->get('facebook-feed'));
        }

        $data = $this->manager->getConfigurationStore()->get('facebook');

        $cache_ttl = 60 * 60 * 6;

        if (isset($data['feed']) && isset($data['feed']['cache_ttl'])) {
            $cache_ttl = $data['feed']['cache_ttl'];
        }

        $this->set('cache_ttl', $cache_ttl);
    }

    public function disconnect()
    {
        if ($this->token->validate('disconnect', $_POST['ccm_token'])) {
            $handle = $_GET['provider'];

            if ($this->manager->has($handle)) {
                $this->manager->destroy($handle);
            }
        }

        header('Location: '.View::url('/dashboard/system/facebook-feed'));
    }
}
<?php

namespace Concrete\Package\FacebookFeed\Controller\SinglePage\Dashboard\System\FacebookFeed;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Page\Type\Type as PageType;
use Core;
use View;

class Settings extends DashboardPageController
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
            $data = $this->manager->get('facebook-feed')->getConfiguration();

            $cache_ttl = 60 * 60 * 6; // 6 Hour default

            if (isset($data['feed']) && isset($data['feed']['cache_ttl'])) {
                $cache_ttl = $data['feed']['cache_ttl'];
            }

            $this->set('cache_ttl', $cache_ttl);
        } else {
            $this->set('no_configuration', true);
        }
    }

    public function save()
    {
        if ($this->token->validate('save', $_POST['ccm_token'])) {
            $this->manager->getConfigurationStore()->put(
                'facebook.feed.cache_ttl', $_POST['cache_ttl']
            );
        }

        header('Location: '. View::url('/dashboard/system/facebook_feed'));

        exit;
    }
}
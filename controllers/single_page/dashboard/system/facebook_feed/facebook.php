<?php

namespace Concrete\Package\FacebookFeed\Controller\SinglePage\Dashboard\System\FacebookFeed;

use View;
use Core;
use Concrete\Core\Page\Controller\DashboardPageController;

class Facebook extends DashboardPageController
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
        $this->set('publicize_facebook', $this->manager->getConfigurationStore()->get('facebook'));
        $this->set('callback_uri', $this->getCallbackUri());
    }

    protected function getCallbackUri()
    {
        return View::url('/dashboard/system/facebook_feed/facebook/exchange');
    }

    public function authorize()
    {
        if ($this->token->validate('authorize', $_POST['ccm_token'])) {
            $data = (array) $_POST['publicize_facebook'];
            $data['callback_uri'] = $this->getCallbackUri();
            $this->manager->getConfigurationStore()->put('facebook', $data);
            
            $this->manager->make('facebook', 'facebook-feed')->authorize(
                ['email', 'pages_show_list']
            );
        }
    }

    public function exchange()
    {
        $provider = $this->manager->make('facebook', 'facebook-feed');
        $provider->exchange($_GET);
        $user = $provider->getResourceOwner();
        $this->manager->save($provider);
        $data = ['connected_as' => $user->getName()];
        $this->manager->getCredentialsStore()->put('facebook-feed', $data, true);

        header('Location: '. View::url('/dashboard/system/facebook_feed'));
        exit;
    }
}
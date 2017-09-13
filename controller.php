<?php
/**
 * Facebook Feed Controller File.
 *
 * @author   Oliver Green <oliver@c5labs.com>
 * @license  See attached license file
 */
namespace Concrete\Package\FacebookFeed;

use BlockType;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Type;
use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Single as SinglePage;
use Core;
use Illuminate\Filesystem\Filesystem;

defined('C5_EXECUTE') or die('Access Denied.');

/**
 * Package Controller Class.
 *
 * Automatically share pages to Facebook & Twitter.
 *
 * @author   Oliver Green <oliver@c5labs.com>
 * @license  See attached license file
 */
class Controller extends Package
{
    /**
     * Minimum version of concrete5 required to use this package.
     * 
     * @var string
     */
    protected $appVersionRequired = '5.7.5';

    /**
     * Does the package provide a full content swap?
     * This feature is often used in theme packages to install 'sample' content on the site.
     *
     * @see https://goo.gl/C4m6BG
     * @var bool
     */
    protected $pkgAllowsFullContentSwap = false;

    /**
     * Does the package provide thumbnails of the files 
     * imported via the full content swap above?
     *
     * @see https://goo.gl/C4m6BG
     * @var bool
     */
    protected $pkgContentProvidesFileThumbnails = false;

    /**
     * Should we remove 'Src' from classes that are contained 
     * ithin the packages 'src/Concrete' directory automatically?
     *
     * '\Concrete\Package\MyPackage\Src\MyNamespace' becomes '\Concrete\Package\MyPackage\MyNamespace'
     *
     * @see https://goo.gl/4wyRtH
     * @var bool
     */
    protected $pkgAutoloaderMapCoreExtensions = false;

    /**
     * Package class autoloader registrations
     * The package install helper class, included with this boilerplate, 
     * is activated by default.
     *
     * @see https://goo.gl/4wyRtH
     * @var array
     */
    protected $pkgAutoloaderRegistries = [
        //'src/MyVendor/Statistics' => '\MyVendor\ConcreteStatistics'
    ];

    /**
     * The packages handle.
     * Note that this must be unique in the 
     * entire concrete5 package ecosystem.
     * 
     * @var string
     */
    protected $pkgHandle = 'facebook-feed';

    /**
     * The packages version.
     * 
     * @var string
     */
    protected $pkgVersion = '0.9.0';

    /**
     * The packages name.
     * 
     * @var string
     */
    protected $pkgName = 'Facebook Feed';

    /**
     * The packages description.
     * 
     * @var string
     */
    protected $pkgDescription = 'Shows a persons or pages Facebook posts in an elegant way.';

    /**
     * Package service providers to register.
     * 
     * @var array
     */
    protected $providers = [
        // Register your concrete5 service providers here
        'Concrete\Package\FacebookFeed\Src\Providers\AuthifyServiceProvider',
    ];

    /**
     * Register the packages defined service providers.
     * 
     * @return void
     */
    protected function registerServiceProviders()
    {
        $list = new ProviderList(Core::getFacadeRoot());

        foreach ($this->providers as $provider) {
            $list->registerProvider($provider);

            if (method_exists($provider, 'boot')) {
                Core::make($provider)->boot($this);
            }
        }
    }

    /**
     * Boot the packages composer autoloader if it's present.
     * 
     * @return void
     */
    protected function bootComposer()
    {
        $filesystem = new Filesystem();
        $path = __DIR__.'/vendor/autoload.php';

        if ($filesystem->exists($path)) {
            $filesystem->getRequire($path);
        }
    }

    /**
     * The packages on start hook that is fired as the CMS is booting up.
     * 
     * @return void
     */
    public function on_start()
    {
        // Boot composer
        $this->bootComposer();
        // Register defined service providers
        $this->registerServiceProviders();

        // Register our assets with the pipeline.
        $this->registerAssets();

        // Add custom logic here that needs to be executed during CMS boot, things
        // such as registering services, assets, etc.
    }

    /**
     * The packages install routine.
     * 
     * @return \Concrete\Core\Package\Package
     */
    public function install()
    {
        // Boot composer
        $this->bootComposer();

        // Add your custom logic here that needs to be executed BEFORE package install.

        $pkg = parent::install();

        // Register defined service providers
        $this->registerServiceProviders();

        // Install settings pages.
        $basePage = SinglePage::add('/dashboard/system/facebook_feed', $pkg);
        $basePage->update(array('cName'=>t('Facebook Feed'), 'cDescription'=>''));

        $settingsPage = SinglePage::add('/dashboard/system/facebook_feed/settings', $pkg);
        $settingsPage->update(array('cName'=>t('Facebook Feed Settings'), 'cDescription'=>''));

        $facebookPage = SinglePage::add('/dashboard/system/facebook_feed/facebook', $pkg);
        $facebookPage->update(array('cName'=>t('Connect Facebook'), 'cDescription'=>''));
        $facebookPage->setAttribute('exclude_nav', true);

        $bt = BlockType::installBlockType('facebook_feed', $pkg);
        
        return $pkg;
    }

    /**
     * The packages upgrade routine.
     * 
     * @return void
     */
    public function upgrade()
    {
        // Add your custom logic here that needs to be executed BEFORE package install.

        parent::upgrade();

        // Add your custom logic here that needs to be executed AFTER package upgrade.
    }

    /**
     * The packages uninstall routine.
     * 
     * @return void
     */
    public function uninstall()
    {
        // Add your custom logic here that needs to be executed BEFORE package uninstall.
        $configurationRepository = Core::make(
            \Concrete\Core\Config\Repository\Repository::class
        );

        if (count($configurationRepository->get('concrete.authify.credentials')) > 1) {
            $configurationRepository->save('concrete.authify.credentials.facebook-feed', null);
        } else {
            $configurationRepository->save('concrete.authify', null);
        }

        parent::uninstall();

        // Add your custom logic here that needs to be executed AFTER package uninstall.
    }

    protected function registerAssets()
    {
        $al = AssetList::getInstance();

        // Container player
        $al->register(
                'css', 'container.player/css', 'node_modules/container.player/dist/container.player.min.css',
                array(
                    'version' => '0.9.1', 'position' => Asset::ASSET_POSITION_HEADER, 
                    'minify' => true, 'combine' => false
                ), $this
        );

        $al->register(
                'javascript', 'container.player/js', 'node_modules/container.player/dist/container.player.min.js',
                array(
                    'version' => '0.9.1', 'position' => Asset::ASSET_POSITION_FOOTER, 
                    'minify' => true, 'combine' => false
                ), $this
        );

        $al->registerGroup(
            'container.player',
            array(
                array('css', 'container.player/css'), 
                array('javascript', 'container.player/js'),
                array('javascript', 'jquery')
            )
        );

        // Owl Carousel
        $al->register(
                'css', 'owl.carousel/css', array(
                    'node_modules/owl.carousel/dist/assets/owl.carousel.min.css',
                    'node_modules/owl.carousel/dist/assets/owl.theme.default.min.css',
                ),
                array(
                    'version' => '2.2.0', 'position' => Asset::ASSET_POSITION_HEADER, 
                    'minify' => true, 'combine' => false
                ), $this
        );

        $al->register(
                'javascript', 'owl.carousel/js', 'node_modules/owl.carousel/dist/owl.carousel.min.js',
                array(
                    'version' => '2.2.0', 'position' => Asset::ASSET_POSITION_FOOTER, 
                    'minify' => true, 'combine' => false
                ), $this
        );

        $al->registerGroup(
            'owl.carousel',
            array(
                array('css', 'owl.carousel/css'), 
                array('javascript', 'owl.carousel/js'),
                array('javascript', 'jquery')
            )
        );
    }
}

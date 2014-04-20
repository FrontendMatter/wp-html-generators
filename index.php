<?php
/*
Plugin Name: WP Composer Package
Plugin URI: http://mosaicpro.biz
Description: WordPress Plugin as Composer package
Version: 1.0
Author: MosaicPro
Author URI: http://mosaicpro.biz
*/

// include the autoloader
include dirname(__FILE__) . '/vendor/autoload.php';

// include the illuminate/support helpers
require_once dirname(__FILE__) . '/vendor/illuminate/support/Illuminate/Support/helpers.php';

// instantiate the container
$app = new \Illuminate\Container\Container;
$app->bind('app', $app);
$app->bind('request', function(){
    return new \Illuminate\Http\Request;
});
$app['env'] = "";

// bind the config component to the container
$app->bindShared('config', function($app)
{
    $configPath = __DIR__ . '/../config';
    $environment = 'production';

    $file = new \Illuminate\Filesystem\Filesystem;
    $loader = new \Illuminate\Config\FileLoader($file, $configPath);
    $config = new \Illuminate\Config\Repository($loader, $environment);
    return $config;
});

// session
$app['config']['session.driver'] = 'array';
$app->bindShared('session', function($app)
{
    return new \Illuminate\Session\SessionManager($app);
});
$app->bindShared('session.store', function($app)
{
    $manager = $app['session'];
    return $manager->driver();
});

// define the providers
$providers = array(
    'Illuminate\Events\EventServiceProvider',
    'Illuminate\Routing\RoutingServiceProvider'
);

// Register the providers
$registered = [];
foreach ($providers as $provider) {
    $instance = new $provider($app);
    $instance->register();
    $registered[] = $instance;
}

// Boot the providers
foreach ($registered as $instance)
    $instance->boot();

// bind the html builder to the container
$app->bindShared('html', function($app)
{
    return new \Illuminate\Html\HtmlBuilder($app['url']);
});

// bind the form builder to the container
$app->bindShared('form', function($app)
{
    $form = new \Illuminate\Html\FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());
    return $form->setSessionStore($app['session.store']);
});

// register mosaicpro/form config package
$app['config']->package('mosaicpro/form', __DIR__ . '/vendor/mosaicpro/form/src/config');

// register the container
\Mosaicpro\Core\IoC::setContainer($app);

// create shorter aliases for the components
class_alias('Mosaicpro\Accordion\Accordion', 'Accordion');
class_alias('Mosaicpro\Alert\Alert', 'Alert');
class_alias('Mosaicpro\Button\Button', 'Button');
class_alias('Mosaicpro\ButtonGroup\ButtonGroup', 'ButtonGroup');
class_alias('Mosaicpro\Carousel\Carousel', 'Carousel');
class_alias('Mosaicpro\Dropdown\Dropdown', 'Dropdown');
class_alias('Mosaicpro\Form\FormField', 'FormField');
class_alias('Mosaicpro\Form\Checkbox', 'Checkbox');
class_alias('Mosaicpro\ListGroup\ListGroup', 'ListGroup');
class_alias('Mosaicpro\Media\Media', 'Media');
class_alias('Mosaicpro\Modal\Modal', 'Modal');
class_alias('Mosaicpro\Nav\Nav', 'Nav');
class_alias('Mosaicpro\Navbar\Navbar', 'Navbar');
class_alias('Mosaicpro\Panel\Panel', 'Panel');
class_alias('Mosaicpro\ProgressBar\ProgressBar', 'ProgressBar');
class_alias('Mosaicpro\Tab\Tab', 'Tab');
class_alias('Mosaicpro\Table\Table', 'Table');
class_alias('Mosaicpro\Grid\Grid', 'Grid');

add_action('admin_enqueue_scripts', function()
{
    wp_enqueue_script('mosaicpro-wp-admin-bootstrap', plugin_dir_url(__FILE__) . 'assets/bootstrap/js/bootstrap.min.js', ['jquery'], '3.1.1', true);
    wp_enqueue_style('mosaicpro-wp-admin-theme', plugin_dir_url(__FILE__) . 'assets/bootstrap/css/wp-admin-theme.css', []);
});
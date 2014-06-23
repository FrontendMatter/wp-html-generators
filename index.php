<?php
/*
Plugin Name: WP HTML Generators Library
Plugin URI: http://mosaicpro.biz
Description: HTML Generators for WordPress
Version: 1.0.0
Author: MosaicPro
Author URI: http://mosaicpro.biz
*/

// include the autoloader
include dirname(__FILE__) . '/../../../vendor/autoload.php';

// include the illuminate/support helpers
require_once dirname(__FILE__) . '/../../../vendor/illuminate/support/Illuminate/Support/helpers.php';

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

// register mosaicpro/html-generators config package
$app['config']->package('mosaicpro/htmlGenerators', __DIR__ . '/../../../vendor/mosaicpro/html-generators/src/config');

// register the container
\Mosaicpro\HtmlGenerators\Core\IoC::setContainer($app);

// create shorter aliases for the components
class_alias('Mosaicpro\HtmlGenerators\Accordion\Accordion', 'Accordion');
class_alias('Mosaicpro\HtmlGenerators\Alert\Alert', 'Alert');
class_alias('Mosaicpro\HtmlGenerators\Button\Button', 'Button');
class_alias('Mosaicpro\HtmlGenerators\ButtonGroup\ButtonGroup', 'ButtonGroup');
class_alias('Mosaicpro\HtmlGenerators\Carousel\Carousel', 'Carousel');
class_alias('Mosaicpro\HtmlGenerators\Dropdown\Dropdown', 'Dropdown');
class_alias('Mosaicpro\HtmlGenerators\Form\FormField', 'FormField');
class_alias('Mosaicpro\HtmlGenerators\Form\Checkbox', 'Checkbox');
class_alias('Mosaicpro\HtmlGenerators\ListGroup\ListGroup', 'ListGroup');
class_alias('Mosaicpro\HtmlGenerators\Media\Media', 'Media');
class_alias('Mosaicpro\HtmlGenerators\Modal\Modal', 'Modal');
class_alias('Mosaicpro\HtmlGenerators\Nav\Nav', 'Nav');
class_alias('Mosaicpro\HtmlGenerators\Navbar\Navbar', 'Navbar');
class_alias('Mosaicpro\HtmlGenerators\Panel\Panel', 'Panel');
class_alias('Mosaicpro\HtmlGenerators\ProgressBar\ProgressBar', 'ProgressBar');
class_alias('Mosaicpro\HtmlGenerators\Tab\Tab', 'Tab');
class_alias('Mosaicpro\HtmlGenerators\Table\Table', 'Table');
class_alias('Mosaicpro\HtmlGenerators\Grid\Grid', 'Grid');

add_action('admin_enqueue_scripts', function()
{
    wp_enqueue_script('mp-bootstrap', plugin_dir_url(__FILE__) . 'assets/bootstrap/js/bootstrap.min.js', ['jquery'], '3.1.1', true);
    wp_enqueue_style('mp-admin-theme', plugin_dir_url(__FILE__) . 'assets/bootstrap/css/wp-admin-theme.css', [], '3.1.1');
    wp_enqueue_style('mp-font-awesome', plugin_dir_url(__FILE__) . 'assets/font-awesome/css/font-awesome.min.css', [], '4.0.3');
});

add_action('wp_enqueue_scripts', function()
{
    wp_enqueue_script('mp-bootstrap', plugin_dir_url(__FILE__) . 'assets/bootstrap/js/bootstrap.min.js', ['jquery'], '3.1.1', true);
    wp_enqueue_style('mp-front-theme', plugin_dir_url(__FILE__) . 'assets/bootstrap/css/bootstrap-wrapper-3.1.1.css', [], '3.1.1');
});
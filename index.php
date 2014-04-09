<?php
/*
Plugin Name: WP Composer Package
Plugin URI: http://mosaicpro.biz
Description: WordPress Plugin as Composer package
Version: 1.0
Author: MosaicPro
Author URI: http://mosaicpro.biz
*/

add_action('init', function()
{
    // include the autoloader
    include dirname(__FILE__) . '/vendor/autoload.php';

    // include the illuminate/support helpers
    require_once dirname(__FILE__) . '/vendor/illuminate/support/Illuminate/Support/helpers.php';

    // instantiate the container
    $app = new Illuminate\Container\Container;
    $request = new \Illuminate\Http\Request;
    $app->bind('app', $app);
    $app->bind('request', $request);
    $app->bind('env', function(){});
    $app->bind('session.store', function(){});

    // define the providers
    $providers = array(
        'Illuminate\Events\EventServiceProvider',
        'Illuminate\Routing\RoutingServiceProvider',
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
    // used by some components
    $app->bindShared('html', function($app)
    {
        return new \Illuminate\Html\HtmlBuilder($app['url']);
    });

    // bind the form builder to the container
    // used by some components
    $app->bindShared('form', function($app)
    {
        $form = new \Illuminate\Html\FormBuilder($app['html'], $app['url'], '');
        return $form;
    });

    // register the container
    \Mosaicpro\Core\IoC::setContainer($app);

    // alias the components
    class_alias('Mosaicpro\Button\Button', 'Button');
    class_alias('Mosaicpro\Panel\Panel', 'Panel');
});
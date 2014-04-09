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
});
<?php
namespace Phifty\ServiceProvider;
use Phifty\ServiceProvider\ServiceProvider;
use Pux\Mux;
use Pux\Dispatcher\Dispatcher;

class PuxRouterServiceProvider implements ServiceProvider
{
    public function getId()
    {
        return 'router';
    }

    public function register($kernel, $options = array() )
    {
        $kernel->router = function() use ($kernel) {
            return new Mux;
        };
        /*
        $kernel->restful = function() use($kernel) {
            $restful = new \Roller\Plugin\RESTful(array( 
                'prefix' => '/restful'
            ));
            return $restful;
        };
        $kernel->router = function() use ($kernel) {
            $router = null;
            if ('production' === $kernel->environment) {
                $router = new Router(null, array(
                    'route_class' => 'Phifty\\Routing\\Route',
                    'cache_id' => PH_APP_ROOT ? PH_APP_ROOT : $kernel->config->get('framework','uuid'),
                ));
            } else {
                $router = new Router(null, array(
                    'route_class' => 'Phifty\\Routing\\Route',
                ));
            }
            $router->addPlugin($kernel->restful);
            return $router;
        };
        */
    }
}


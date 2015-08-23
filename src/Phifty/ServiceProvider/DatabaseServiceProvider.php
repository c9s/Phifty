<?php
namespace Phifty\ServiceProvider;
use LazyRecord\ConnectionManager;

class DatabaseServiceProvider
    implements ServiceProvider
{

    public function getId() { return 'database'; }

    public function register($kernel, $options = array() )
    {
        $config = $kernel->config->stashes['database'];
        $loader = \LazyRecord\ConfigLoader::getInstance();
        if (! $loader->loaded) {
            $loader->load( $config );
            $loader->init();  // init data source and connection
        }
        $kernel->db = function() {
            return ConnectionManager::getInstance()->getConnection();
        };
    }

}

<?php


namespace Core;

use Core\RenderInterface;
use Core\http\Router\Router;
use Core\Config\ConfigInterface;
use Core\Database\DatabaseInterface;

class PluginManager
{

    public function __construct(
        
        private Router $router,
        private ConfigInterface $config,
        private DatabaseInterface $database,
        private RenderInterface $render

    )
    {
        
    }

    
	

}
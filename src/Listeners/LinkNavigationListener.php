<?php


namespace Source\Listeners;

use Core\Event\EventInterface;
use Core\Event\EventListenerInterface;

class LinkNavigationListener implements EventListenerInterface
{
    public function handle(EventInterface $event): void
    {
        if ($event->getName() === 'link.navigation') {
            echo '<script> console.log("link navigation"); </script>';
        }
    }
}

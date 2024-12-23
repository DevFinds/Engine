<?php


namespace Source\Listeners;

use Core\Event\EventInterface;
use Core\Event\EventListenerInterface;

class FieldErrorListener implements EventListenerInterface
{

    public function handle(EventInterface $event): void
    {
        echo '<script> console.log("error"); </script>';
    }
}

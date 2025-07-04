<?php


namespace Source\Listeners;

use Core\Config\Config;
use Core\Database\Database;
use Core\Event\EventListenerInterface;
use Core\Event\EventInterface;
use Core\http\Redirect;

class LogActionListener implements EventListenerInterface
{


    public function handle(EventInterface $event): void
    {
        error_log('LogActionListener::handle called');
        $database = new Database(new Config);
        try {
            $action_info = json_encode($event->getPayload()['action_info']);
            $database->insert('last_actions', [
            'action_name' => $event->getPayload()['action_name'],
            'actor' => $event->getPayload()['actor_id'],
            'action_info' => $action_info
        ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

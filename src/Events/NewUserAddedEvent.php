<?php


namespace BotRuleEngine\Events;


use BotTemplateFramework\Events\Event;

class NewUserAddedEvent extends Event {

    public $client;

    public function __construct($client) {
        $this->client = $client;
        parent::__construct('newUserAdded');
    }

}